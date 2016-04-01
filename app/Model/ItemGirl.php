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
class ItemGirl extends Model {

	/**
	 * 商品idの配列から含まれる女優のデータを取得する
	 *
	 * @param unknown $itemIdArr
	 * @return 商品id,女優id,女優名を含んだ配列
	 */
	public function makeGirlDataWhereInItemId( $itemIdArr = array()) {
		$this->bindModel(array('belongsTo'=>array('Girl')));
		$girlData = array();

		$girlData = $this->find('all',
			array(
				'fields' => array(
					'ItemGirl.item_id',
					'ItemGirl.girl_id' ,
					'Girl.name'
				),
				'conditions' => array(
					'ItemGirl.item_id ' => $itemIdArr
				)
			)
		);

		$girlData2 = array();
		foreach ( $girlData as $girl ) {
			$tmp = array(
				'item_id' => $girl['ItemGirl']['item_id'] ,
				'girl_id'  => $girl['ItemGirl']['girl_id'] ,
				'name'     => $girl['Girl']['name']
			);
			$girlData2[] = $tmp;
		}

		return $girlData2;
	}

}
