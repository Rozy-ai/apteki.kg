<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Product;

class ProductController extends Controller
{
    public function actionIndex($id)
    {
        $product = Product::findOne($id);

        $user_id = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->id;
        $products = Product::find()->joinWith(["favorite" => function ($query) use ($user_id)  {
          $query->onCondition(['product_favorite.user_id' => $user_id]);
        }, "analog" => function ($query) use ($product)  {
          $query->onCondition(['product_analog.product_id' => $product->id]);
        },
        ])->where(["active" => 1])->andWhere(["<>", "availability_count", 0])->andWhere(["is not", "product_analog.id", null])->orderBy("product.id DESC")->limit(4)->all();


        return $this->render('index', [
          'product' => $product,
          'products' => $products
        ]);
    }
}
