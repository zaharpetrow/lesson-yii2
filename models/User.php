<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

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
class User extends ActiveRecord
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
            [['password', 'img'], 'string', 'max' => 255],
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
            'img'      => Yii::t('app', 'Img'),
            'verify'   => Yii::t('app', 'Verify'),
        ];
    }

}
