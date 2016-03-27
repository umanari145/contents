<?php
App::uses ( 'AppShell', 'Console/Command' );

class GetTagShell extends AppShell {

	// モデルを読み込む
	public $uses = [
			'Item',
			'Tag'
	];
	public function main() {
		$this->out ( "start_batch" );
		$this->out ( date ( "Y-m-d H:i:s" ) );
		$this->getTagData ();
		$this->out ( date ( "Y-m-d H:i:s" ) );
		$this->out ( "last_batch" );
	}

	public function getTagData() {
        //アダルト動画はfloor_id=43
        $itemCount = 0;
        for( $i=1; $i < 10 ;$i++ ) {
            $start = 1 + ( $i - 1 ) * 100 ;
            $url = "https://api.dmm.com/affiliate/v3/GenreSearch?"
                   . "api_id=" . API_ID . "&affiliate_id=" .AFFILIATE_ID_USE_API 
                   . "&floor_id=43&hits=100&offset=" . $start . "&output=json";

            $res = file_get_contents( $url );
            $arr =  json_decode($res,true);
         
            if( !empty($arr['result']['genre'] )) {
                foreach( $arr['result']['genre'] as $val ){
                     echo $val['genre_id'] . " " . $val['name'] . "\n";
                }
            }else{
                echo "there is final ";
                break;
            }
        }
exit;
}
