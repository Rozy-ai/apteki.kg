<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Product;

class ProfileController extends Controller
{
    public function actionIndex()
    {
        $user_id = Yii::$app->user->identity->id;
        $products = Product::find()->joinWith(["favorite" => function ($query) use ($user_id)  {
          $query->onCondition(['product_favorite.user_id' => $user_id]);
        }])->where(["active" => 1])->andWhere(["is not", "product_favorite.id", null])->orderBy("product.id DESC")->all();

        return $this->render('index', [
          'user' => Yii::$app->user->identity,
          'products' => $products
        ]);
    }
}
