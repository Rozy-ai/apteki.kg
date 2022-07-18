<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Company;

class CompanyController extends Controller
{
    public function actionIndex($id)
    {
        $company = Company::findOne($id);

        return $this->render('index', [
          'company' => $company,
        ]);
    }
}
