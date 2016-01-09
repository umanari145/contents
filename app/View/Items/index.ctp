	<div class="col-md-6">
	<?php foreach ($items as $item): ?>
		<div class="media">
			<div class="pull-left">
						<?php echo $this->Html->image($item['Item']['smallPictureUrl'],
								array(
										'url'=>array(
										'controller'=>'items',
										'action'=>'view',
										$item['Item']['id']
								),
										'class'=>'contents_image',
										'id' =>'contents_image_id_' . $item['Item']['id']
										));
						 ?>
				</div>
			<div class="media-body">
				<h4 class="media-heading">
					<?php echo $item['Item']['productName']; ?>
					</h4>
					<?php echo $item['Item']['summary']; ?>
				</div>
			<td></td>
		</div>
	<?php endforeach;?>
	</div>