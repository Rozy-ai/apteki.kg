<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\Product;

class CategoryController extends Controller
{
    public function actionIndex()
    {
        $category = Yii::$app->request->get("id", 0);

        $where = ["active" => 1];

        if($category != 0) {
          $where["category_id"] = $category;
        }

        $user_id = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->id;
        $query = Product::find()->joinWith(["availability", "favorite" => function ($query) use ($user_id)  {
          $query->onCondition(['product_favorite.user_id' => $user_id]);
        }])->where($where)->andWhere(["is not", "product_availability.id", null])->orderBy("product.id DESC");
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
