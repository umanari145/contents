<nav class="navbar navbar-inverse  navbar-fixed-top ">
	<div class="container">
	<div class="row">
	    <div class="navbar-header col-xs-offset-2 col-ls-offset-2">
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

		<ul class="nav navbar-nav">
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

			<!-- 人気動画 -->
			<li class="dropdown">
				<a href="#" class="dropdown-toggle " data-toggle="dropdown">人気動画</a>
			</li>
		</ul>
	</div>

	</div>
</nav>
