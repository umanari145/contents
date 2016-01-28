<nav class="navbar navbar-inverse  navbar-fixed-top">
	<div class="container">
	    <div class="navbar-header">
	    <?php
			echo $this->Html->link ( 'コンテンツサイト',
				'/items/index',
				array('class'=>'navbar-brand')
			 );
	    ?>
	    </div>

		<ul class="nav navbar-nav">
			<!-- サイト説明 -->
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">サイト説明<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li>説明1</li>
				</ul>
			</li>

			<!-- アイテム一覧 -->
			<li class="dropdown"><a href="#" class="dropdown-toggle " data-toggle="dropdown">アイテム一覧<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li>アイテム2</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>