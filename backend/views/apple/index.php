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
<?php Pjax::begin(['id' => 'applePjax', 'enablePushState' => false, 'timeout' => false]); ?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
      <?= Html::a('Generate', ['generate'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
$oApple = new \backend\models\AppleStandard('green');
echo $oApple->getColor() . '<br/>';
$oApple->eat(50);
echo '--------<br/>';
$oApple->fall();
echo 'FallenDate: ' . Yii::$app->formatter->asDatetime($oApple->getFallenDate()) . '<br/>';
echo '--------<br/>';
$oApple->eat(100);
echo 'Size = ' . $oApple->getSize();
?>






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

/*$("#applePjax").on("pjax:end", function(data) {
    console.log(data);
    //$.pjax.reload({container:"#applePjax"});  //Reload GridView
});*/

//$.pjax.reload('#applePjax', {timeout : false});
JS;
$this->registerJs($js);
