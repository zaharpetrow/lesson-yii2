<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_options".
 *
 * @property int $id
 * @property int $user_id
 * @property string $dir_name
 *
 * @property User $user
 */
class UserOptions extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'dir_name'], 'required'],
            [['user_id'], 'integer'],
            [['dir_name'], 'string', 'max' => 255],
            [['img'], 'string', 'max' => 255],
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
            'id'       => Yii::t('app', 'ID'),
            'user_id'  => Yii::t('app', 'User ID'),
            'dir_name' => Yii::t('app', 'Dir Name'),
            'img'      => Yii::t('app', 'Image'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
