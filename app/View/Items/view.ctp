<script type="text/javascript" >
$(function(){
        $('.contents_image').magnificPopup({
             delegate: 'a',
             type: 'image',
             gallery: { //ギャラリー表示にする
                 enabled:true
             }
        });
});
</script>

<div class="row">
    <h2><p id="contents_title"><?php echo $itemDetail['Item']['title'];?></p></h2>
    <div class="media">
        <div class="pull-left">

        <?php if( DISP_LARGE_IMAGE === true ): ?>
        <?php
        echo $this->Html->image ( $itemDetail['Item'] ['largePictureUrl'], array (
                'url' => $itemDetail['Item']['URL'] . AFFILIATE_ID ,
                'class' => 'top_contents_image',
                'id' => 'contents_image_id_' . $itemDetail['Item'] ['id']
           )
        );
        ?>
        <?php endif; ?>

        <?php if( DISP_MOVIE === true && !empty( $itemDetail['Item']['moveUrl'])) : ?>
        <p id="movie_area">
        <?php
            echo $itemDetail['Item']['moveUrl'];
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

                <div class="detail_girls">
                    <?php if( count($itemDetail['Girl']) > 0 ): ?>
                        <span>女優</span>
                    <?php endif; ?>

                    <?php foreach ( $itemDetail["Girl"] as $girl ): ?>

                    <?php
                            echo $this->Html->link ( $girl['name'], array (
                                        'controller' => 'items',
                                        'action' => 'index',
                                         'girl'=>$girl['id']
                                ), array (
                                        'class' => 'girl_name btn btn-default',
                                ) );
                                ?>
                    <?php endforeach; ?>
                </div>

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
                <?php endif;; ?>

                <div class="contents_link">
                    <a href="<?php echo $itemDetail['Item']['URL'] . AFFILIATE_ID; ?>" >もっと見たい方はこちら </a>
                </div>

                <?php if( DISP_ITEM_IMAGE === true  && !empty($itemImage) ): ?>

                    <div class="contents_image">
                        <?php foreach ( $itemImage as $no => $image):?>
                        <p class="contents_single_image">
                        <?php if( !empty($largeItemImage[$no])): ?>
                            <?php
                                echo $this->Html->image($image,array(
                                    'url' => $largeItemImage[$no]
                                ));
                            ?>
                        <?php else:?>
                            <?php
                                echo $this->Html->image($image);
                            ?>
                        <?php endif; ?>
                        </p>
                        <?php endforeach; ?>
                       </div>

                       <div class="contents_link">
                        <a href="<?php echo $itemDetail['Item']['URL'] . AFFILIATE_ID; ?>" >もっと見たい方はこちら </a>
                    </div>
                <?php endif; ?>

            </div>
    </div>
</div>
