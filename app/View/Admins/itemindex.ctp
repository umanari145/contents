
<ul class="item_area">
    <?php foreach ( $items as $item):?>
    <li>
        <?php
         $suf = ( mb_strlen( $item['Item']['title']) > 50) ? ".." : "";
                    echo $this->Html->link ( mb_substr ( $item ['Item'] ['title'], 0, 50 ) . $suf, array (
                            'controller' => 'admins',
                            'action' => 'edit',
                            $item ['Item'] ['id']
                    ) );

        ?>
    </li>

    <?php endforeach;?>
    </ul>
<ul class="pagination">
        <?php
            echo $this->Paginator->prev(__('前へ'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
            echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
            echo $this->Paginator->next(__('次へ'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
            ?>
    </ul>