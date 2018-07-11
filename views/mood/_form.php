<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mood */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mood-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mood_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mood_gif')->textInput(['maxlength' => true]) ?>

    <?php /** @var \app\models\User $user */ $user = \Yii::$app->user->identity; ?>
    <?php if ($user->isAdmin()): ?>
        <?= $form->field($model, 'contributor')->textInput(['maxlength' => true, 'value' => $model->contributor]) ?>
        <?= $form->field($model, 'approved')->dropDownList([0 => 'No', 1 => 'Yes'], ['value' => $model->approved]) ?>
    <?php else: ?>
        <?= Html::activeHiddenInput($model, 'user_id', ['value' => $user->getId()]) ?>
        <?= Html::activeHiddenInput($model, 'approved', ['value' => 0]) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
