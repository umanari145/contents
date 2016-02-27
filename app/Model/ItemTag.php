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
class ItemTag extends Model {

//joinがなぜか不完全なので一時休止
// 	public $hasMany =[
// 			'Tag'=>[
// 			'className' => 'Tag',
// 			'foreignKey' => 'id',
// 			]
// 	];

	/**
	 * タグごとの商品数を出力
	 *
	 * @param $tagNameList タグ名
	 */
	public function calcItemCountGroupByTag( $tagNameList ){

 		$params=[
 				'fields'=>['COUNT(id) as num' ,'ItemTag.tag_id'],
 				'group'=>['ItemTag.tag_id'],
 				'order'=>['num DESC']
 		];

		$tagList = $this->find('all', $params);
		$tagList2 = [];
		foreach ( $tagList as $tag ) {
			$tagId = $tag['ItemTag']['tag_id'];
			$tagList2[] =[
					'id' => $tagId,
					'tagName'=> $tagNameList[$tagId],
					'count' => $tag[0]['num']
			];
		}
		return $tagList2;
	}

}
