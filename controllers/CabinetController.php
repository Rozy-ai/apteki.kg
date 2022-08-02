<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\Product;
use app\models\ProductAvailability;
use app\models\AvailabilityForm;
use yii\web\NotFoundHttpException;
use app\models\Company;

class CabinetController extends Controller
{
    public function actionIndex()
    {
        $q = Yii::$app->request->get("q");
        $user = Yii::$app->user->identity;
        $user_id = $user->id;

        $company = Company::findOne(["user_id" => $user_id]);
        if(!$company) {
          throw new NotFoundHttpException('The requested page does not exist.');
        }

        $where = ["and", ["active" => 1]];

        if($q) {
          array_push($where, ['like', 'name', '%' . $q . '%', false]);
        }

        $query = Product::find()->joinWith(["availabilityOne" => function ($query) use ($company)  {
          $query->onCondition(['product_availability.company_id' => $company->id]);
        }])->where($where)->orderBy("product.id DESC");
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 50]);
        $products = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $availabilityForm = new AvailabilityForm();
        if ($availabilityForm->load(Yii::$app->request->post()) && $availabilityForm->validate() ) {
          foreach ($products as $key => $product) {
  					$price = $availabilityForm->price[$product->id];
  					$count = $availabilityForm->count[$product->id];
            if($product->availabilityOne && $price == 0) {
              $product->availabilityOne->delete();
            } else if(!$product->availabilityOne && $price != 0) {
              $availability = new ProductAvailability(["company_id" => $company->id, "product_id" => $product->id, "price" => $price, "count" => $count]);
              $availability->save();
            } else if($product->availabilityOne && ($product->availabilityOne->price != $price || $product->availabilityOne->count != $count))  {
              $product->availabilityOne->price = $price;
              $product->availabilityOne->count = $count;
              $product->availabilityOne->save();
            }
          }
          return $this->refresh();
        }

        return $this->render('index', [
          'user' => $user,
          'availabilityForm' => $availabilityForm,
          'products' => $products,
          'pages' => $pages,
          'q' => $q
        ]);
    }
}
