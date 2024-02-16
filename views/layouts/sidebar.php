<aside class="main-sidebar sidebar-dark-info elevation-4" style="background: #0a0e14; overflow-y: auto;">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Nailandia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional)   -->
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?= $assetDir ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?= \yii\helpers\Inflector::camelize(Yii::$app->user->identity->username) ?></a>
                </div>
            </div>
        <?php endif; ?>
        <nav>
            <?php
            $isGuest = !Yii::$app->user->isGuest;
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
//                    system
                    ['label' => 'System', 'header' => true , 'options' => ['style' => 'color: #6c757d'], 'visible' => $isGuest],
                    [
                        'label' => 'Dashboard',
                        'url' => ['site/index'],
                        'icon' => 'home',
                        'visible' => $isGuest
                    ],
                    [
                        'label' => 'Pos',
                        'url' => ['site/pos'],
                        'icon' => 'chart-simple',
                        'visible' => $isGuest,
//                        'options' => ['style' => 'border-bottom: 1px solid #4b545c;']
                    ],

                    [
                        'label' => 'Sales',
                        'icon' => 'sack-dollar',
                        'visible' => $isGuest,
                        'items' => [
                            ['label' => 'Booking', 'url' => ['site/bookings'], 'icon' => 'check-to-slot'],
                            ['label' => 'Sales Receipt', 'url' => ['site/receipts'], 'icon' => 'receipt'],

                        ]
                    ],
                    [
                        'label' => 'Items',
                        'icon' => 'list',
                        'visible' => $isGuest,
                        'items' => [
                            ['label' => 'Products', 'url' => ['site/products'], 'icon' => 'box'],
                        ]
                    ],

                    ['label' => 'Reports', 'url' => ['site/reports'], 'visible' => $isGuest, 'icon' => 'file-lines'],
                    ['label' => 'Employee\'s', 'url' => ['site/team'], 'visible' => $isGuest, 'icon' => 'user-group'],


//                    user
                    ['label' => 'User', 'header' => true , 'options' => ['style' => 'color: #6c757d']],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => !$isGuest,],
                    ['label' => 'Signup', 'url' => ['site/register'], 'icon' => 'sign-in-alt', 'visible' => !$isGuest,],
                    [
                        'label' => 'Profile',
                        'icon' => 'user',
                        'visible' => $isGuest,
                        'items' => [
                            ['label' => 'Settings', 'url' => ['site/settings'], 'icon' => 'gear'],
                            ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => !$isGuest,],
                            ['label' => 'Signup', 'url' => ['site/register'], 'icon' => 'sign-in-alt', 'visible' => !$isGuest,],

                            [
                                'label' => 'Logout',
                                'url' => ['site/logout'],
                                'icon' => 'right-from-bracket',
                                'visible' => $isGuest,
                                'linkTemplate' => '<a class="nav-link {active}" href="{url}" data-method="post">{icon} {label}</a>',
                            ],
                        ]
                    ],



                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>