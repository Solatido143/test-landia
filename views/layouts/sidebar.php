<aside class="main-sidebar sidebar-dark-info elevation-4" style="background: #0a0e14; overflow-y: auto;">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="/imgs/nailandia-logo.png" style="cursor:pointer; margin: 0 5px 0 5px" class="d-none card-mg-top" height="45" alt="E-CMV">
        <span class="brand-text font-weight-light">
            <img src="/imgs/nailandia-logo.png" style="cursor:pointer; margin: 0 5px 0 5px" class="card-mg-top" height="45" alt="E-CMV">
            <strong>AEP - MPOS</strong>
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional)   -->
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <p style="margin:0; color: white"><i class="fa fa-user"></i>&nbsp; <?= \yii\helpers\Inflector::camelize(Yii::$app->user->identity->username) ?></p>
                    <p style="margin:0; color: white">
                        <?php
                        $userAccessId = Yii::$app->user->identity->user_access;
                        $role = \app\models\Roles::findOne($userAccessId); // Assuming Roles is your role model
                        echo $role ? $role->name : 'No Role';
                        ?>
                    </p>
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
                        'url' => ['/pos'],
                        'icon' => 'chart-simple',
                        'visible' => $isGuest,
//                        'options' => ['style' => 'border-bottom: 1px solid #4b545c;']
                    ],


//                    [
//                        'label' => 'Sales',
//                        'icon' => 'sack-dollar',
//                        'visible' => $isGuest,
//                        'items' => [
//                            ['label' => 'Booking', 'url' => ['bookings'], 'icon' => 'check-to-slot'],
//                            ['label' => 'Sales Receipt', 'url' => ['receipts'], 'icon' => 'receipt'],
//                            ['label' => 'services', 'url' => ['services'], 'icon' => 'scroll'],
//
//                        ]
//                    ],
                    [
                        'label' => 'Inventory',
                        'url' => ['/products/index'],
                        'icon' => 'boxes',
                        'visible' => $isGuest,
                    ],
                    [
                        'label' => 'Attendance',
                        'url' => ['/attendance/index'],
                        'icon' => 'clock',
                        'visible' => $isGuest,
                    ],

//                    ['label' => 'Reports', 'url' => ['reports'], 'visible' => $isGuest, 'icon' => 'file-lines'],

//                    admin
                    ['label' => 'Admin', 'header' => true , 'options' => ['style' => 'color: #6c757d'], 'visible' => $isGuest],
                    ['label' => 'Employee\'s', 'url' => ['/employees/index'], 'visible' => $isGuest, 'icon' => 'user-group'],
                    ['label' => 'Services', 'url' => ['/services/index'], 'visible' => $isGuest, 'icon' => 'hand-holding-hand'],
                    ['label' => 'User Management', 'url' => ['/user-manage/index'], 'visible' => $isGuest, 'icon' => 'user-gear'],

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