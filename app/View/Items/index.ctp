<?php echo $this->element('search'); ?>
<div class="row col-lg-12">
    <?php if( !empty($search_name)):?>
        <span>キーワード:<?php echo $search_name; ?></span>
    <?php endif;?>
    <span>
	    <?php
	    echo $this->Paginator->counter('{:count} 件中 {:start}～{:end}件を表示');
	    ?>
    </span>
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
			<h2 class="media-heading contents_title">
				<?php
						echo $this->Html->link ( mb_substr ( $item['Item']['title'], 0, 50 ) . "..",
								array (
									'controller' => 'items',
									'action' => 'view',
								    $item['Item']['id']
							)
								);
							?>

			</h2>

			<!-- 女優 -->
			<div class="item_girl">
				<?php if( count($item['Girl']) > 0 ): ?>
					<span>女優</span>
				<?php endif; ?>
				<?php foreach ( $item["Girl"] as $count =>$girl ): ?>
				<?php if( $count < 7 ): ?>
				<?php
						echo $this->Html->link ( $girl['name'], array (
									'controller' => 'items',
									'action' => 'index',
								     'girl' =>$girl['id'],
							), array (
									'class' => 'girl_name',
							) );
							?>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>

            <!-- タグ -->
			<div class="item_tag">
				<?php if( count($item['Tag']) > 0 ): ?>
					<span>タグ</span>
				<?php endif; ?>
				<?php foreach ( $item["Tag"] as $count2 => $tag ): ?>
				<?php if( $count2 < 7 ): ?>
				<?php
						echo $this->Html->link ( $tag['tag'], array (
									'controller' => 'items',
									'action' => 'index',
								     'tag' => $tag['id']
							), array (
									'class' => 'tag_name'
							) );
							?>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>

		</div>
	</div>
<?php endforeach;?>
<?php echo $this->element('pager'); ?>
