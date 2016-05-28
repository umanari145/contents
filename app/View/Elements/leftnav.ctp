
<div id="side_contents" class="pull-left col-xs-12 col-sm-4 col-md-2 col-lg-2">
    <h2 class="left_tag">タグ</h2>
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
</div>
