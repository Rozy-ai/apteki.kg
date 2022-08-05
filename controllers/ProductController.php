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
        
        $availability = [];
        foreach ($product->groupAvailability as $groupItem) {
            foreach ($groupItem->group->company as $item) {
                $availability[] = [
                    "name" => $item->name,
                    "type" => $item->type,
                    "rating" => $item->rating,
                    "work" => $item->work,
                    "lat" => $item->lat,
                    "lon" => $item->lon,
                    "address" => $item->address,
                    "price" => $groupItem->price,
                    "url" => $groupItem->url
                ];
            }
        }

        foreach ($product->availability as $item) {
            $availability[] = [
                "name" => $item->company->name,
                "type" => $item->company->type,
                "rating" => $item->company->rating,
                "work" => $item->company->work,
                "lat" => $item->company->lat,
                "lon" => $item->company->lon,
                "address" => $item->company->address,
                "price" => $item->price,
                "url" => $item->url
            ];
        }

        $price = array_column($availability, 'price');
        array_multisort($price, SORT_ASC, $availability);

        $user_id = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->id;
        $products = Product::find()->joinWith(["favorite" => function ($query) use ($user_id)  {
          $query->onCondition(['product_favorite.user_id' => $user_id]);
        }, "analog" => function ($query) use ($product)  {
          $query->onCondition(['product_analog.product_id' => $product->id]);
        },
        ])->where(["active" => 1])->andWhere(["<>", "availability_count", 0])->andWhere(["is not", "product_analog.id", null])->orderBy("product.id DESC")->limit(4)->all();


        return $this->render('index', [
            'product' => $product,
            'products' => $products,
            'availability' => $availability
        ]);
    }
}
