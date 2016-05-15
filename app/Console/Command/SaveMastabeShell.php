<?php
App::uses ( 'AppShell', 'Console/Command' );

class SaveMastabeShell extends AppShell {

    // モデルを読み込む
    public $uses = array(
            'Item',
            'Tag',
            'Girl',
            'ItemGirl',
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
       
       $html = file_get_contents( SECOND_URL ); 
       
       //リストページのデータを取得
       if( !empty( $html) ) {
           preg_match_all('/.*?<span class="duration">(.*?)<\/span>.*?<div class="info">.*?<h2><a href="(.*?)">(.*?)<\/a><\/h2>.*?/s', $html , $res );
           
             
           $durationArr    = ( !empty( $res[1])) ? $res[1]:array() ;
           
           $totalItemArr = array();
           foreach( $durationArr as $no => $duration ){
               
               $link  = ( !empty( $res[2][$no])) ? $res[2][$no] : "";
               $title = ( !empty( $res[3][$no])) ? $res[3][$no] : "";

               $item = array(
                   'time'  => $duration,
                   'link'  => $link,
                   'title' => $title
               );

               $totalItemArr[] = $item;
           }
           $this->extractContentsData( $totalItemArr );
       }
    }

    private function extractContentsData( $totalItemArr ){
        
        foreach( $totalItemArr as &$item) {
             
            $link = $item['link'];
            $html = file_get_contents( "http://masutabe.info" . $link );
            
            if( !empty( $html ) ) {
                preg_match_all( '/.*?<iframe src="(.*?)".*?/s', $html , $res2);
                
                $movieUrl   = ( !empty( $res2[1][0])) ? $res2[1][0]:"" ;
                preg_match_all( '/<ul class="tagList">.*?<li><a href=".*?">(.*?)<\/a><\/li>.*?<\/ul>/s', $html , $res3);
                
                $tagStr ="";
                if( !empty( $res3[0][0])) {
                    $tagStr = strip_tags( $res3[0][0] ); 
                } 
                $item['movie_url'] = $movieUrl;
                $item['tagStr']    = $tagStr;
            }
        }

        var_dump( $totalItemArr);
        exit;
    
    }

}
