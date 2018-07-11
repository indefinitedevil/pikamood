<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mood */

$this->title = Yii::t('app', 'Update Mood: ' . $model->mood_name, [
    'nameAttribute' => '' . $model->mood_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Moods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mood_name, 'url' => ['view', 'id' => $model->mood_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="mood-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
