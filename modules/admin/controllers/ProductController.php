<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Category;
use app\models\Substance;
use app\models\Country;
use app\models\ImageCache;
use yii\data\ActiveDataProvider;
use app\models\Producer;
use app\models\Product;
use app\models\ProductAnalog;
use app\models\ProductAvailability;
use app\models\GroupAvailability;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $dataProviderAnalog = new ActiveDataProvider([
            'query' => ProductAnalog::find()->where(["product_id" => $model->id]),
            'pagination' => [
                'pageSize' => 20
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $dataProviderAvailability = new ActiveDataProvider([
            'query' => ProductAvailability::find()->where(["product_id" => $model->id]),
            'pagination' => [
                'pageSize' => 20
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $dataProviderGroupAvailability = new ActiveDataProvider([
            'query' => GroupAvailability::find()->where(["product_id" => $model->id]),
            'pagination' => [
                'pageSize' => 20
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProviderAnalog' => $dataProviderAnalog,
            'dataProviderAvailability' => $dataProviderAvailability,
            'dataProviderGroupAvailability' => $dataProviderGroupAvailability
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $category = array();
        $category_main_query = Category::find()->where(["active" => 1, "parent_id" => 0])->all();
        foreach ($category_main_query as $item_main) {
            $category_query = Category::find()->where(["active" => 1, "parent_id" => $item_main->id])->all();
            if(count($category_query) == 0) {
                $category[$item_main->id] = $item_main->name;
            } else {
                $category[$item_main->name] = [];
                foreach ($category_query as $item) {
                    $category[$item_main->name][$item->id] = $item->name;
                }
            }
        }

        $substance = array();
        $substance_query = Substance::find()->where(["active" => 1])->all();
    		foreach ($substance_query as $item) {
    			$substance[$item->id] = $item->name;
    		}

        $country = array();
        $country_query = Country::find()->where(["active" => 1])->all();
    		foreach ($country_query as $item) {
    			$country[$item->id] = $item->name;
    		}

        $producer = array();
        $producer_query = Producer::find()->where(["active" => 1])->all();
    		foreach ($producer_query as $item) {
    			$producer[$item->id] = $item->name;
    		}

        $model = new Product(["hash" => Yii::$app->security->generateRandomString(8)]);

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                $images = ImageCache::find()->where(["hash" => $model->hash])->orderBy("sort")->all();
                foreach ($images as $image) {
                    $model->attachImage($image->path);
                    unlink($image->path);
                    $image->delete();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $images = ImageCache::find()->where(["hash" => $model->hash])->orderBy("sort")->all();

        $initialPreview = array();
        $initialPreviewConfig = array();
        foreach ($images as $image) {
            array_push($initialPreview, Url::to("@web/" . $image->path));
            array_push($initialPreviewConfig, ["key" => $image->id, "caption" => "Фото " . $image->id]);
        }


        return $this->render('create', [
            'model' => $model,
            'category' => $category,
            'substance' => $substance,
            'country' => $country,
            'producer' => $producer,
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->hash = Yii::$app->security->generateRandomString(8);

        $images = $model->getImages();

        $initialPreview = array();
        $initialPreviewConfig = array();
        foreach ($images as $image) {
            array_push($initialPreview, $image->getUrl());
            array_push($initialPreviewConfig, ["key" => $image->id, "caption" => "Фото " . $image->id]);
        }

        $category = array();
        $category_main_query = Category::find()->where(["active" => 1, "parent_id" => 0])->all();
        foreach ($category_main_query as $item_main) {
            $category_query = Category::find()->where(["active" => 1, "parent_id" => $item_main->id])->all();
            if(count($category_query) == 0) {
                $category[$item_main->id] = $item_main->name;
            } else {
                $category[$item_main->name] = [];
                foreach ($category_query as $item) {
                    $category[$item_main->name][$item->id] = $item->name;
                }
            }
        }

        $substance = array();
        $substance_query = Substance::find()->where(["active" => 1])->all();
        foreach ($substance_query as $item) {
          $substance[$item->id] = $item->name;
        }

        $country = array();
        $country_query = Country::find()->where(["active" => 1])->all();
        foreach ($country_query as $item) {
          $country[$item->id] = $item->name;
        }

        $producer = array();
        $producer_query = Producer::find()->where(["active" => 1])->all();
        foreach ($producer_query as $item) {
          $producer[$item->id] = $item->name;
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'category' => $category,
            'substance' => $substance,
            'country' => $country,
            'producer' => $producer,
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
