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
	<div class="media col-xs-12 col-sm-12 col-md-12 col-lg-12 item_box">
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
				<p>タイトル</p> <?php
					$suf = ( mb_strlen( $item['Item']['title']) > 50) ? ".." : "";
						echo $this->Html->link ( mb_substr ( $item['Item']['title'], 0, 50 ) . $suf,
								array (
									'controller' => 'items',
									'action' => 'view',
								    $item['Item']['id']
							),array(
								'class' => 'item_title'
						)
					);
							?>

			</h2>

			<!-- 女優 -->
			<div class="item_girl">
				<?php if( count($item['Girl']) > 0 ): ?>
					<span><strong>女優</strong></span>
				<?php endif; ?>
				<?php foreach ( $item["Girl"] as $count =>$girl ): ?>
				<?php if( $count < 7 ): ?>
				<?php
						echo $this->Html->link ( $girl['name'], array (
									'controller' => 'items',
									'action' => 'index',
								     'girl' =>$girl['id'],
							), array (
									'class' => 'girl_name btn btn-default',
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
									'class' => 'tag_name btn btn-default'
							) );
							?>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<div class="item_volume">
                <span>時間 </span><?php echo $item['Item']['volume']; ?>分
			</div>

		</div>
	</div>
<?php endforeach;?>
<?php echo $this->element('pager'); ?>
