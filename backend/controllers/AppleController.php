<?php

namespace backend\controllers;

use backend\models\Apple;
use backend\models\AppleSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
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
          'class' => VerbFilter::class,
          'actions' => [
            //'delete' => ['POST'],
          ],
        ],
      ]
    );
  }


  /**
   * @return string
   * @throws Exception
   */
  public function actionGenerate()
  {
    Apple::deleteAll();
    Apple::generate();

    $searchModel = new AppleSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);
    return $this->renderPartial('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * @param int $id
   * @param int $percent
   * @return string
   * @throws NotFoundHttpException
   * @throws \Exception
   */
  public function actionEat(int $id, int $percent)
  {
    if (\Yii::$app->request->isAjax) {
      \Yii::$app->response->format = Response::FORMAT_JSON;
    }

    if ($percent < 0 || $percent > 100) {
      throw new \Exception('Указано неверное значение для процента');
    }

    $oApple = $this->findModel($id);

    try {
      $oApple->eat($percent);
    } catch (\Exception $e) {
      \Yii::$app->session->setFlash('error', $e->getMessage());
    }

    if (!$oApple->save()) {
      throw new \Exception('Ошибка сохранения яблока');
    }

    $searchModel = new AppleSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);
    return $this->renderPartial('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);

  }

  /**
   * @param int $id
   * @return string
   * @throws NotFoundHttpException
   */
  public function actionFall(int $id)
  {
    if (\Yii::$app->request->isAjax) {
      \Yii::$app->response->format = Response::FORMAT_JSON;
    }

    $oApple = $this->findModel($id);

    $oApple->fallToGround();
    if (!$oApple->save()) {
      throw new \Exception('Ошибка сохранения яблока');
    }

    $searchModel = new AppleSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);
    return $this->renderPartial('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);

  }

  /**
   * Lists all Apple models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $searchModel = new AppleSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Deletes an existing Apple model.
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
   * Finds the Apple model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return Apple the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Apple::findOne(['id' => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
