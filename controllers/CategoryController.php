<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use app\models\Product;
use app\models\Category;

class CategoryController extends Controller
{
    public function actionIndex($id = 0)
    {
        $category = Category::findOne(["active" => 1, "id" => $id]);
        if(!$category) {
            throw new NotFoundHttpException('Категория не найдена');
        }

        $categorys = [$category->id];
        if($category->parent_id == 0) {
            $category_query =  Category::find()->where(["active" => 1, "parent_id" => $id])->all();
            foreach ($category_query as $category_item) {
                $categorys[] = $category_item->id;
            }
        }

        $user_id = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->id;
        $query = Product::find()->joinWith(["favorite" => function ($query) use ($user_id)  {
          $query->onCondition(['product_favorite.user_id' => $user_id]);
        }])->where(["active" => 1, 'category_id' => $categorys])->andWhere(["<>", "availability_count", 0])->orderBy("product.id DESC");
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $products = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
          'products' => $products,
          'pages' => $pages
        ]);
    }
}
