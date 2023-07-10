<?php

use app\models\Author;
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

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'releaseDate')->textInput() ?>

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
