<?php

use backend\models\Apple;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Apple $model */

\yii\web\YiiAsset::register($this);
?>
  <div class="apple-view p-4">
    <?php
    $percent = (int)($model->size * 100);
    echo \yii\bootstrap5\Progress::widget([
      'percent' => $percent,
      'label' => $percent . '%',
      'barOptions' => ['class' => ['bg-success', 'progress-bar-animated', 'progress-bar-striped']]
    ]);
    ?>
    <h2><?= Html::encode($model->color) ?></h2>
    <p><?= Yii::$app->formatter->asDatetime($model->created_date) ?></p>
    <div style="display: flex; flex-wrap:wrap; justify-content: space-between;">
        <?php
        $isHanging = $model->status == Apple::STATUS_HANGING;
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
