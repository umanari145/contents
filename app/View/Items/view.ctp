<div class="row">
	<h2><?php echo $itemDetail['Item']['productName'];?></h2>
	<div class="media">
		<div class="pull-left">
		<?php

		echo $this->Html->image ( $itemDetail ['Item'] ['pictureUrl'], array (
				'class' => 'contents_image',
				'id' => 'contents_image_id_' . $itemDetail ['Item'] ['id']
		) );
		?>
 			<div class="media-body">
					<h4 class="media-heading"></h4>
			</div>
		</div>
	</div>
	<div class="row">
			<?php foreach ( $itemDetail["Tag"] as $tag ): ?>
			<?php
					echo $this->Html->link ( $tag['tag'], array (
								'controller' => 'tags',
								'action' => 'tagList',
							     $tag['id']
						), array (
								'class' => 'btn btn-primary',
								'role' => 'button'
						) );
						?>
			<?php endforeach; ?>
	</div>
	<div class="row">
		<?php echo $itemDetail['Item']['summary'];?>
	</div>
</div>