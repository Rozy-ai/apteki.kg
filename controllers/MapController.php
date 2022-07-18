<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Company;

class MapController extends Controller
{
    public function actionIndex()
    {
        $category = Yii::$app->request->get("id", 0);

        $where = ["active" => 1, "type" => [0,1]];

        $companys = Company::find()->where($where)->orderBy("id DESC")->all();

        return $this->render('index', [
          'companys' => $companys
        ]);
    }
}
