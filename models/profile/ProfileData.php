<?php

namespace app\models\profile;

use app\components\validators\ValidateRules;
use app\models\User;
use Yii;
use yii\base\Model;
use yii\web\UnauthorizedHttpException;

class ProfileData extends Model
{

    public $name;
    public $password;
    public $passwordRepeat;

    public function rules()
    {
        return ValidateRules::getUpdateProfileRules();
    }

    public function attributeLabels()
    {
        return [
            'name'           => Yii::t('app', 'Имя'),
            'password'       => Yii::t('app', 'Новый пароль'),
            'passwordRepeat' => Yii::t('app', 'Подтверждение пароля'),
        ];
    }

    public function updateProfile()
    {
        if (Yii::$app->user->isGuest) {
            throw new UnauthorizedHttpException('Пользователь не авторизован');
        }

        $user = Yii::$app->user->identity;

        if ($this->name) {
            $user->name = $this->name;
        }

        if ($this->password) {
            $user->password = User::getPassHash($this->password);
        }

        $user->update();
    }

}
