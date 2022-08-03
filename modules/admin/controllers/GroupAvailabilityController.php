<?php

namespace app\modules\admin\controllers;

use app\models\GroupAvailability;
use app\models\CompanyGroup;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GroupAvailabilityController implements the CRUD actions for GroupAvailability model.
 */
class GroupAvailabilityController extends Controller
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
     * Displays a single GroupAvailability model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GroupAvailability model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($product_id)
    {
        $model = new GroupAvailability(["product_id" => $product_id]);

        $groups = array();
        $groups_query = CompanyGroup::find()->where(["active" => 1])->all();
        foreach ($groups_query as $item) {
            $groups[$item->id] = $item->name;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['product/view', 'id' => $model->product_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'groups' => $groups
        ]);
    }

    /**
     * Updates an existing GroupAvailability model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $groups = array();
        $groups_query = CompanyGroup::find()->where(["active" => 1])->all();
        foreach ($groups_query as $item) {
            $groups[$item->id] = $item->name;
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['product/view', 'id' => $model->product_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'groups' => $groups
        ]);
    }

    /**
     * Deletes an existing GroupAvailability model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['product/view', 'id' => $model->product_id]);
    }

    /**
     * Finds the GroupAvailability model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return GroupAvailability the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GroupAvailability::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
