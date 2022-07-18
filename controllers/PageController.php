<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Pages;

class PageController extends Controller
{
 
    public function actionIndex()
    {		
		$name = Yii::$app->request->get('name');
		if($name == null) return $this->goHome(); 
		$name = explode("-", $name);
		if (!is_numeric($name[0]) || $name[0] < 0) return $this->goHome(); 
		$page = Pages::findOne($name[0]);
		if($page == null) return $this->goHome(); 
		return $this->render('index', [
			'page' => $page
        ]);
    }
	
}
