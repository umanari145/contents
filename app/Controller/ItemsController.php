<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');
App::import('Vendor', 'IXR');

use Underbar\ArrayImpl as _;

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ItemsController extends AppController {

/**
 * @var array
 */
    public $uses = array('Item','Tag','ItemTag','UserItem');

    public $layout ="contents";

    public $components = array (
            'Session',
            'Paginator'
    );


    public $paginate = array (
            'Item' => array (
                    'limit' => 10,
                    'order' => array (
                            'Item.id' => 'desc'
                    )
            ),
            'UserItem' => array (
                    'limit' => 8
            )
    );





    public function index() {

        $searchName="";
        //原因不明だがタグか女優名で選択すると
        //Itemにアクセスできなくなる。以下のメソッドがあるとアクセスできる
        $this->Item->hoge();
        $searchName = $this->getQuery( $this->request );
        $params=array();

        $items  = $this->paginate($params);
        $items2 = $this->setGirlAndTag( $items );

        $sqlLog = $this->Item->getDataSource()->getLog(false, false);
        $this->debugSQLlog( $sqlLog );

        $this->set('search_name' , $searchName);
        $this->set('items',$this->Item->getItemList($items2));
    }

    /**
     * お気に入り一覧ページ
     */
    public function favorite(){

    	$items = array();
    	if( $this->isLogin() === true ){
    		$params = array();
    		$user = $this->getUser();
    		$items = $this->getFavoriteItemWithPager( $user['id']);

    	} else {
    		return $this->redirect(
    				array('controller' => 'items', 'action' => 'index' )
    		);
    	}
    	$this->set('items' , $items);
    }

    /**
     * お気にいり商品をbindして取得
     *
     * @param unknown $userId ユーザーID
     * @return 商品データ
     */
    private function getFavoriteItemWithPager( $userId ){

    	$this->UserItem->bindModel ( array (
    			'belongsTo' => array (
    					'Item' => array (
    							'className' => 'Item',
    							'foreignKey' => 'item_id',
    							'conditions' => array('Item.delete_flg' => false)
    					)
    			)
    	));

    	$items0 = $this->Paginator->paginate( 'UserItem' ,
    			array('UserItem.user_id' => $userId )
    	);
    	$items = $this->setGirlAndTag($items0);
    	return $items;
    }

    /**
     * 女優データとタグデータをセットする
     *
     * @param unknown $items 商品id
     */
    private  function  setGirlAndTag( $items ) {
        $itemIdArr = array();
        //itemIdを取り出すためだけにループをまわす
        foreach ( $items as $item ) {
            $itemId      = $item['Item']['id'];
            $itemIdArr[] = $itemId;
        }

        $tagData2 = $this->ItemTag->makeTagDataWhereInItemId( $itemIdArr );
        //$girlData2 = $this->ItemGirl->makeGirlDataWhereInItemId( $itemIdArr );

        $tagHashGroupByItemId  = _::groupBy( $tagData2, function($ele) { return $ele["item_id"]; } );
        $girlHashGroupByItemId = array();

        //女優、タグデータと結合する
        foreach ( $items as &$item) {
            list( $tagData3, $girlData3) = $this->merggeTgAndGirls( $item['Item']['id'] , $tagHashGroupByItemId , $girlHashGroupByItemId );
            $item['Tag'] = $tagData3;
            //$item['Girl'] = $girlData3;

        }
        return $items;
    }

    /**
     * itemIdでグルーピングされた女優とタグデータを出力する
     *
     * @param unknown $itemId 商品id
     * @param unknown $tagHashGroupByItemId 商品idでグルーピングされたタグデータ
     * @param unknown $tagHashGroupByItemId 商品idでグルーピングされた女優データ
     */
    private function merggeTgAndGirls( $itemId , $tagHashGroupByItemId = array(), $girlHashGroupByItemId = array()){

        $tagData3  = array();
        //タグの処理
        if( isset($tagHashGroupByItemId[$itemId]) === true ){
            $tagEachDataArr = $tagHashGroupByItemId[$itemId];
            foreach ( $tagEachDataArr as $tag) {
                $tagData3[] = array(
                    'id'  => $tag['tag_id'],
                    'tag' => $tag['tag']
                );
            }
        }

        $girlData3 = array();
        //女優データの処理
    //if( isset($girlHashGroupByItemId[$itemId]) === true ){
    //    $girlEachDataArr = $girlHashGroupByItemId[$itemId];
    //    foreach ( $girlEachDataArr as $girl) {
    //        $girlData3[] = array(
    //                'id'  => $girl['girl_id'],
    //                'name' => $girl['name']
    //        );
    //    }
    //}
        return array( $tagData3, $girlData3);
    }

    /**
     *
     * @param unknown $param パラメーター
     * @return 検索文字
     */
    private function getQuery( $param ){

        $searchName="";
        $itemIdArr =array();
        //クエリがあるかないか()
        if( !empty($param->params['named']['girl']) ||
            !empty($param->params['named']['tag'])  ||
            !empty($param->params['named']['keyword'])) {
            $searchName = $this->getCategoryQuery( $param->params['named'] );
        }
        return $searchName;
    }

    /**
     * 検索文字
     *
     * @param unknown $queryStr 検索クエリ
     * @return 検索文字
     */
    private function getCategoryQuery($queryStr) {

        $searchName;
        //キーワードから商品IDを取得
        if (! empty ( $queryStr ['keyword'] )) {
            $searchName = $queryStr['keyword'];
            $this->Item->setItemFromQueryStr( $queryStr['keyword'] );
        }

        //女優から商品IDを取得
        if (! empty ( $queryStr ['girl'] )) {
            $searchName =  $this->getItemFromGirlList( $queryStr );
        }


        //タグから商品IDの取得
        if (! empty ( $queryStr ['tag'] )) {
            $searchName = $this->getItemFromTagList( $queryStr );
        }
        return $searchName;
    }

    /**
     * 関連テーブルから対象の女優の商品idを出力する
     *
     * @param unknown $queryStr 女優id
     * @return 対象商品id
     */
    private function getItemFromGirlList( $queryStr = array()) {

        $girlId = $queryStr ['girl'];

        $this->Girl->unbindModel(array('hasAndBelongsToMany'=>'Item'), true);
        $girlData = $this->Girl->find('first', array('conditions'=>array('Girl.id'=> $girlId)));

        $this->Item->setGirlSQL( $girlId );

        return $girlData['Girl']['name'];

    }

    /**
     * 関連テーブルから対象のタグの商品idを出力する
     *
     * @param unknown $queryStr タグid
     * @return タグ名
     */
    private function getItemFromTagList( $queryStr = array()) {
        $tagId = $queryStr ['tag'];

        $this->Tag->unbindModel(array('hasAndBelongsToMany'=>'Item'), true);
        $tagData = $this->Tag->find('first', array('conditions'=>array('Tag.id'=> $tagId)));

        $this->Item->setTagSQL( $tagId );

        return $tagData['Tag']['tag'];
    }

    public function view($id = null) {
        $this->Item->id = $id;

        if (! $this->Item->exists ()) {
            throw new NotFoundException ( '存在しない商品です。' );
        }

        $itemImage = array();

        $size = $this->loadMovieSize();

        $itemDetail = $this->Item->getItemDetail($id , $size);

        $isFavorite = false;
        if($this->isLogin() === true ) {
            $user = $this->getUser();
            $data =  array(
                    'user_id' => $user['id'],
                    'item_id' => $id
            );

            $isFavorite = $this->UserItem->hasFavorite( $data );
        }

        $tagArr = $this->ItemTag->makeTagDataWhereInItemId( array($id));
        $itemDetail['Tag'] = $tagArr;
        $this->set ( 'isFavorite', $isFavorite );
        $this->set ( 'itemDetail', $itemDetail );
    }


    /**
     * 動画サイズの読み込み
     *
     * @return 高さと横幅
     */
    private function loadMovieSize() {

        $size = array(
                        'width'  => 640,
                        'height' => 480
                    );

        return $size;
    }

    public function ping(){

       //$client = new Hoge();
       $client = new IXR_Client('http://rpc.pingomatic.com/');
       $title = SITE_TITLE;//任意のサイト名
       $siteUrl = SITE_URL ;//任意のサイトURL
       $return = $client->query('weblogUpdates.ping',$title,$siteUrl);//Ping送信
       echo "success";
       $this->autoRender = false;
    }

    public function tag( $id = null ){
        $this->Item->id = $id;

        if (! $this->Item->exists ()) {
            throw new NotFoundException ( '存在しない商品です。' );
        }
        $this->set ( 'itemDetail',$this->Item->getItemDetail( $id) );

    }

    /**
     * 動画サイズの更新
     *
     */
    public function updateMovieSize() {
        $this->autoRender = false;
        $data = $this->request->data;
        if( !empty( $data['height'] ) && preg_match( '/^\d{3}$/', $data['height'] ) === 1 &&
            !empty( $data['width'] ) && preg_match( '/^\d{3}$/', $data['width'] )  === 1
        ) {

            $this->Session->write( 'Movie.width' , $data['width']);
            $this->Session->write( 'Movie.height' , $data['height']);


            echo "success";
        } else {
            echo "fail";
        }
    }

}
