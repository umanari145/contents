<nav class="navbar navbar-inverse navbar-fixed-top ">
    <div class="row">

        <div class="navbar-header col-xs-3 col-sm-3 col-md-2 col-lg-2">
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

        <ul class="nav navbar-nav col-xs-3 col-sm-3 col-md-2 col-lg-1">
            <!-- サイト説明 -->
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

        <ul class="nav navbar-nav col-xs-3 col-sm-3 col-md-2 col-lg-1">
            <!-- サイト説明 -->
            <li class="dropdown">
                <?php
                echo $this->Html->link(
                        'ログイン',
                        '/users/login',
                        array(
                            'class' => 'dropdown-toggle'
                            )
                        );
                ?>
            </li>
        </ul>

        <ul class="nav navbar-nav col-xs-3 col-sm-3 col-md-2 col-lg-1">
            <!-- サイト説明 -->
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
    </div>
</nav>
