<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%follow}}".
 *
 * @property string $user_id
 * @property string $follow_id
 */
class Follow extends \yii\db\ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%follow}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'follow_id'], 'required'],
            [['user_id', 'follow_id'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'follow_id' => Yii::t('app', 'Follow ID'),
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['user_id' => 'user_id'])->one();
    }
}
