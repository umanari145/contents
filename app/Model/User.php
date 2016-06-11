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
class User extends Model {

	public $validate = array(
			'username' => array(
					'alphaNumeric' => array(
							'rule'     => '/^\w{4,}$/',
							'required' => true,
							'message'  => '半角英数字4文字以上で入力してください'
					),
					'unique' => array(
							'rule' => array('isUnique'),
							'message' => 'すでに登録されているユーザー名です。'
					)
			),
			'password' => array(
					'alphaNumeric' => array(
							'rule'     => '/^\w{4,}$/',
							'required' => true,
							'message'  => '半角英数字4文字以上で入力してください'
					)
			)
	);
    /**
     * 暗号化して保存
     * @param unknown $option
     */
	public function beforeSave( $option = array() ){
		$this->data[$this->alias]['password'] = sha1( $this->data[$this->alias]['password'] );
		return true;
	}

	/**
	 * ログインチェックを行う
	 * @param フォームのパラメーター $params
	 * @return 正 Userユーザーデータ / 誤 false
	 */
	public function loginCheck( $params ) {

		if( empty( $params['User']['username'] ) && empty( $params['User']['password'] ) ){
			return false;
		}

		$params = array(
			'conditions' => array(
					'User.username'   => $params['User']['username'],
					'User.password'   => sha1( $params['User']['password']),
					'User.delete_flg' => false
				)
		);

		$res = $this->find('first' , $params);

		if( !empty( $res )) {
			return $res['User'];
		} else {
			return false;
		}
	}
}
