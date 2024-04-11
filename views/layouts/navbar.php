<?php

use yii\helpers\Html;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light px-2">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
<!--        <li class="nav-item">-->
<!--            <a class="nav-link px-3" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>-->
<!--        </li>-->
        <li class="nav-item">
            <a class="nav-link px-3" href="/nailandia" role="button"><i class="fas fa-house-chimney"></i>&nbspDashboard</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto">
        <?php if (!Yii::$app->user->isGuest): ?>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-bell position-relative">
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-item">
                        New Notification
                    </li>
                </ul>
            </li>
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