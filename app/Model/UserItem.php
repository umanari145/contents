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
class UserItem extends Model {

	/**
	 * すでにお気にいり情報をもっているかどうかの判定を行う
	 *
	 * @param unknown $data
	 */
	public function hasFavorite( $data = array() ){
		if( !empty($data) ) {
			$params = array(
    			'conditions' => array(
    				'user_id' => $data['user_id'],
    				'item_id' => $data['item_id']
    			)
    		);

			return  ( $this->find('count' , $params) > 0 ) ? true : false;
		}
	}

	/**
	 * お気に入り商品の一覧を取得
	 *
	 * @param string $useId
	 */
	public function getFavoriteItem( $useId = null ){

		if( !empty($userId ) ) {
			$params = array(
					'conditions' => array(
							'user_id' => $data['user_id'],
							'item_id' => $data['item_id']
					)
			);

			return  ( $this->find('count' , $params) > 0 ) ? true : false;
		}
	}
}
