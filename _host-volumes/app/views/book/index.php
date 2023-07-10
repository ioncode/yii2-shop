<?php

use app\models\Book;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <p>
      <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
  </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'  => 'Cover',
                'format' => ['image', ['height' => '24']],
                'value'  => function ($model) {
                    return $model->coverUrl;
                }
            ],
            'id',
            'title',
            'releaseDate',
            'description:ntext',
            'isbn',
            [
                'class'      => ActionColumn::class,
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
