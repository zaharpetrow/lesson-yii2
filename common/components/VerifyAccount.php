<?php

namespace common\components;

use common\models\User;
use common\traits\SaveToFileTrait;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class VerifyAccount
{

    use SaveToFileTrait;

    protected static $email;

    public static function sendVerifyMail(string $email)
    {
        self::$email = $email;
        $link        = self::getVerifyLink();

        if (YII_ENV_DEV) {
            static::saveToFile($link, Yii::getAlias('@verifyLinks'));
        }

        Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['senderEmail'])
                ->setTo(self::$email)
                ->setSubject('Text title')
                ->setTextBody('Text message')
                ->setHtmlBody('<a href="' . $link . '">Link</a>')
                ->send();
    }

    public static function activateAccount(int $id, string $emailHash): bool
    {
        $user = User::findOne($id);

        if (User::validatePass($user->email, $emailHash)) {
            $user->verify = User::STATUS_VERIFIED;
            $user->save();

            return true;
        }

        throw new NotFoundHttpException();
    }

    protected static function getVerifyLink(): string
    {
        $user        = User::find()->where(['email' => self::$email])->one();
        $arrayToLink = [
            '/profile/verification',
            'id'   => $user->id,
            'hash' => User::getPassHash($user->email),
        ];
        $link        = Url::toRoute($arrayToLink, true);

        return $link;
    }

}
