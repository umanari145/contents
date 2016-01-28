<?php echo $this->element('search'); ?>
<div class="row">
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

		<a href="./view/<?php echo $item['Item']['id'];?>" >
			<div class="media-body">
				<h2 class="media-heading">
				<?php echo mb_substr ( $item['Item']['productName'], 0, 30 ) . "..";   ?>
				</h2>
				<div class="list_summary">
					<?php
					    echo mb_substr ( $item['Item']['summary'], 0, 150 ). "..";
					 ?>
				 </div>
			</div>
		</a>
	</div>
<?php endforeach;?>
    	<ul class="pagination">
            <?php
                echo $this->Paginator->prev(__('前へ'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
                echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
                echo $this->Paginator->next(__('次へ'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
            ?>
        </ul>
</div>
