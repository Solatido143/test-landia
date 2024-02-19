<?php

use yii\helpers\Html;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light px-2">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link px-3" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </ul>

<!--     SEARCH FORM -->
    <form class="form-inline">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto">
        <?php if (!Yii::$app->user->isGuest): ?>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user"></i>
                    <?= \yii\helpers\Inflector::camelize(Yii::$app->user->identity->username) ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-item">
                        <?= Html::a('<i class="fas fa-gear"></i> Settings', ['/site/settings'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
                    </li>
                    <li class="dropdown-item">
                        <?= Html::a('<i class="fas fa-sign-out-alt"></i> Logout', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
                    </li>
                </ul>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<!-- /.navbar -->