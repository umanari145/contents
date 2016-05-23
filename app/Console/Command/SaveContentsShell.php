<?php
App::uses ( 'AppShell', 'Console/Command' );

class SaveContentsShell extends AppShell {

    // モデルを読み込む
    public $uses = array(
            'Item',
            'Tag',
            'ItemTag',
            'ItemImage'
    );


    public function getItemData() {

       $html = file_get_contents( FIRST_URL );

       //リストページのデータを取得
       if( !empty( $html) ) {
           preg_match_all('/<div class="thumb">(.*?)<\/div>.*?<div class="article_content">.*?<\/div>/s', $html , $res );
           $imageDataArr    = ( !empty( $res[1])) ? $res[1]:array() ;
           $this->extractContentsData( $imageDataArr );
       }
    }

    private function extractContentsData( $imageDataArr ){
        $itemCount = count( $imageDataArr);

        $totalItemArr = array();
        foreach( $imageDataArr as $imagedata) {

             preg_match_all( '/.*?<a href="\/video\.php\?id=(.*?)">.*?<img src="(.*?)" alt="(.*?)".*?"duration">(.*?)<\/span>.*?/s', $imagedata , $res);

             $id     = ( !empty( $res[1][0])) ? $res[1][0]:"" ;
             $image  = ( !empty( $res[2][0])) ? $res[2][0]:"" ;
             $title  = ( !empty( $res[3][0])) ? $res[3][0]:"" ;
             $time   = ( !empty( $res[4][0])) ? $res[4][0]:"" ;

             if( $id !== "" ){

                 $html = file_get_contents( FIRST_DOMAIN . "video.php?id=" . $id );

                 if( !empty( $html ) ) {
                     preg_match_all( '/.*?<li>(<iframe src=.*?<\/iframe>).*?/s', $html , $res2);

                     $movieUrl   = ( !empty( $res2[1][0])) ? $res2[1][0]:"" ;

                     preg_match_all( '/.*?<li><a href="search.php\?keyword=(.*?)">.*?<\/a><\/li>.*?/s', $html , $res3);

                     $tagArr = ( !empty( $res3[1]) )? $res3[1]:array();

                     $itemData = array(
                         'original_id'  => "poyo" . $id,
                         'title'        => $title,
                         'movie_url'    => $movieUrl,
                         'volume'       => $time
                     );
                     $this->saveItemAndTag( $itemData, $tagArr );
                 }
             }
         }
    }

    /**
     * 商品登録＆商品、タグ関連テーブルの保存
     *
     * @param unknown $itemData 商品データ
     * @param unknown $tagArr タグ配列
     */
    protected function saveItemAndTag( $itemData , $tagArr ){
        if( $this->Item->existItem( $itemData['original_id'] ) === false ){
            $this->Item->create();
            $this->Item->save( $itemData );
            $itemId =  $this->Item->getLastInsertId();
            $this->log( " id : ". $itemId . "  title : " . $itemData['title'], 'debug');
            foreach ( $tagArr as &$tag ) $tag = $this->Tag->getfindTagIdFromName( $tag );
            $this->ItemTag->saveItemTagRelation( $itemId, $tagArr );
        }
    }

}
