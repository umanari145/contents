<?php

App::uses ( 'SaveContentsShell', 'Console/Command' );
class SaveMastabeShell extends SaveContentsShell {

    // モデルを読み込む
    public $uses = array(
            'Item',
            'Tag',
            'ItemTag',
    );


    public function getItemData() {

       $html = file_get_contents( SECOND_URL );

       //リストページのデータを取得
       if( !empty( $html) ) {
           preg_match_all('/.*?<figure>.*?<img src="(.*?)">.*?<span class="duration">(.*?)<\/span>.*?<div class="info">.*?<h2><a href="\/video\/(.*?)\/">(.*?)<\/a><\/h2>.*?<\/figure>.*?/s', $html , $res );

           $durationArr    = ( !empty( $res[2])) ? $res[2]:array() ;
           $totalItemArr = array();

           foreach( $durationArr as $no => $duration ){
               $image  = ( !empty( $res[1][$no])) ? $res[1][$no] : "";
               $id     = ( !empty( $res[3][$no])) ? $res[3][$no] : "";
               $title  = ( !empty( $res[4][$no])) ? $res[4][$no] : "";

               if( preg_match('/^\/files/',$image) === 1 ) {
                   $image = SECOND_DOMAIN . $image;
               }

               $item = array(
                   'volume'         => $duration,
                   'original_id'    => $id,
                   'title'          => $title,
                   'image_url'     => $image
               );

               $totalItemArr[] = $item;
           }
           $this->extractContentsData( $totalItemArr );

       }else{
           $this->log( " this contents cannnot scraping " . SECOND_URL , 'debug');
       }
    }

    private function extractContentsData( $totalItemArr ){

        foreach( $totalItemArr as &$item) {

            $link = $item['original_id'];
            $html = file_get_contents( SECOND_DOMAIN ."video/" . $link ."/" );

            if( !empty( $html ) ) {
                preg_match_all( '/.*?(<iframe.*?<\/iframe>).*?/s', $html , $res2);
                $item['original_id'] = "mas". $item['original_id'];
                $movieUrl   = ( !empty( $res2[1][0])) ? $res2[1][0]:"" ;
                if( $movieUrl === "") {
                    continue;
                }
                //マルチバイト対応
                preg_match_all( '/.*?<li><a href="\/search\/[^\x01-\x7E]*?\/">([^\x01-\x7E]*?)<\/a><\/li>.*?/s', $html , $res3);
                $tagArr = ( !empty( $res3[1]) )? $res3[1]:array();
                $item['movie_url'] = $movieUrl;
                $dbRes = $this->saveItemAndTag( $item, $tagArr );
                if( $dbRes === true ){
                    $imageName = $item['original_id'];
                    $this->downloadAndUploadImage( $item['image_url'], $imageName);

                }
            }else{
                $this->log( " cannnot get masta" . $item['original_id'] , 'debug');
            }
        }

    }

}
