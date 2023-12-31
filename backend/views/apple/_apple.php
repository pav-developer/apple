<?php

use backend\models\AppleStandard;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\AppleStandard $model */

\yii\web\YiiAsset::register($this);
$isRotten = $model->status === AppleStandard::STATUS_ROTTEN;
?>
  <div class="apple-view px-4 py-5 <?=$model->color . ' ' . ($isRotten ? 'rotten' : '')?>">
    <?php
    $percent = (int)($model->size * 100);
    echo \yii\bootstrap5\Progress::widget([
      'percent' => $percent,
      'label' => $percent . '%',
      'barOptions' => ['class' => ['bg-success', 'progress-bar-animated', 'progress-bar-striped']]
    ]);
    ?>
    <h2><?= '#' . $model->id . ' ' . Html::encode($model->color) ?></h2>
    <p>
        <small>State: <?= $model->getStatus() ?></small><br/>
        <small>Created: <?= Yii::$app->formatter->asDatetime($model->created_date) ?></small><br/>
        <small>Fallen: <?= Yii::$app->formatter->asDatetime($model->fallen_date) ?></small><br/>
        <?php if ($model->status === AppleStandard::STATUS_FALLEN) {
            $toRottenDate = Yii::$app->formatter->asDuration($model->fallen_date + \backend\models\AppleStandard::ROTTEN_TIME - time());
        } else {
          $toRottenDate = '-';
        } ?>
        <small>To rotten: <?= $toRottenDate ?></small>
    </p>
    <div style="display: flex; flex-wrap:wrap; justify-content: space-between;">
        <?php
        $isHanging = $model->status === \backend\models\AppleStandard::STATUS_HANGING;
        if ($isHanging) {
          echo Html::a('Fall', ['fall', 'id' => $model->id], ['class' => 'btn btn-primary']);
        } else {
          echo Html::button('Fallen', ['class' => 'btn btn-secondary']);
        } ?>
        <span class="input-group" style="width: 100px;"><?php
            echo Html::textInput('percent', null, ['class' => 'form-control percent-input', 'data-id' => $model->id]);
            echo Html::a('Eat', ['#'],
              ['class' => 'btn btn-success']);
        ?></span>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
    </div>
  </div>
