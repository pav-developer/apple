<?php

namespace backend\controllers;

use backend\models\AppleSearch;
use backend\models\AppleStandard;
use yii\base\Exception;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
    return [
      'access' => [
        'class' => AccessControl::class,
        'rules' => [
          [
            'actions' => ['index', 'generate', 'fall', 'eat', 'delete'],
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
    ];
  }

  /**
   * @return string
   * @throws Exception
   */
  public function actionGenerate()
  {
    AppleStandard::deleteAll();
    AppleStandard::generate();

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
    $oApple = $this->findModel($id);
    $oApple->fall();

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
    $oApple = $this->findModel($id);

    try {
      $oApple->eat($percent);
    } catch (\Exception $e) {
      \Yii::$app->session->setFlash('error', $e->getMessage());
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
   * @return string
   * @throws NotFoundHttpException if the model cannot be found
   * @throws \Throwable
   * @throws StaleObjectException
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    $searchModel = new AppleSearch();
    $dataProvider = $searchModel->search([]);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Finds the Apple model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return AppleStandard the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = AppleStandard::findOne(['id' => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
