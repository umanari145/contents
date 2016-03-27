	<div class="row text-center">
			<ul class="nav navbar-nav">
				<!-- サイト説明 -->
				<li class="dropdown">
                <?php
                echo $this->Html->link(
                        'サイト説明',
                        array(
                            'controller' => 'site',
                            'action' => 'siteinfo',
                            'class' => 'dropdown-toggle'
                            )
                        );
                ?>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">aサイト説明</a>
				</li>

				<!-- 人気動画 -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle " data-toggle="dropdown">人気動画</a>
				</li>

				<!-- 人気女優 -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle " data-toggle="dropdown">人気女優</a>
				</li>
			</ul>
		</div>
    </div>
