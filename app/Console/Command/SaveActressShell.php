<?php
App::uses ( 'AppShell', 'Console/Command' );

class saveActressShell extends AppShell {

	// モデルを読み込む
	public $uses = array(
			'Item',
			'Tag',
			'Girl'
	);
	public function main() {
		$this->out ( "start_batch" );
		$this->out ( date ( "Y-m-d H:i:s" ) );
		$this->getActressData ();
		$this->out ( date ( "Y-m-d H:i:s" ) );
		$this->out ( "last_batch" );
	}
	public function getActressData() {

        $itemCount = 0;
        $girlIdHash = $this->Girl->getGirlIdHash();

        for( $i=1; $i < 1000 ;$i++ ) {
            $start = 1 + ( $i - 1 ) * 100 ;
            $url = "https://api.dmm.com/affiliate/v3/ActressSearch?"
            ."api_id=". API_ID ."&affiliate_id=" . AFFILIATE_ID_USE_API
            . "&hits=100&offset=" . $start  . "&output=json";

            echo "api get start " . $start ."\n";
z
            $res = file_get_contents( $url );
            $arr =  json_decode($res,true);
            $girl100List = array();
            if( !empty($arr['result']['actress'])) {
                $girlDataList = $arr['result']['actress'];

                foreach( $girlDataList as $girl ){

                    if( isset( $girlIdHash[$girl['id']]) === true ){
                        continue;
                    }

                    if( !empty($girl['imageURL']['small'])) {
                        $girl['imageURL_s'] = $girl['imageURL']['small'];
                    }

                    if( !empty($girl['imageURL']['large'])) {
                        $girl['imageURL_l'] = $girl['imageURL']['large'];
                    }
                    $data['Girl'] = $girl;
                    $girl100List[] = $data;
                    $itemCount++;
                    echo  $data['Girl']['name'] . "  ";
                    echo $itemCount ."\n";
                }

                if( $girl100List !== array()) {
                    $this->Girl->create();
                    $this->Girl->saveAll( $girl100List);
                }
            } else {
                echo "there is final ";
                break;
            }
        }
    }




}
