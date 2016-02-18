
<div class="row col-md-2">
	<div class="sidebar-nav">
		<ul class="nav">
        <?php foreach ( $tagList as $tag): ?>
        <li>
        <?php
									echo $this->Html->link ( __ ( $tag ['tagName'] . "(" . $tag ['count'] . ")" ), array (
											'controller' => 'tags',
											'action' => 'tagList',
											$tag ['id']
									) );

									?>
          </li>
          <?php endforeach;; ?>
        </ul>
	</div>
</div>