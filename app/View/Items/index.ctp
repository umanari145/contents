<?php echo $this->element('search'); ?>
<div class="row col-lg-12">
<?php echo $this->element('pager'); ?>
<?php foreach ($items as $item): ?>
	<div class="media col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="pull-left">
					<?php

					echo $this->Html->image ( $item ['Item'] ['smallPictureUrl'], array (
								'url' => array (
										'controller' => 'items',
										'action' => 'view',
										$item ['Item'] ['id']
								),
								'class' => 'contents_image',
								'id' => 'contents_image_id_' . $item ['Item'] ['id']
						) );
	?>
		</div>


		<div class="media-body">
			<h2 class="media-heading">
				<?php
						echo $this->Html->link ( mb_substr ( $item['Item']['productName'], 0, 50 ) . "..",
								array (
									'controller' => 'items',
									'action' => 'view',
								    $item['Item']['id']
							)
								);
							?>

			</h2>
			</a>

			<div class="item_tag">
				<?php foreach ( $item["Tag"] as $tag ): ?>
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
		</div>
	</div>
<?php endforeach;?>
<?php echo $this->element('pager'); ?>
</div>
