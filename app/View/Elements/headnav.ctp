<nav class="navbar navbar-inverse  navbar-fixed-top ">
	<div class="container">
		<div class="row text-center">
		    <div class="navbar-header">
		    <?php
				echo $this->Html->link ( 'TOP',
					'/items/index',
					array('class'=>'navbar-brand')
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

				<!-- 人気女優 -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle " data-toggle="dropdown">人気女優</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
