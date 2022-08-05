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

        $availability = [];
        foreach ($product->groupAvailability as $groupItem) {
            foreach ($groupItem->group->company as $item) {
                $availability[] = [
                    "name" => $item->name,
                    "image" => $item->getImage() ? $item->getImage()->getUrl("75x75") : null,
                    "type" => $item->type,
                    "rating" => $item->rating,
                    "work" => $item->work,
                    "lat" => $item->lat,
                    "lon" => $item->lon,
                    "address" => $item->address,
                    "contact" => $item->contact,
                    "price" => $groupItem->price,
                    "url" => $groupItem->url
                ];
            }
        }

        foreach ($product->availability as $item) {
            $availability[] = [
                "name" => $item->company->name,
                "image" => $item->company->getImage() ? $item->company->getImage()->getUrl("75x75") : null,
                "type" => $item->company->type,
                "rating" => $item->company->rating,
                "work" => $item->company->work,
                "lat" => $item->company->lat,
                "lon" => $item->company->lon,
                "address" => $item->company->address,
                "price" => $item->price,
                "contact" => $item->company->contact,
                "url" => $item->url
            ];
        }

        $price = array_column($availability, 'price');
        array_multisort($price, SORT_ASC, $availability);

      return $this->render('product', [
        'product' => $product,
        'availability' => $availability
      ]);
    }
}
