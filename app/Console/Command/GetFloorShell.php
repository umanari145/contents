<?php
App::uses ( 'AppShell', 'Console/Command' );

class GetFloorShell extends AppShell {

	// モデルを読み込む
	public $uses = [
			'Tag',
	];
	public function main() {
		$this->out ( "start_batch" );
		$this->out ( date ( "Y-m-d H:i:s" ) );
		$this->getFloorData ();
		$this->out ( date ( "Y-m-d H:i:s" ) );
		$this->out ( "last_batch" );
	}
	public function getFloorData() {
        
        $url = "https://api.dmm.com/affiliate/v3/FloorList?api_id=" . API_ID . "&affiliate_id=" . AFFILIATE_ID_USE_API . "&output=json";
        
        $res = file_get_contents( $url );
        $arr =  json_decode($res,true);

        foreach( $arr['result']['site'] as $val){
            foreach( $val['service'] as $val2 ){
                foreach( $val2['floor'] as $val3){
                    echo  $val3['id'] ."  " . $val3['name'] . "  " . $val3['code']."\n";
                }
            }
        }
    }

}
