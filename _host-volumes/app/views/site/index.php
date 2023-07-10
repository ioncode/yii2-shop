<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $topDataProvider */

/** @var int $year */

use kartik\date\DatePicker;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Book catalog';
?>
<div class="site-index">
  <div class="row jumbotron">
    <div class="col-6">
      <div class="text-center">
        <h1 class="display-4">Top 10 authors in <?= $year ?></h1>

        <p class="lead">Here you can see <a href="/author">authors</a> with most <a href="/book">books</a> in catalog
        </p>
      </div>
    </div>
    <div class="col-6">
      <div class="row">
          <?php ActiveForm::begin([
              'method' => 'get',
              'action' => Url::to(['site/index']),
          ]) ?>
        <div class="row">
          <div class="col-4">
              <?= DatePicker::widget([
                  'name'          => 'year',
                  'type'          => DatePicker::TYPE_INPUT,
                  'value'         => $year,
                  'pluginOptions' => [
                      'autoclose'   => true,
                      'format'      => 'yyyy',
                      'minViewMode' => 2,
                      'endDate'     => date('Y') . 'y'
                  ]
              ]) ?></div>
          <div class="col-4">
              <?php echo Html::submitButton('Change year', ['class' => 'btn btn-primary']); ?>
          </div>
        </div>
          <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
  <div class="body-content">
    <div class="row">
        <?= $this->render('@app/views/author/index', [
            'dataProvider' => $topDataProvider,
        ]) ?>
    </div>

  </div>
</div>
