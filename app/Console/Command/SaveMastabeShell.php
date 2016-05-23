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
           preg_match_all('/.*?<span class="duration">(.*?)<\/span>.*?<div class="info">.*?<h2><a href="\/video\/(.*?)\/">(.*?)<\/a><\/h2>.*?/s', $html , $res );


           $durationArr    = ( !empty( $res[1])) ? $res[1]:array() ;
           $totalItemArr = array();
           foreach( $durationArr as $no => $duration ){

               $id    = ( !empty( $res[2][$no])) ? $res[2][$no] : "";
               $title = ( !empty( $res[3][$no])) ? $res[3][$no] : "";

               $item = array(
                   'volume'      => $duration,
                   'original_id' => "masta" . $id,
                   'title'       => $title
               );

               $totalItemArr[] = $item;
           }
           $this->extractContentsData( $totalItemArr );
       }
    }

    private function extractContentsData( $totalItemArr ){

        foreach( $totalItemArr as &$item) {

            $link = $item['original_id'];
            $html = file_get_contents( "http://masutabe.info/video/" . $link ."/" );
            if( !empty( $html ) ) {
                preg_match_all( '/.*?(<iframe src=.*?<\/iframe>).*?/s', $html , $res2);

                $movieUrl   = ( !empty( $res2[1][0])) ? $res2[1][0]:"" ;
                if( $movieUrl === "") {
                	continue;
                }
                //マルチバイト対応
                preg_match_all( '/.*?<li><a href="\/search\/[^\x01-\x7E]*?\/">([^\x01-\x7E]*?)<\/a><\/li>.*?/s', $html , $res3);
                $tagArr = ( !empty( $res3[1]) )? $res3[1]:array();
                $item['movie_url'] = $movieUrl;
                $this->saveItemAndTag( $item, $tagArr );

            }
        }

    }

}
