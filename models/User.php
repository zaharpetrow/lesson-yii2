<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $img
 */
class User extends \yii\db\ActiveRecord
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
            [['name'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 50],
            [['password', 'img'], 'string', 'max' => 255],
            ['email', 'email'],
            [
                'email',
                'unique',
                'message' => Yii::t('app', 'Такой Email уже существует!'),
            ],
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
        ];
    }

}
