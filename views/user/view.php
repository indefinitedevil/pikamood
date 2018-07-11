<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!\Yii::$app->user->isGuest): ?>
        <?php $user = \Yii::$app->user->identity; ?>
        <?php if ($user->isAdmin() || $user->getId() == $model->user_id): ?>
            <p>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->user_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a(Yii::t('app', 'Share on Facebook'),
                    'https://www.facebook.com/sharer/sharer.php?u=' . urlencode(\yii\helpers\Url::to(['/user/profile', 'hash' => $model->url_hash], 'https')),
                    ['class' => 'btn btn-success']
                ) ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>

    <p><?php echo \app\models\Mood::findOne($model->mood_id)->getMoodImage(500); ?></p>
    <small><?php printf(Yii::t('app', 'Last updated: %s'), $model->updated_at); ?></small>

    <?php if (\Yii::$app->user->isGuest): ?>
    <hr>
    <p>Want your own Pika-mood profile? <a class="btn btn-lg btn-success" href="<?php echo \yii\helpers\Url::to('site/login'); ?>">Get started!</a></p>
    <?php endif; ?>
</div>
