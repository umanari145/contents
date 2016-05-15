<?php
App::uses ( 'AppShell', 'Console/Command' );

class SaveJksexvideoShell extends AppShell {

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
       
       $html = file_get_contents( THIRD_URL ); 
       
       //リストページのデータを取得
       if( !empty( $html) ) {
           preg_match_all('/.*?<span.*?class="deco"><a.*?href="(.*?)" title="(.*?)">.*?<\/span>.*?/s', $html , $res );
           
           $linkArr  = ( !empty( $res[1])) ? $res[1] : array();
           
           foreach( $linkArr as $no => $link ){
               
               $title = ( !empty( $res[2][$no])) ? $res[2][$no] : "";
               $html2 = file_get_contents( $link );
               
               if( !empty( $html2 ) ) {
                   preg_match_all('/.*?<iframe.*?src="(.*?)".*?>.*?/s', $html2 , $res2 );
                   $url = ( !empty( $res2[1][0])) ? $res2[1][0]:"";
                   preg_match_all('/.*?rel="category tag">(.*?)<\/a>.*?/s', $html2 , $res3 );
                   $tagArr =  ( !empty( $res3[1])) ? $res3[1] : array();

               }
               $item = array(
                  "title" => $title,
                  "url"   => $url
               );
               $totalItemArr[] = $item;
           }
           var_dump( $totalItemArr );
           exit;
       }
    }

    private function extractContentsData( $totalItemArr ){
   
    }

}
