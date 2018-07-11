<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%mood}}".
 *
 * @property int $mood_id Mood ID
 * @property string $mood_name Mood name
 * @property string $mood_gif Mood gif
 * @property string $contributor Contributor
 * @property int $approved Approved
 */
class Mood extends \yii\db\ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%mood}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['mood_name', 'mood_gif'], 'required'],
            [['mood_id', 'approved'], 'integer'],
            [['mood_name'], 'string', 'max' => 32],
            [['mood_gif', 'contributor'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'mood_id' => Yii::t('app', 'Mood ID'),
            'mood_name' => Yii::t('app', 'Name'),
            'mood_gif' => Yii::t('app', 'Gif'),
            'contributor' => Yii::t('app', 'Contributor'),
            'approved' => Yii::t('app', 'Approved'),
        ];
    }

    public static function getList() {
        $list = [];
        $moods = self::find()->andWhere(['approved' => 1])->all();
        /** @var Mood $mood */
        foreach ($moods as $mood) {
            $list[$mood->mood_id] = $mood->getMoodImage();
        }
        return $list;
    }

    public function getMoodImage($width = 150, $showContributor = true) {
        $img = '<img src="' . $this->mood_gif . '" alt="' . $this->mood_name . '" width="' . $width . '"/>';
        $user = $this->getUser();
        if ($user !== null && $showContributor) {
            $img .= '<br><small>Contributed by <a href="' . \yii\helpers\Url::to(['/user/profile', 'hash' => $user->url_hash]) . '">' . $user->username . '</a></small>';
        }
        return $img;
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['user_id' => 'contributor'])->one();
    }
}
