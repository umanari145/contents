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
	public $uses = ['Item','Tag','Girl','ItemGirl','ItemTag'];

	public $layout ="contents";


	public function beforeFilter() {
        $tagList = $this->ItemTag->calcItemCountGroupByTag($this->Tag->getTagNameList());
		$this->set( 'siteUrl' , SITE_URL);
		$this->set( 'tagList' , $tagList);
		$this->set( 'girlList' , $this->Girl->getGirlList() );
	}

	public function index() {
        
        //原因不明だがタグか女優名で選択すると
        //Itemにアクセスできなくなる。以下のメソッドがあるとアクセスできる
        $this->Item->hoge();
        $itemIdArr = $this->getQuery( $this->request);
		$params=[];
		$searchName="";
		//検索条件が存在すれば検索を行う
		if( $itemIdArr !== []){
			$params = [
				'Item.id'=> $itemIdArr['idList']
			];
			$searchName = $itemIdArr['search_name'];
		}
		$items = $this->paginate($params);
        $this->set('search_name' , $searchName);
        $this->set('items',$this->Item->getItemList($items));
	}

	private function getQuery( $param ){

		$itemIdArr =[];
		//クエリがあるかないか()
		if( !empty($param->params['named']['girl']) ||
			!empty($param->params['named']['tag'])  ||
			!empty($param->params['named']['keyword'])) {
	    	$itemIdArr = $this->getCategoryQuery( $param->params['named'] );
	    }

	    return $itemIdArr;
	}

	private function getCategoryQuery($queryStr) {

		$itemIdArr =[
				'idList'=> "",
				'count'=>0,
				'search_name'=>""
		];

		//キーワードから商品IDを取得
		if (! empty ( $queryStr ['keyword'] )) {
			$itemIdArr = $this->Item->getItemFromQueryStr( $queryStr['keyword'] );
		}

		//女優から商品IDを取得
		if (! empty ( $queryStr ['girl'] )) {
			$itemIdArr = $this->getItemFromGirlList( $queryStr );
		}


		//タグから商品IDの取得
		if (! empty ( $queryStr ['tag'] )) {
			$itemIdArr = $this->getItemFromTagList( $queryStr );
		}
		return $itemIdArr;
	}

	/**
	 * 関連テーブルから対象の女優の商品idを出力する
	 *
	 * @param unknown $queryStr 女優id
	 * @return 対象商品id
	 */
	private function getItemFromGirlList( $queryStr = []) {

		$girlId = $queryStr ['girl'];

		$itemIdTmp = $this->ItemGirl->find ( 'list', [
				'fields' => 'item_id',
				'conditions' => [
						'ItemGirl.girl_id' => $girlId
				]
		] );

		$girlNameTmp= $this->Girl->find('first',[
				'fields' => 'name',
				'conditions' => [
						'Girl.id' => $girlId
				]
		]);

		$itemIdArr['search_name'] = $girlNameTmp['Girl']['name'];

		if( count( $itemIdArr) > 0) {
			$itemIdArr['count'] = count($itemIdArr);
			$itemIdArr['idList'] = array_values( $itemIdTmp );
		}

		return $itemIdArr;
	}

	/**
	 * 関連テーブルから対象のタグの商品idを出力する
	 *
	 * @param unknown $queryStr タグid
	 * @return 対象商品id
	 */
    private function getItemFromTagList( $queryStr = []) {
    	$tagId = $queryStr ['tag'];

    	$itemIdTmp = $this->ItemTag->find ( 'list', [
    			'fields' => 'item_id',
    			'conditions' => [
    					'ItemTag.tag_id' => $tagId
    			]
    	] );

    	$tagNameTmp= $this->Tag->find('first',[
    			'fields' => 'tag',
    			'conditions' => [
    					'Tag.id' => $tagId
    			]
    	]);

    	$itemIdArr['search_name'] = $tagNameTmp['Tag']['tag'];

    	if( count($itemIdTmp) > 0) {
    		$itemIdArr['count'] = count($itemIdTmp);
    		$itemIdArr['idList'] = array_values( $itemIdTmp );
    	}
		return $itemIdArr;
    }

	public function view($id = null) {
		$this->Item->id = $id;

		if (! $this->Item->exists ()) {
			throw new NotFoundException ( '存在しない商品です。' );
		}
		$this->set ( 'itemDetail',$this->Item->getItemDetail( $id) );
	}


	public function tag( $id = null ){
		$this->Item->id = $id;

		if (! $this->Item->exists ()) {
			throw new NotFoundException ( '存在しない商品です。' );
		}
		$this->set ( 'itemDetail',$this->Item->getItemDetail( $id) );

	}
}
