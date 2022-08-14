<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Product;
use app\models\Banner;
use app\models\Feedback;
use app\models\RegisterForm;
use app\models\Category;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user_id = Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->id;

        $category = Category::find()->where(["active" => 1, "parent_id" => 0])->all();

        $products = Product::find()->joinWith(["favorite" => function ($query) use ($user_id)  {
  				$query->onCondition(['product_favorite.user_id' => $user_id]);
  			}])->where(["active" => 1])->andWhere(["<>", "availability_count", 0])->orderBy("product.id DESC")->limit(8)->all();

        return $this->render('index', [
          'products' => $products,
          'category' => $category,
          'banners' => Banner::find()->where(["active" => 1])->all()
        ]);
    }
    
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = "login";

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        $this->layout = "login";

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->goBack();
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionRecover()
    {
        $this->layout = "login";

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            return $this->goBack();
        }

        return $this->render('recover', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {

        $model = new Feedback(["date" => time()]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Запрос успешно отправлен');
            return $this->goHome();
        }

        return $this->render('about', [
            'model' => $model,
        ]);
    }



    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
