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

	public $hasAndBelongsToMany = array(
			'Tag' =>
				array(
					'className'              => 'tag',
					'joinTable'              => 'item_tags',
					'foreignKey'             => 'item_id',
					'associationForeignKey'  => 'tag_id',
					'unique'                 => true
				),
			'Girl' =>
			array(
					'className'              => 'girl',
					'joinTable'              => 'item_girls',
					'foreignKey'             => 'item_id',
					'associationForeignKey'  => 'girl_id',
					'unique'                 => true
			)

	);

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
            $this->addMoveUrl( $contents ,'index');
            $smallPictrureUrl =  sprintf('http://pics.dmm.co.jp/digital/video/%s/%sps.jpg', $contents['Item']['id'],$contents['Item']['id'] );
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
        $this->addMoveUrl( $contentsDetail , 'detail');
		return $contentsDetail;
	}

    /**
    *  サンプル動画の追加
    *  @param $item 動画
    *
    */
    private function addMoveUrl( &$item = null , $type ="index" ){

        $size['width'] = 0;
        $size['height'] = 0;
        switch( $type ){
            case 'index':
            $size['width'] = S_MOVE_WIDTH;
            $size['height'] = S_MOVE_HEIGHT;
            break;
            case 'detail':
            $size['width'] = MOVE_WIDTH;
            $size['height'] = MOVE_HEIGHT;
            break;
        }

        $item['Item']['moveUrl'] = sprintf('<iframe width="'. $size['width']. '" height="' . $size['height'] . '" src="http://www.dmm.co.jp/litevideo/-/part/=/affi_id=%s/cid=%s/size='. $size['width']. '_' . $size['height'] . '/" scrolling="no" frameborder="0" allowfullscreen></iframe>' , AFFILIATE_ID , $item['Item']['id'] );
   }

	/**
	 * 対象キーワードで該当する商品を探す
	 *
	 * @param string $keyword キーワード
	 * @return 商品 IdArr
	 */
	public function getItemFromQueryStr( $keyword ="" ){

		$idArr =array(
				'idList'=>array(),
				'count' => 0,
				'search_name'=>""
		);
		if( isset( $keyword ) === true ) {
			$params =array(
				'conditions' =>array(
						'OR'=>array(
							'Item.title LIKE' => '%'. $keyword .'%',
							'Item.actress LIKE' => '%'. $keyword .'%',
							'Item.genre LIKE' => '%'. $keyword .'%',
							'Item.comment LIKE' => '%'. $keyword .'%'
						)
				)
			);

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
