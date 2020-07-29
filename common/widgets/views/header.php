<?php

use yii\helpers\Url;

/* @var $this \yii\web\View */
?>
<nav class="navbar navbar-expand-xl">
    <div class="container h-100">
        <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
            <div class="logo mb-0"><img src="<?= Url::base(true) . "/logo.png" ?>" alt=""></div>
        </a>
        <button
            class="navbar-toggler ml-auto mr-0"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
            >
            <i class="fas fa-bars tm-nav-icon"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto h-100">
                <li class="nav-item">
                    <a class="nav-link" href="<?= Yii::$app->homeUrl ?>">
                        <i class="fas fa-home"></i> Главная
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php
                if (Yii::$app->user->isGuest):
                    ?>
                    <li class="nav-item">
                        <a class="nav-link d-block" href="<?= Url::to(['site/auth']) ?>">
                            Авторизация
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="navbarDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            ><?= $userIcon ?><?= $userName ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= Url::to(['profile/']) ?>">Аккаунт</a>
                            <a class="dropdown-item" href="<?= Url::to(['profile/logout']) ?>">Выйти</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php
