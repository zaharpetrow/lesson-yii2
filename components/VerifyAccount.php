<?php

namespace app\components;

use app\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class VerifyAccount extends Model
{

    protected static $email;

    public static function sendVerifyMail(string $email)
    {
        self::$email = $email;
        $link        = self::getVerifyLink();

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

        if (Yii::$app->security->validatePassword($user->email, $emailHash)) {
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
            'profile/verification',
            'id'   => $user->id,
            'hash' => Yii::$app->security->generatePasswordHash($user->email),
        ];
        $link        = Url::toRoute($arrayToLink, true);

        if (YII_ENV_DEV) {
            static::saveVerifyLinkToFile($link);
        }

        return $link;
    }

    protected static function saveVerifyLinkToFile(string $link)
    {
        $filePath = Yii::getAlias('@app/mail/verifyLinks.txt');

        file_put_contents($filePath, "$link\n", FILE_APPEND);
    }

}
