<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Mood */

$this->title = $model->mood_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Moods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mood-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->mood_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->mood_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mood_name',
            'mood_gif',
            'contributor',
        ],
    ]) ?>

</div>
