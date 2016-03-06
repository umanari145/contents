<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses ( 'Model', 'Model' );

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package app.Model
 */
class Item extends Model {
 
    public $name ="Item";

	public $hasAndBelongsToMany = [
			'Tag' =>
				[
					'className'              => 'tag',
					'joinTable'              => 'item_tags',
					'foreignKey'             => 'item_id',
					'associationForeignKey'  => 'tag_id',
					'unique'                 => true
				],
			'Girl' =>
			[
					'className'              => 'girl',
					'joinTable'              => 'item_girls',
					'foreignKey'             => 'item_id',
					'associationForeignKey'  => 'girl_id',
					'unique'                 => true
			]

	];

    /**
    *  意味不明のエラー対策のタメにあるメソッド
    */
    public function hoge(){
    }

	/**
	 * アイテム一覧の取得
	 *
	 * @return 商品一覧の取得
	 */
	public function getItemList( $contentsList ) {
		foreach ( $contentsList as &$contents ) {
			$smallPictrureUrl = str_replace ( "pl.jpg", "ps.jpg", $contents ['Item'] ['pictureUrl'] );
			$contents ['Item'] ['smallPictureUrl'] = $smallPictrureUrl;
		}
		return $contentsList;
	}

	/**
	 * 商品詳細のページ
	 *
	 * @param string $id id
	 * @throws NotFoundException 商品が存在しないときのエラー
	 * @return 商品詳細データ
	 */
	public function getItemDetail($id = null) {
		if (! $this->exists ()) {
			throw new NotFoundException ( '存在しない商品です。' );
		}

		$params = array(
				'conditions' => array (
						'id' => $id
				)
		);

		$contentsDetail = $this->find ( 'first', $params);
		return $contentsDetail;
	}


	/**
	 * 対象キーワードで該当する商品を探す
	 *
	 * @param string $keyword キーワード
	 * @return 商品 IdArr
	 */
	public function getItemFromQueryStr( $keyword ="" ){

		$idArr =[
				'idList'=>[],
				'count' => 0,
				'search_name'=>""
		];
		if( isset( $keyword ) === true ) {
			$params =[
				'conditions' =>[
						'OR'=>[
							'Item.productName LIKE' => '%'. $keyword .'%',
							'Item.actress LIKE' => '%'. $keyword .'%',
							'Item.genre LIKE' => '%'. $keyword .'%',
							'Item.summary LIKE' => '%'. $keyword .'%'
						]
				]
			];

			$idArr['search_name'] = $keyword;

			$idArrTmp = $this->find( 'list', $params );

			if ( count($idArrTmp) > 0 ) {
			    $idArr['count'] = count($idArrTmp);
				$idArr['idList'] = array_values( $idArrTmp );
			}
		}
		return $idArr;
	}
}
