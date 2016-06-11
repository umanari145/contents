<nav class="navbar navbar-inverse navbar-fixed-top ">
    <div class="row">

        <div class="navbar-header col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <?php
            echo $this->Html->link ( 'JK-Collection',
                '/items/index',
                array(
                 'class'=>'navbar-brand',
                 'id'=>'nav-header-title'
                )
             );
        ?>
        </div>

        <?php if( $isLogin === true ):?>
        <ul class="nav navbar-nav col-xs-2 col-sm-2 col-md-2 col-lg-1">
            <!-- お気に入り -->
            <li class="dropdown">
                <?php
                echo $this->Html->link(
                        'お気に入り',
                        '/items/favorite',
                        array(
                            'class' => 'dropdown-toggle'
                            )
                        );
                ?>
            </li>
        </ul>
        <?php endif; ?>

        <ul class="nav navbar-nav col-xs-2 col-sm-2 col-md-2 col-lg-1">
            <!-- ログイン名 -->
            <li class="dropdown">
                <div id="login_username">ユーザー名:<?php echo $username; ?></div>
            </li>
        </ul>

        <ul class="nav navbar-nav col-xs-2 col-sm-2 col-md-2 col-lg-1">
            <!-- ログイン -->
            <li class="dropdown">
                <?php if( $isLogin === false ):?>
                <?php
                    echo $this->Html->link(
                        'ログイン',
                        '/users/login',
                        array(
                            'class' => 'dropdown-toggle'
                            )
                        );
                ?>
                <?php else:?>
                <?php
                    echo $this->Html->link(
                        'ログアウト',
                        '/users/logout',
                        array(
                            'class' => 'dropdown-toggle'
                            )
                        );
                ?>
                <?php endif; ?>
            </li>
        </ul>

        <?php if( $isLogin === false ):?>
        <ul class="nav navbar-nav col-xs-2 col-sm-2 col-md-2 col-lg-1">
            <!-- 新規 -->
            <li class="dropdown">
                <?php
                echo $this->Html->link(
                        '新規登録',
                        '/users/regist',
                        array(
                            'class' => 'dropdown-toggle'
                            )
                        );
                ?>
            </li>
        </ul>
        <?php endif; ?>

    </div>
</nav>
