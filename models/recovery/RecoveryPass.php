<?php

namespace app\models\recovery;

use app\components\behaviors\AuthBehavior;
use app\components\helpers\UrlHelper;
use app\models\auth\SignIn;
use app\models\User;
use app\traits\AjaxValidationResponseTrait;
use app\traits\SaveToFileTrait;
use Yii;
use yii\base\Model;

class RecoveryPass extends Model
{

    use AjaxValidationResponseTrait;
    use SaveToFileTrait;

    public $email;

    /**
     * @var Token
     */
    public $token;

    public function behaviors()
    {
        return [
            AuthBehavior::className()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            ['email', 'email'],
            [
                ['email'],
                'exist',
                'targetClass' => User::className(),
                'message'     => Yii::t('error/app', 'Email не существует!'),
            ],
        ];
    }

    public function validateToken(array $data): bool
    {
        $this->token = Token::findOne([
                    'user_id' => $data['id'],
                    'token'   => $data['token']
        ]);

        if ($this->token && $this->token->created_at + 1800 > time()) {
            $this->loginToken();
            return true;
        }
        if ($this->token) {
            $this->token->delete();
        }
        return false;
    }

    public function loginToken()
    {
        Yii::$app->user->login($this->token->user);
        $this->token->delete();
        $this->trigger(SignIn::EVENT_AFTER_SIGN_IN);
    }

    public function recovery($data)
    {
        if ($this->load($data) && $this->validate()) {
            $user = User::findByEmail($this->email);

            if ($user->token) {
                $user->token->delete();
            }

            $this->token             = new Token();
            $this->token->user_id    = $user->id;
            $this->token->token      = Token::createToken();
            $this->token->created_at = time();
            $this->token->save();

            $this->sendMailToken();

            return ['success' => true];
        }
        return ['validation' => $this->validationResponse()];
    }

    public function sendMailToken()
    {
        $link = $this->getRecoveryLink();

        if (YII_ENV_DEV) {
            $this->saveToFile($link, Yii::getAlias('@recoveryLinks'));
        }

        Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['senderEmail'])
                ->setTo($this->email)
                ->setSubject('Text title')
                ->setTextBody('Text message')
                ->setHtmlBody('<a href="' . $link . '">Link</a>')
                ->send();
    }

    public function getRecoveryLink(): string
    {
        $arrayToLink = [
            'site/recovery',
            'id'    => $this->token->user_id,
            'token' => $this->token->token,
        ];

        return UrlHelper::to($arrayToLink, true);
    }

}
