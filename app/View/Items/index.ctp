<?php echo $this->element('search'); ?>
<div class="row col-lg-12">
<?php echo $this->element('pager'); ?>
<?php foreach ($items as $item): ?>
	<div class="media col-xs-6 col-sm-6 col-md-6 col-lg-6">
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

		<a href="./view/<?php echo $item['Item']['id'];?>" >
			<div class="media-body">
				<h2 class="media-heading">
				<?php echo mb_substr ( $item['Item']['productName'], 0, 30 ) . "..";   ?>
				</h2>
			</div>
		</a>
	</div>
<?php endforeach;?>
<?php echo $this->element('pager'); ?>
</div>
