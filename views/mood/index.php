<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Moods');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mood-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Mood'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mood_name',
            'mood_gif',
            [
                    'label' => 'Contributor',
                'value' => function($model) {
                    $user = $model->getUser();
                    if ($user !== null) {
                        return '<a href="' . \yii\helpers\Url::to(['/user/profile', 'hash' => $user->url_hash]) . '">' . $user->username . '</a>';
                    }
                    return $model->contributor;
                },
                'format' => 'html',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
