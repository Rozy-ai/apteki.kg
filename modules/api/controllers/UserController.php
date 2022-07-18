<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use app\models\Product;
use app\models\ProductFavorite;

class UserController extends Controller
{
  public function actionFavorites($id)
  {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      if (Yii::$app->user->isGuest) return["error" => "Необходимо авторизоваться"];
      $user_id = Yii::$app->user->identity->id;

      $article = $this->findProduct($id);

      $favorites = ProductFavorite::findOne(["user_id" => $user_id, "product_id" => $article->id]);
      if(isset($favorites)) {
          $favorites->delete();
          return ["status" => false];
      } else {
          $favorites = new ProductFavorite(["user_id" => $user_id, "product_id" => $article->id]);
          $favorites->save();
          return ["status" => true];
      }
  }

  protected function findProduct($id)
  {
      if (($model = Product::findOne($id)) !== null) {
          return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
  }
}
