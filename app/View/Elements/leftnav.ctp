
<div class="row col-md-3">

    <h2>タグ</h2>
	<div id="tag_list_area" class="sidebar-nav">
		<ul class="nav">
        <?php foreach ( $tagList as $tag): ?>
        <li class="tag_list">
        <?php
			echo $this->Html->link ( __ ( $tag ['tagName'] . "(" . $tag ['count'] . ")" ), array (
					'controller' => 'items',
					'action' => 'index',
					'tag' => $tag ['id']
			) );
		?>
         </li>
        <?php endforeach;; ?>
        </ul>
	</div>

    <h2>人気女優</h2>
	<div id="girl_list_area" class="sidebar-nav">
		<ul class="nav">
        <?php foreach ( $popularGirlList as $popularGirl ): ?>
        <?php if( !empty($popularGirl['Girl']['name'] ) ): ?>
        <li class="girl_list">
        <?php
			echo $this->Html->link ( __ ( $popularGirl['Girl']['name'] . "(" . $popularGirl[0]['num'] . ")" ), array (
					'controller' => 'items',
					'action' => 'index',
					'girl' => $popularGirl['ItemGirl']['girl_id']
			) );
		?>
          </li>
          <?php endif; ?>
          <?php endforeach;; ?>
        </ul>
	</div>
</div>
