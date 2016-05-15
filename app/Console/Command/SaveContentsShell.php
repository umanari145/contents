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
    public function main() {
        $this->out ( "start_batch" );
        $this->out ( date ( "Y-m-d H:i:s" ) );
        $this->getItemData ();
        $this->out ( date ( "Y-m-d H:i:s" ) );
        $this->out ( "last_batch" );
    }
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
                 $html = file_get_contents( FIRST_URL . "video.php?id=" . $id );
                 if( !empty( $html ) ) {
                     preg_match_all( '/.*?<li><iframe src="(.*?)".*?/s', $html , $res2);
                     $movieUrl   = ( !empty( $res2[1][0])) ? $res2[1][0]:"" ;
                     
                     preg_match_all( '/.*?<li><a href="search.php\?keyword=(.*?)">.*?<\/a><\/li>.*?/s', $html , $res3);
                     
                     $itemData = array(
                         'original_id'  => $id,
                         'title'        => $title,
                         'movie_url'    => $movieUrl,
                         'volume'       => $time
                     );

                //     if( $this->Item->existItem( $id ) === false ){
                         
                    //     $this->Item->create();
                    //     $this->Item->save( $itemData );
                    //     $item_id =  $this->Item->getLastInsertId();
                         
                         $tagArr = ( !empty( $res3[1]) )? $res3[1]:array();
                         foreach( $tagArr as $tag ){
                             $tagId =  $this->Tag->getfindTagIdFromName( $tag );
                             
                             $tagEntity = array(
                                  'item_id' => $item_id,
                                  'tag_id'  => $tagId
                             );

                             $this->ItemTag->create()
                             $this->ItemTag->save( $tagEntity );
                         }
                     //  }
                   } 
             }
        }
    }

}
