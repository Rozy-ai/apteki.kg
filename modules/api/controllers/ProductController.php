<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use app\models\Product;
use app\models\ProductFavorite;
use yii\helpers\Url;

class ProductController extends Controller
{
    public function actionSearch($q)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $where = ["or"];

        array_push($where, ['like', 'product.name', '%' . $q . '%', false]);

        array_push($where, ['like', 'description', '%' . $q . '%', false]);

        array_push($where, ['like', 'substance.name', '%' . $q . '%', false]);

        $products  = Product::find()->joinWith("substance")->where($where)->andWhere(["<>", "availability_count", 0])->andWhere(["product.active" => 1])->orderBy("product.name")->all();

        if(count($products) == 0) {
            return ["success" => false];
        }

        $html = "<ul>";
        foreach ($products as $product) {
            $html .= '<li><a href="' . Url::to(['/product/index', 'id' => $product->id]) . '">' . $product->name . '</a>';
        }

        $html .= "</ul>";

        return ["success" => true, "html" => $html];
    }

}
