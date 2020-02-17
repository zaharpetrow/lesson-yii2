<?php

namespace app\widgets;

use app\components\Avatar;
use Yii;
use yii\base\Widget;

class Menu extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $userIcon        = '<div class="user-icon icon-xs" style="background: url(' . Avatar::getIconXS() . ')"></div>';
        $userName        = '<div class="menu-username">' . Yii::$app->user->identity->name . '</div>';

        return $this->render('header', compact('userIcon', 'userName'));
    }

}
