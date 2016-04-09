<?php
App::uses ( 'AppShell', 'Console/Command' );

class SaveItemShell extends AppShell {

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

        $itemCount = 0;
        $includeTagArr = $this->Tag->getIncludeTag();

        for( $i=1; $i < 1000 ;$i++ ) {
            $start = 1 + ( $i - 1 ) * 100 ;

            $url = "https://api.dmm.com/affiliate/v3/ItemList?"
            ."api_id=". API_ID ."&affiliate_id=" . AFFILIATE_ID_USE_API
            ."&site=DMM.R18&service=digital&article=genre&article_id=" . GENRE_ID . "&floor=videoa"
            ."&hits=100&offset=" . $start . "&sort=rank&output=json";

            echo "api get start " . $start ."\n";

            $res = file_get_contents( $url );
            $arr =  json_decode($res,true);

            if( !empty($arr['result']['items'])) {
                $itemDataList = $arr['result']['items'];

                foreach( $itemDataList as $item ){
                    $actess_id_arr = array();
                    $actress_name_text = null;
                    $genre_id_arr = array();
                    $genre_name_text = null;


                    if( !empty($item['iteminfo']['actress'])) {
                        list( $actess_id_arr, $actress_name_text ) = $this->getAttributeData( $item['iteminfo']['actress']);
                        $item['actress'] = $actress_name_text;
                    }

                    if( !empty($item['iteminfo']['genre'])) {
                        list( $genre_id_arr, $genre_name_text ) = $this->getAttributeData( $item['iteminfo']['genre'] ,'tag' ,$includeTagArr );
                        $item['genre'] = $genre_name_text;
                    }

                    $itemCount++;
                    $item['id'] = $item['content_id'];

                    if( $this->Item->existItem( $item['id']) === true) {
                    	continue;
                    }

                    $item['item_order'] = $itemCount;
                    $data['Item'] = $item;
                    $this->Item->create();
                    $this->Item->save( $data );

                    if( !empty( $item["sampleImageURL"]["sample_s"]["image"])) {

                        foreach ( $item["sampleImageURL"]["sample_s"]["image"] as $imageUrl ) {

                            $imageEntity = array(
                                    'item_id'   => $item['content_id'],
                                    'image_url' => $imageUrl
                            );
                            $this->ItemImage->create();
                            $this->ItemImage->save( $imageEntity);
                        }

                    }


                    foreach( $actess_id_arr as $actess_id ) {
                        $data2 = array();
                        $data2['ItemGirl'] = array(
                           'item_id' => $item['id'],
                           'girl_id' => $actess_id
                        );
                        $this->ItemGirl->create();
                        $this->ItemGirl->save( $data2 );
                    }


                    foreach( $genre_id_arr as $genre_id ) {
                        $data3 = array();
                        $data3['ItemTag'] = array(
                           'item_id' => $item['id'],
                           'tag_id'  => $genre_id
                        );
                        $this->ItemTag->create();
                        $this->ItemTag->save( $data3 );
                    }

                    if( $itemCount > 4000 ) {
                        break 2;
                    }

                    echo $data['Item']['title'] . "  ";
                    echo $itemCount ."\n";
                }

            } else {
                echo "there is final ";
                break;
            }
        }
    }

    public function getAttributeData( $attrArr = array() , $mode ='', $includeTagArr =array() ) {
        $attr_id_arr = array();
        $attr_name_text = null;
        $attr_name_arr = array();
        foreach( $attrArr as $attr ) {

            if( !empty( $attr['id'] ) &&  is_int($attr['id']) === true ) {
                if( $mode === 'tag' ) {
                    if( isset( $includeTagArr[$attr['id']] ) === true ){
                        $attr_id_arr[]   = $attr['id'];
                        $attr_name_arr[] = $attr['name'];
                    }
                } else {
                    $attr_id_arr[]   = $attr['id'];
                    $attr_name_arr[] = $attr['name'];
                }
            }
        }

        if( $attr_name_arr !== array() ){
            $attr_name_text = implode( " " , $attr_name_arr );
        }

        return array( $attr_id_arr , $attr_name_text );
    }


}
