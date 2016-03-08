<div class="row">
	<h2><?php echo $itemDetail['Item']['productName'];?></h2>
	<div class="media">
		<div class="pull-left">
		<?php

		echo $this->Html->image ( $itemDetail ['Item'] ['pictureUrl'], array (
				'class' => 'contents_image',
				'id' => 'contents_image_id_' . $itemDetail ['Item'] ['id'],
				'width'=>'600px',
                'url' => $itemDetail['Item']['productUrl'] . AFFILIATE_ID 
		) );
		?>
 			<div class="media-body">
					<h4 class="media-heading"></h4>
			</div>
		</div>
	</div>
	<div class="col-lg-push-1 col-lg-8 contents_summary row">
			<div class="row">
				<?php echo $itemDetail['Item']['summary'];?>

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
                    <a href="<?php echo $itemDetail['Item']['productUrl'] . AFFILIATE_ID; ?>" >動画はこちら</a>
                </div>
			</div>
	</div>
</div>
