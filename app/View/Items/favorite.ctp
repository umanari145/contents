
<div class="total_main_contents_area pull-right col-xs-12 col-sm-8 col-md-10 col-lg-10">

    <!-- 検索窓 -->
    <div class="col-xs-offset-1 col-xs-11 col-sm-offset-2 col-sm-6 col-md-offset-8 col-md-2 col-lg-offset-8 col-lg-2" >
        <?php echo $this->element('search'); ?>
    </div>

    <!-- 検索語句と表示数 -->
    <div class="search_result_disp col-xs-12 col-sm-8 col-md-10 col-lg-10">
        <?php if( !empty($search_name)):?>
            <span>キーワード:<?php echo $search_name; ?></span>
        <?php endif;?>
        <span>
            <?php
            echo $this->Paginator->counter('{:count} 件中 {:start}～{:end}件を表示');
            ?>
        </span>
    </div>

    <!-- ページャー -->
    <div id="pager_area" class="col-xs-12 col-sm-8 col-md-10 col-lg-10">
        <?php echo $this->element('pager'); ?>
    </div>

    <!-- メインコンテンツエリア -->
    <div class="total_contents_area col-xs-12 col-sm-8 col-md-10 col-lg-10">

        <?php if( count( $items ) === 0 ):?>
            <div id="no_favorite_message">
                <?php echo "お気に入りはまだ一件も登録されていません"; ?>
            </div>
        <?php else:?>
            <!-- 各コンテンツの入れ物 -->
            <div class="row">

                <?php ?>

                <?php foreach ($items as $item): ?>
                <!-- 各コンテンツ -->
                <div class="index_contents_area col-xs-12 col-sm-8 col-md-4 col-lg-3">

                    <!-- 画像 -->
                    <div class="pull-left col-xs-12 col-sm-8 col-md-4 col-lg-3">
                        <?php
                                echo $this->Html->image ( $item ['Item'] ['original_id'] .".jpg", array (
                                            'url' => array (
                                                    'controller' => 'items',
                                                    'action' => 'view',
                                                    $item ['Item'] ['id']
                                            ),
                                            'width'  => 150,
                                            'class' => 'contents_image',
                                            'id' => 'contents_image_id_' . $item ['Item'] ['id']
                                    ) );
                         ?>
                    </div>
                    <!-- 画像 -->

                    <!-- コンテンツ情報 -->
                    <div class="media-body col-xs-12 col-sm-8 col-md-4 col-lg-3">

                        <h2 class="media-heading contents_title">
                             <?php
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

                        <div class="item_volume">
                            <span>時間 </span><?php echo $item['Item']['volume']; ?>
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
                                                'class' => 'tag_name btn btn-xs'
                                        ) );
                                        ?>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <!-- タグ情報 -->
                    </div>
                    <!-- コンテンツ情報 -->

                </div>
                <!-- 各コンテンツ -->

                <?php endforeach;?>
            </div>
            <!-- 各コンテンツのいれもの -->
        <?php endif; ?>
    </div>
    <!-- メインコンテンツエリア -->

    <!-- ページャー -->
    <div id="pager_area" class="col-xs-12 col-sm-8 col-md-10 col-lg-10">
        <?php echo $this->element('pager'); ?>
    </div>

</div>