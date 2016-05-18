<?php

App::uses ( 'SaveContentsShell', 'Console/Command' );

class SaveJksexvideoShell extends SaveContentsShell {

    // モデルを読み込む
    public $uses = array(
            'Item',
            'Tag',
            'ItemTag'
    );

    public function getItemData() {

       $html = file_get_contents( THIRD_URL );

       //リストページのデータを取得
       if( !empty( $html) ) {
           preg_match_all('/.*?<span.*?class="deco"><a.*?href=".*?jk(\d*?)" title="(.*?)">.*?<\/span>.*?/s', $html , $res );

           $idArr  = ( !empty( $res[1])) ? $res[1] : array();

           foreach( $idArr as $no => $id ){

               $title = ( !empty( $res[2][$no])) ? $res[2][$no] : "";
               $html2 = file_get_contents( THIRD_URL ."jk" . $id );

               if( !empty( $html2 ) ) {
                   preg_match_all('/.*?<iframe.*?src="(.*?)".*?>.*?/s', $html2 , $res2 );

                   $url = ( !empty( $res2[1][0])) ? $res2[1][0]:"";

                   if( $url === "" ) {
                       preg_match_all('/.*?<div.*?class="video-container">(.*?)<\/div>.*?/s', $html2 , $res2 );
                       $url = ( !empty( $res2[1][0])) ? $res2[1][0]:"";
                   }

                   preg_match_all('/.*?rel="category tag">(.*?)<\/a>.*?/s', $html2 , $res3 );
                   $tagArr =  ( !empty( $res3[1])) ? $res3[1] : array();

               }
               $item = array(
                  "original_id" => "jk" . $id ,
                  "title"       => $title,
                  "movie_url"   => $url
               );
               $this->saveItemAndTag( $item, $tagArr );
           }
       }
    }
}
