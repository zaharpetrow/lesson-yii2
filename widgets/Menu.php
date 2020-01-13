<?php

namespace app\widgets;

use app\components\Avatar;
use Yii;
use yii\base\Widget;

class Menu extends Widget
{

    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $userIcon        = '<div class="user-icon icon-xs" style="background: url(' . Avatar::getIconXS() . ')"></div>';
        $userName        = '<div class="menu-username">' . Yii::$app->user->identity->name . '</div>';
        $profileMenuItem = [
            'label'    => Yii::$app->user->identity->name,
            'options'  => ['class' => 'dropdown'],
            'template' => '<a href="#" class="menuitem-profile" data-toggle="dropdown">'
            . $userIcon
            . '<div class="menu-username">{label}</div>'
            . '</a>',
            'items'    => [
                [
                    'label' => Yii::t('menu', 'Аккаунт'),
                    'url'   => ['/profile']
                ],
                [
                    'label' => Yii::t('menu', 'Выйти'),
                    'url'   => ['/logout']
                ]
            ],
        ];
        return $this->render('menu', compact('userIcon', 'userName'));
    }

}
