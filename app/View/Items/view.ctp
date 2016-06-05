<?php 	echo $this->Html->script('resize'); ?>
<div class="pull-right col-xs-12 col-sm-8 col-md-10 col-lg-10">

    <!-- タイトル -->
    <h2><p id="contents_title"><?php echo $itemDetail['Item']['title'];?></p></h2>

    <!-- 動画エリア -->



    <div id="detail_move_area" class="media">
               <?php if( !empty( $itemDetail['Item']['movie_url'])) : ?>
        <?php echo $itemDetail['Item']['movie_url']; ?>
        <?php endif; ?>
    </div>
    <!-- 動画エリア -->

    <div class="col-xs-12 col-sm-8 col-md-10 col-lg-10">
         <div id="attention">
             <p> 動画が表示されないときは再読み込みをしてみてください。</p>
             <p> 表示が重いときは下記のボタンで動画サイズを変更できます。</p>
             <p> ※端末が小さかったり、22:00～深夜2:00の時間帯は中～小サイズのほうがみやすいことがあります。</p>
         </div>
     <div class="btn-group" role="group">
            <button type="button" id="large_size" class="resize btn btn-default">大</button>
            <button type="button" id="middle_size" class="resize btn btn-default">中</button>
            <button type="button" id="small_size" class="resize btn btn-default">小</button>
        </div>
    </div>

    <!-- 商品情報エリア -->
    <div class="contents_summary col-xs-12 col-sm-8 col-md-10 col-lg-10 ">

        <!-- 時間情報 -->
        <div class="detail_volume">
             <span>時間</span>  <?php echo $itemDetail['Item']['volume']; ?>
        </div>
        <!-- 時間情報 -->

        <!-- タグ情報 -->
        <div class="detail_tags">
            <?php if( count($itemDetail['Tag']) > 0 ): ?>
                <span>タグ</span>
            <?php endif; ?>
            <?php foreach ( $itemDetail["Tag"] as $tag ): ?>
            <?php
                    echo $this->Html->link ( $tag['tag'], array (
                                'controller' => 'items',
                                'action' => 'index',
                                 'tag'=>$tag['tag_id']
                        ), array (
                                'class' => 'tag_name btn btn-default',
                        ) );
                        ?>
            <?php endforeach; ?>
        </div>
        <!-- タグ情報 -->

        <!-- コメント -->
        <?php if( DISP_COMMENT === true ): ?>
        <div id="contents_comment">
            <?php
                echo $itemDetail['Item']['comment'];
            ?>
        </div>
        <?php endif; ?>
            <!-- コメント -->
    </div>
    <!-- 商品情報エリア -->

</div>
<!-- 詳細ページの商品全体 -->