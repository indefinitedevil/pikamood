<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%auth}}".
 *
 * @property int $auth_id Authentication ID
 * @property string $username User name
 * @property string $source Authentication Source
 * @property string $source_id Authentication Token
 */
class Auth extends \yii\db\ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%auth}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'source', 'source_id'], 'required'],
            [['user_id'], 'string', 'max' => 256],
            [['source'], 'string', 'max' => 32],
            [['source_id'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'auth_id' => Yii::t('app', 'Authentication ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'source' => Yii::t('app', 'Authentication Source'),
            'source_id' => Yii::t('app', 'Authentication Token'),
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
}
