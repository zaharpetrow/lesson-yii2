<?php

namespace common\models\recovery;

use common\models\User;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "token".
 *
 * @property int $user_id
 * @property string|null $token
 * @property int|null $created_at
 *
 * @property User $user
 */
class Token extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['token'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [
                ['user_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::className(),
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id'    => Yii::t('app', 'User ID'),
            'token'      => Yii::t('app', 'Token'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \common\models\User
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function createToken(): string
    {
        return Yii::$app->security->generateRandomString();
    }

}
