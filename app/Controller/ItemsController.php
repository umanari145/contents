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
		$this->set( 'tagList' , $this->Tag->getTagList() );
		$this->set( 'girlList' , $this->Girl->getGirlList() );
	}

	public function index() {

		$itemIdArr=[];
		if( !empty( $this->request->params['named']) ){
			list( $itemIdArr, $urlOption) = $this->getQuery($this->request->params['named']);
		}

		$params=[];
		if( !empty($itemIdArr)){
			$params = [
				'Item.id'=> $itemIdArr
			];
		}

		$items = $this->paginate($params);
		$this->set('items',$this->Item->getItemList($items));
	}

	private function getQuery($queryStr) {

		$itemIdArr;
		$urlOption;
		//女優から商品IDを取得
		if (! empty ( $queryStr ['girl'] )) {
			$girlId = $queryStr ['girl'];
			$itemIdTmp = $this->ItemGirl->find ( 'list', [
					'fields' => 'item_id',
					'conditions' => [
							'ItemGirl.girl_id' => $girlId
					]
			] );
			if( !empty($itemIdTmp)){
				$itemIdArr = array_values( $itemIdTmp );
			}
			$urlOption =['url' => 'girl:' . urlencode($girlId)];
		}

		//タグから商品IDの取得
		if (! empty ( $queryStr ['tag'] )) {
			$tagId = $queryStr ['tag'];
			$itemIdTmp = $this->ItemTag->find ( 'list', [
					'fields' => 'item_id',
					'conditions' => [
							'ItemTag.tag_id' => $tagId
					]
			] );
			if( !empty($itemIdTmp)){
				$itemIdArr = array_values( $itemIdTmp );
			}
			$urlOption =['url' => 'tag:' . urlencode($tagId)];
		}

		return [$itemIdArr, $urlOption];
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
