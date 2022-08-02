<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\Product;

class SearchController extends Controller
{
    public function actionIndex()
    {
      $q = Yii::$app->request->get("q");
      $type = Yii::$app->request->get("type", 0);

      $where = ["and", ["active" => 1]];

      if($q) {
        array_push($where, ['like', 'name', '%' . $q . '%', false]);
      }

      if($type == 1) {
        array_push($where, ['REGEXP', 'name','^[А-я]']);
      } else if($type == 2) {
        array_push($where, ['REGEXP', 'name','^[A-z]']);
      } else if($type == 3) {
        array_push($where, ['REGEXP', 'name','^[0-9]']);
      }


      $query = Product::find()->where($where)->andWhere(["<>", "availability_count", 0])->orderBy("product.name");
      $countQuery = clone $query;
      $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 50]);
      $products = $query->offset($pages->offset)
          ->limit($pages->limit)
          ->all();

      return $this->render('index', [
        'q' => $q,
        'type' => $type,
        'products' => $products,
        'pages' => $pages,
      ]);
    }

    public function actionProduct($id)
    {
      $product = Product::findOne($id);

      return $this->render('product', [
        'product' => $product
      ]);
    }
}
