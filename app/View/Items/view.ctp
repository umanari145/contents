<div class="row">
    <h2><p id="contents_title"><?php echo $itemDetail['Item']['title'];?></p></h2>
    <div class="media">
        <div class="pull-left">

        <?php if( !empty( $itemDetail['Item']['movieUrl'])) : ?>
        <p id="movie_area">
        <?php
            echo $itemDetail['Item']['movieUrl'];
        ?>
        </p>
        <?php endif; ?>
             <div class="media-body">
                    <h4 class="media-heading"></h4>
            </div>
        </div>
    </div>
    <div class="col-lg-push-1 col-lg-8 contents_summary row">
            <div class="row">
                <div class="detail_tags">
                    <?php if( count($itemDetail['Tag']) > 0 ): ?>
                        <span>タグ</span>
                    <?php endif; ?>
                    <?php foreach ( $itemDetail["Tag"] as $tag ): ?>
                    <?php
                            echo $this->Html->link ( $tag['tag'], array (
                                        'controller' => 'items',
                                        'action' => 'index',
                                         'tag'=>$tag['id']
                                ), array (
                                        'class' => 'tag_name btn btn-default',
                                ) );
                                ?>
                    <?php endforeach; ?>
                </div>

                <div class="detail_volume">
                     <span>時間</span>  <?php echo $itemDetail['Item']['volume']; ?>分
                </div>
                <?php if( DISP_COMMENT === true ): ?>

                <div id="contents_comment">
                    <?php
                        echo $itemDetail['Item']['comment'];
                    ?>
                   </div>
                <?php endif; ?>

            </div>
    </div>
</div>
