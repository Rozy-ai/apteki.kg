<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use app\models\ParserSettings;
use app\models\ParserCategory;
use app\models\ParserCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParserCategoryController implements the CRUD actions for ParserCategory model.
 */
class ParserCategoryController extends Controller
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
     * Lists all ParserCategory models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $settings = ParserSettings::find()->all();

        $searchModel = new ParserCategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams, 0);

        return $this->render('index', [
            'settings' => $settings,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ParserCategory model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $searchModel = new ParserCategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $model->id);

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing ParserCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $category = array("0" => "Нет");
        $category_query = Category::find()->where(["active" => 1])->all();
        foreach ($category_query as $item) {
          $category[$item->id] = $item->name;
        }

        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'category' => $category
        ]);
    }

    /**
     * Deletes an existing ParserCategory model.
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

    public function actionStatus($id)
    {
        $settings = ParserSettings::findOne($id);
        $settings->category_status = 1;
        $settings->save();

        return $this->redirect("index");
    }

    /**
     * Finds the ParserCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ParserCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParserCategory::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
