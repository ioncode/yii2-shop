<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
      <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
      <?= Html::a('Delete', ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger',
          'data'  => [
              'confirm' => 'Are you sure you want to delete this item?',
              'method'  => 'post',
          ],
      ]) ?>
  </p>
  <div class="row">
    <div class="col-4">
      <img src="/uploads/<?= $model->id ?>.jpg"
           width="100%">
    </div>
    <div class="col-8">
        <?= DetailView::widget([
            'model'      => $model,
            'attributes' => [
                'id',
                'title',
                'releaseDate',
                'description:ntext',
                'isbn',
            ],
        ]) ?>
    </div>
  </div>

</div>
