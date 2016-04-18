<?php
App::uses ( 'AppShell', 'Console/Command' );

class UpdateItemOrderShell extends AppShell {

    // モデルを読み込む
    public $uses = array(
            'Item',
    );
    public function main() {
        $this->out ( "start_batch" );
        $this->out ( date ( "Y-m-d H:i:s" ) );
        $this->updateItemOrder();
        $this->out ( date ( "Y-m-d H:i:s" ) );
        $this->out ( "last_batch" );
    }

    public function updateItemOrder() {

        $itemData = $this->Item->getItemOrderLine();
        foreach ($itemData as $order_no => $item ) {
        	$order_no2 = $order_no + 1;
            $item['item']['item_order'] = $order_no2;
            echo $order_no2 ." ". $item['Item']['title'] ."\n";
            $this->Item->save( $item );
        }
    }

}
