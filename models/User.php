<?php

namespace app\models;

use Ramsey\Uuid\Uuid;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $user_id User ID
 * @property string $username User Name
 * @property int $mood_id User mood
 * @property string $auth_key Authentication Key
 * @property string $url_hash URL hashed key
 * @property string $updated_at Modified at
 * @property int $admin Admin privileges
 * @property User $user
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'username', 'mood_id', 'url_hash'], 'required'],
            [['user_id', 'auth_key', 'url_hash'], 'string', 'max' => 256],
            [['mood_id', 'admin'], 'integer'],
            [['updated_at'], 'safe'],
            [['username'], 'string', 'max' => 32],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'username' => Yii::t('app', 'Display name'),
            'mood_id' => Yii::t('app', 'Mood'),
            'url_hash' => Yii::t('app', 'URL hashed key'),
            'updated_at' => Yii::t('app', 'Modified at'),
            'admin' => Yii::t('app', 'Admin privileges'),
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString(256);
                $this->url_hash = Uuid::uuid4()->toString();
            }
            return true;
        }
        return false;
    }

    public static function findIdentity($username) {
        return static::findOne($username);
    }

    public function getId() {
        return $this->user_id;
    }

    public function getAuth() {
        return $this->hasOne(Auth::className(), ['username' => 'username']);
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        $auth = Auth::findOne(['source_id' => $token]);
        return static::findOne(['username' => $auth->username]);
    }

    public function isAdmin() {
        return true == $this->admin;
    }
}
