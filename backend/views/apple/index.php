<?php

use common\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var backend\models\AppleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>

    <style>
        .apple-view {
            background: #ccc;
            -webkit-border-radius: 80px;
            -moz-border-radius: 80px;
            border-radius: 80px;
            margin-bottom: 25px;
        }
        .apple-view.green {
            background: #7fd38a;
        }
        .apple-view.yellow {
            background: #f2efac;
        }
        .apple-view.red {
            background: #f07e7e;
        }
        .apple-view.rotten {
            opacity: 0.5;
        }
    </style>

<?php Pjax::begin(['id' => 'applePjax', 'enablePushState' => false, 'timeout' => false]); ?>
    <div class="apple-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <p>
          <?= Html::a('Generate', ['generate'], ['class' => 'btn btn-warning']) ?>
        </p>

      <?= Alert::widget() ?>

        <div class="row">
          <?php
          echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_apple',
            'options' => ['class' => 'row'],
            'itemOptions' => ['class' => 'col-md-4'],
          ]);
          ?>
        </div>
    </div>
<?php Pjax::end(); ?>

<?php
$js = <<< JS
$('body').on('change', '.percent-input', function(e){
    setEatPercentHref(this);
});
function setEatPercentHref(input) {
    let val = $(input).val();
    let href = '/apple/eat?id='+$(input).data('id')+'&percent='+val;
    $(input).next('a').attr('href', href);
}
JS;
$this->registerJs($js);
