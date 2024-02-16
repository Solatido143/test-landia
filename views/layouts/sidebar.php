<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Nail Landia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional)   -->
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
<!--                <div class="image">-->
<!--                    <img src="--><?php //= $assetDir ?><!--/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">-->
<!--                </div>-->
                <div class="info">
                    <a href="#" class="d-block"><?= \yii\helpers\Inflector::camelize(Yii::$app->user->identity->username) ?></a>
                </div>
            </div>
        <?php endif; ?>


        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
<!--        <div class="form-inline">-->
<!--            <div class="input-group" data-widget="sidebar-search">-->
<!--                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">-->
<!--                <div class="input-group-append">-->
<!--                    <button class="btn btn-sidebar">-->
<!--                        <i class="fas fa-search fa-fw"></i>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            $isGuest = Yii::$app->user->isGuest;
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Dashboard', 'url' => ['site/index'], 'icon' => 'home', 'visible' => $isGuest, 'options' => ['style' => 'border-bottom: 1px solid #4b545c;']],

                    ['label' => 'User', 'header' => true, 'visible' => $isGuest],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => $isGuest],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>