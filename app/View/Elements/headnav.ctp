<nav class="navbar navbar-inverse navbar-fixed-top ">
    <div class="row">

        <div class="navbar-header col-xs-6 col-sm-4 col-md-2 col-lg-2">
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

        <ul class="nav navbar-nav col-xs-6 col-sm-4 col-md-2 col-lg-1">
            <!-- サイト説明 -->
            <li class="dropdown">
                <?php
                echo $this->Html->link(
                        'サイト説明',
                        '/site/siteinfo',
                        array(
                            'class' => 'dropdown-toggle',
                            'target' => '_blank'
                            )
                        );
                ?>
            </li>
        </ul>
    </div>
</nav>
