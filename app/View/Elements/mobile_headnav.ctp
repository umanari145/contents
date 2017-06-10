<nav class="navbar navbar-inverse navbar-fixed-top ">

    <div class="header-container nav-header">

        <div class="header-item header_logo">
        <?php
            echo $this->Html->link ( 'JK-Collection','/items/index');
        ?>
        </div>

        <?php if( $isLogin === true ):?>
        <div class="header-item">
        <!-- お気に入り -->
            <?php
            echo $this->Html->link(
                    'お気に入り',
                    '/items/favorite',
                    array(
                        'class' => 'dropdown-toggle'
                        )
                    );
            ?>
        <?php endif; ?>

        <div class="header-item">
            <!-- ログイン名 -->
            <span><?php echo $username; ?></span>
        </div>

        <div class="header-item">
            <!-- ログイン -->
            <span>
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
            </span>
        </div>

        <?php if( $isLogin === false ):?>
        <div class="header-item">
        <!-- 新規 -->
           <?php
           echo $this->Html->link(
                   '新規登録',
                   '/users/regist',
                   array(
                       'class' => 'dropdown-toggle'
                       )
                   );
           ?>
        </div>
        <?php endif; ?>

        <div class="header-item">
        <!-- タグ -->
           <?php
           echo $this->Html->link('タグ','#left-menu',array('id'=>'left-menu'));
           ?>
        </div>
    </div>
</nav>
