<?php

use app\models\Author;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var yii\widgets\ActiveForm $form */

$authors = Author::find()->select(['id', 'title'])->asArray()->all();
$authors = ArrayHelper::map($authors, 'id', 'title');
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>
  <div class="row">
    <div class="col-8">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-4">
        <?= $form->field($model, 'releaseDate')->widget(DatePicker::class, [
                'name'          => 'year',
                'type'          => DatePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'autoclose'   => true,
                    'format'      => 'yyyy-mm-dd',
                    'minViewMode' => 2,
                    'endDate'     => date('Y') . 'y'
                ]
            ]

        ) ?>
    </div>
  </div>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isbn')->textInput() ?>

    <?= $form->field($model, 'coverImageFile')->fileInput() ?>

    <?= $form->field($model, 'authors')->widget(Select2::class, [
        'data'          => $authors,
        'language'      => 'en',
        'options'       => ['placeholder' => 'Select authors ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple'   => true
        ],
    ]) ?>

  <div class="form-group">
      <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
  </div>

    <?php ActiveForm::end(); ?>

</div>
