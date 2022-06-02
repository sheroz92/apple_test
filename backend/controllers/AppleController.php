<?php

namespace backend\controllers;

use Throwable;
use Yii;
use backend\models\Apple;
use backend\models\AppleSearch;
use yii\db\StaleObjectException;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Apple models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Apple model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Apple model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        for ($i = 1; $i <= rand(1, 10); $i++){
            $model = new Apple();
            $model->save(false);
        }
        Yii::$app->session->setFlash('success','Яблоки успешно сгенерированы');
        return $this->redirect('apple/index');
    }

    /**
     * Updates an existing Apple model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionEat(){
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('id');
            $model = $this->findModel($id);
            $success = $model->eat(Yii::$app->request->post('percent'));
            if($success === true){
                $model->save();
                return ['error'=>0];
            }else{
                return ['error'=>1, 'message'=>$success];
            }
        }else{
            return $this->redirect('index');
        }
    }
    /**
     * Deletes an existing Apple model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionFall($id)
    {
        $this->findModel($id)->fall();
        Yii::$app->session->setFlash('success','The apple successfully fell to the ground');
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Apple model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Apple model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apple the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apple::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
