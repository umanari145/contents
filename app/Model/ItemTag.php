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
//     public $hasMany =[
//             'Tag'=>[
//             'className' => 'Tag',
//             'foreignKey' => 'id',
//             ]
//     ];

    /**
     * タグごとの商品数を出力
     *
     * @param $tagNameList タグ名
     */
    public function calcItemCountGroupByTag( $tagNameList ){

         $params = array(
                 'fields' => array('COUNT(id) as num' ,'ItemTag.tag_id'),
                 'group'  => array('ItemTag.tag_id'),
                 'order'  => array('num DESC'),
                 'limit'  => 15
         );

        $tagList = $this->find('all', $params);

        $tagList2 = array();
        foreach ( $tagList as $tag ) {
            $tagId = $tag['ItemTag']['tag_id'];
            $tagList2[] =array(
                    'id' => $tagId,
                    'tagName'=> $tagNameList[$tagId],
                    'count' => $tag[0]['num']
            );
        }
        return $tagList2;
    }

    /**
     * 商品idの配列から含まれるタグのデータを取得する
     *
     * @param unknown $itemIdArr
     * @return 商品id,タグid,タグ名を含んだ配列
     */
    public function makeTagDataWhereInItemId( $itemIdArr = array()) {
        $this->bindModel(array('belongsTo'=>array('Tag')));
        $tagData = array();

        $tagData = $this->find('all',
            array(
                'fields' => array(
                    'ItemTag.item_id',
                    'ItemTag.tag_id' ,
                        'Tag.tag'
                ),
                'conditions' => array(
                    'ItemTag.item_id ' => $itemIdArr
                )
            )
        );

        $tagData2 = array();
        foreach ( $tagData as $tag ) {
            $tmp = array(
                'item_id' => $tag['ItemTag']['item_id'] ,
                'tag_id'  => $tag['ItemTag']['tag_id'] ,
                'tag'     => $tag['Tag']['tag']
            );
            $tagData2[] = $tmp;
        }

        return $tagData2;
    }

    /**
     * 関連テーブルデータからtagのidのみを抽出する
     *
     * @param unknown $tagIdArr タグID配列
     */
    public function getTagIdFromTagData( $itemIdArr = array() ){
		$tagData = $this->makeTagDataWhereInItemId( $itemIdArr );

		$tagIdArr = array();
		if( !empty($tagData) ){
            foreach ( $tagData as $tag ) {
                $tagIdArr[] = $tag['tag_id'];
             }
		}
        return $tagIdArr;
    }

    /**
     * タグ配列を一括でインサートする
     *
     * @param $itemId 商品Id
     * @param unknown $tagIdArr タグId配列
     */
    public function saveItemTagRelation( $itemId, $tagIdArr = array()){

    	$tagArr2 = array();
        foreach( $tagIdArr as $tagId ){

        	if( empty($tagId)) continue;

            $tagEntity = array(
                    'item_id' => $itemId,
                    'tag_id'  => $tagId
            );
            $tagArr2[] = $tagEntity;
        }
        $this->create();
        $this->saveAll( $tagArr2 );
    }

}
