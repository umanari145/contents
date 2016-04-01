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
class Tag extends Model {

	public $hasAndBelongsToMany = array(
			'Item' =>
			array(
					'className'              => 'item',
					'joinTable'              => 'item_tags',
					'foreignKey'             => 'tag_id',
					'associationForeignKey'  => 'item_id',
					'unique'                 => true
			)
		);



	/**
	 * タグリストの出力
	 *
	 * @return id=>タグ名の配列
	 */
	public function getTagNameList(){
		//スピードが遅くなるのではずす
		$this->unbindModel(array('hasAndBelongsToMany'=>'Item'), true);
		return $this->find('list',array('fields'=>array('Tag.id','Tag.tag')));
	}

	public function getTagList(){
		$tags = $this->find ( 'all', null );

		$tagList =array();

		foreach ( $tags as $tag ){
			$tagHash =array(
				'tagName' => $tag['Tag']['tag'],
				'id'      => $tag['Tag']['id'],
				'count' => count( $tag['Item'])
			);

			$tagList[] = $tagHash;
		}

		foreach ((array) $tagList as $key => $value) {
			$sort[$key] = $value['count'];
		}

		array_multisort($sort, SORT_DESC, $tagList);

		$tagList2=array();
		$loopCount = count( $tagList);
		for($i=0; $i<$loopCount; $i++ ) {
			if( $loopCount == 10 ) {
				break;
			}

			$tagList2[] = $tagList[$i];
		}
		return $tagList2;
	}

    public function getIncludeTag(){
        $this->unbindModel(array('hasAndBelongsToMany'=>'Item'), true);
        $tagList = $this->find("list",
            array(
                'conditions' => array(
                    'Tag.show_tag'=> 1
                )
            )
        );
        return $tagList;
    }

    /**
     * whereinで指定されたitem_idからTagデータを取り出す
     *
     *
     */
    public function makeTagDataWhereInItemId ( $itemIdArr = array() ) {
    	$sql =" SELECT  "
			."     Item.id, "
			."     ItemTag.tag_id, "
			."     Tag.tag "
			." FROM "
			."     item_tags ItemTag JOIN items Item "
			." ON  ItemTag.item_id = Item.id "
			."     LEFT JOIN tags Tag "
			."     ON  ItemTag.tag_id = Tag.id "
			." WHERE "
			."     ItemTag.item_id IN( :item_id_str ); ";

    }
}
