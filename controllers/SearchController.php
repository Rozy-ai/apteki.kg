<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
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


      $products = Product::find()->where($where)->orderBy("product.name")->all();

      return $this->render('index', [
        'q' => $q,
        'type' => $type,
        'products' => $products,
      ]);
    }

    public function actionProduct($id)
    {
      $product = Product::findOne($id);

      return $this->render('product', [
        'product' => $product,
      ]);
    }
}
