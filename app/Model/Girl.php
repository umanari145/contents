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
class Girl extends Model {

	public $hasAndBelongsToMany = array(
			'Item' =>
			array(
					'className'              => 'item',
					'joinTable'              => 'item_girls',
					'foreignKey'             => 'girl_id',
					'associationForeignKey'  => 'item_id',
					'unique'                 => true
			)
	);

	/**
	 * 女優リスト
	 *
	 * @return 女優リストの取得
	 */
	public function getGirlList(){
        //高速化のためにはずす
		$this->unbindModel(array('hasAndBelongsToMany'=>'Item'), true);

// 	    $result = Cache::read('girl_list', 'sql_cache' );
//         if (!$result) {
            $result = $this->find('all' ,null);
//             Cache::write('girl_list', $result, 'sql_cache');
//         }else{
         	$girls = $result;
//         }

		$girlList =array();
		foreach ( $girls as $girl ){
			$girlHash =array(
					'girlName' => $girl['Girl']['name'],
					'id'      => $girl['Girl']['id']
			);

			$girlList[] = $girlHash;
		}
		return $girlList;
	}

// 	/**
// 	 * データが保存された場合はキャッシュを削除
// 	 *
// 	 * @param unknown $created
// 	 */
// 	public function afterSave($created) {
// 		Cache::delete( 'girl_list', 'sql_cache' );
// 	}

// 	/**
// 	 * データが削除された場合にはキャッシュを削除
// 	 */
// 	public function afterDelete() {
// 		Cache::delete( 'girl_list', 'sql_cache' );
// 	}

	/**
	 *
	 * girlId => 1 というハッシュデータを返す
	 *
	 * @return 女優IDリスト
	 */
	public function  getGirlIdHash(){
	    $this->unbindModel(array('hasAndBelongsToMany'=>'Item'), true);
	    $girlIdList = array();

	    $girlIdList = $this->find('list');

        return $girlIdList;
	}


}
