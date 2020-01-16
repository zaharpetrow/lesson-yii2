<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $img
 * @property int $verify
 */
class User extends ActiveRecord implements IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['verify'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 50],
            ['email', 'email'],
            [
                'email',
                'unique',
                'message' => Yii::t('app', 'Такой Email уже существует!'),
            ],
            [['password'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('app', 'ID'),
            'name'     => Yii::t('app', 'Name'),
            'email'    => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'verify'   => Yii::t('app', 'Verify'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOptions()
    {
        return $this->hasOne(UserOptions::className(), ['user_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
//        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

}
