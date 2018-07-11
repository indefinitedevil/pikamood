<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Mood */

$this->title = Yii::t('app', 'Submit Mood');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Moods'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mood-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
