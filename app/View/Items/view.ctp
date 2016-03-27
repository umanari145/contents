<div class="row">
	<h2><p id="contents_title"><?php echo $itemDetail['Item']['title'];?></p></h2>
	<div class="media">
		<div class="pull-left">

        <?php
         echo $itemDetail['Item']['moveUrl'];
        ?>
 			<div class="media-body">
					<h4 class="media-heading"></h4>
			</div>
		</div>
	</div>
	<div class="col-lg-push-1 col-lg-8 contents_summary row">
			<div class="row">

				<div class="detail_girls">
					<?php if( count($itemDetail['Girl']) > 0 ): ?>
						<span>女優</span>
					<?php endif; ?>

					<?php foreach ( $itemDetail["Girl"] as $girl ): ?>
					<?php
							echo $this->Html->link ( $girl['name'], array (
										'controller' => 'items',
										'action' => 'index',
									     'girl'=>$girl['id']
								), array (
										'class' => 'girl_name',
								) );
								?>
					<?php endforeach; ?>
				</div>

				<div class="detail_tags">
					<?php if( count($itemDetail['Tag']) > 0 ): ?>
						<span>タグ</span>
					<?php endif; ?>
					<?php foreach ( $itemDetail["Tag"] as $tag ): ?>
					<?php
							echo $this->Html->link ( $tag['tag'], array (
										'controller' => 'items',
										'action' => 'index',
									     'tag'=>$tag['id']
								), array (
										'class' => 'tag_name',
								) );
								?>
					<?php endforeach; ?>
				</div>

                <div class="contents_link">
                    <a href="<?php echo $itemDetail['Item']['productUrl'] . AFFILIATE_ID; ?>" >もっと見たい方はこちら </a>
                </div>
			</div>
	</div>
</div>
