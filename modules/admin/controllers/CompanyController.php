<?php

namespace app\modules\admin\controllers;

use app\models\Users;
use app\models\Company;
use app\models\CompanyGroup;
use app\models\CompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
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
     * Lists all Company models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
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
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $groups = [0 => "Без группировки"];
        $group_query = CompanyGroup::find()->where(["active" => 1])->all();
        foreach ($group_query as $group) {
            $groups[$group->id] = $group->name;
        }

        $users = [0 => "Нет владельца"];
        $user_query = Users::find()->joinWith("company")->where(["is", "company.id", null])->all();
        foreach ($user_query as $user) {
          $users[$user->id] = $user->name;
        }

        $model = new Company();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if($model->image){
                  $model->removeImages();
                  $model->upload();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'users' => $users,
            'groups' => $groups
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $groups = [0 => "Без группировки"];
        $group_query = CompanyGroup::find()->where(["active" => 1])->all();
        foreach ($group_query as $group) {
            $groups[$group->id] = $group->name;
        }

        $users = [0 => "Нет владельца"];
        $user_query = Users::find()->joinWith("company")->where(["is", "company.id", null])->all();
        foreach ($user_query as $user) {
          $users[$user->id] = $user->name;
        }

        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if($model->image){
              $model->removeImages();
              $model->upload();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'users' => $users,
            'groups' => $groups
        ]);
    }

    /**
     * Deletes an existing Company model.
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
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
