<nav class="navbar navbar-inverse">
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
					<li><?php echo $this->Html->link(__('スタッフ勤務履歴'), array('controller'=>'admin','action' => 'userworkdata')); ?></li>
					<li><?php echo $this->Html->link(__('スタッフ稼働履歴管理'), array('controller'=>'admin','action' => 'useractiveworkdata')); ?></li>
					<li><?php echo $this->Html->link(__('スタッフ報酬比率'), array('controller'=>'admin','action' => 'serviceindex')); ?></li>
				</ul>
			</li>

			<!-- アイテム一覧 -->
			<li class="dropdown"><a href="#" class="dropdown-toggle " data-toggle="dropdown">アイテム一覧<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><?php echo $this->Html->link(__('部屋予約一覧'), array('controller'=>'admin','action' => 'reserveroom')); ?></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>