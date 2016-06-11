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
App::uses ( 'AppModel', 'Model' );

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package app.Model
 */
class Item extends AppModel {



	public $name ="Item";

    public $basic_sql=" select Item.id, Item.original_id, Item.title, Item.volume from items as Item where Item.delete_flg = false  order by Item.id desc ";

    public $basic_sql_count = " select COUNT(Item.id) from items Item  where Item.delete_flg = false  ";

    public function paginate($conditions,$fields,$order,$limit,$page=1,$recursive=null,$extra=array()){
        if($page==0){$page = 1;}
        $recursive = -1;
        $offset = $page * $limit - $limit;
        $sql = $this->basic_sql . ' limit ' . $limit . ' offset ' . $offset;
        return $this->query($sql);
    }

    public function paginateCount($conditions=null,$recursive=0,$extra=array()){
        $this->recursive = $recursive;
        $results = $this->query($this->basic_sql_count);

        $count=0;
        if( isset($results[0][0]["COUNT(Item.id)"]) === true ) {
            $count = $results[0][0]["COUNT(Item.id)"];
        }

        return $count;
    }

    /**
     * 女優から商品を取得するSQLのセット
     *
     */
    public function setGirlSQL( $girl_id ) {
        $this->basic_sql       = $this->makeGirlSQL( 'all' , $girl_id );
        $this->basic_sql_count = $this->makeGirlSQL( 'count' , $girl_id );
    }

    /**
     * タグから商品を取得するSQLのセット
     *
     */
    public function setTagSQL( $tag_id ) {
        $this->basic_sql       = $this->makeTagSQL( 'all' , $tag_id );
        $this->basic_sql_count = $this->makeTagSQL( 'count' , $tag_id );
    }

    /**
     * キーワードから商品を取得するSQLのセット
     *
     */
    public function setItemFromQueryStr( $keyword ) {
        $this->basic_sql       = $this->makeItemKeyword( 'all' , $keyword );
        $this->basic_sql_count = $this->makeItemKeyword( 'count' , $keyword );
    }

    /**
     * girl_idからの商品データの取得
     *
     * @param unknown $type all(通常のカラムを取得)/count(件数取得)
     * @param unknown $girl_id 女優ID
     */
    private function makeGirlSQL( $type = 'all', $girl_id ){

        $col = "";
        switch( $type ) {
            case 'all':
                $col= 'Item.* , Girl.*';
                break;
            case 'count':
                $col = 'COUNT(Item.id) ';
                break;
        }

          $sql = " SELECT "
            .  $col
            . " FROM "
            . "    item_girls ItemGirl "
            . "        LEFT JOIN "
            . "            girls Girl "
            . "        ON  ItemGirl.girl_id = Girl.id "
            . "        JOIN "
            . "            items Item "
            . "        ON  ItemGirl.item_id = Item.id "
            . "            and Item.delete_flg = false "
            . "    WHERE "
            . "        Girl.id = " . $girl_id
            . "    ORDER BY "
            . "        item_order ASC " ;
          return $sql;
    }

    /**
     * tag_idからの商品データの取得
     *
     * @param unknown $type all(通常のカラムを取得)/count(件数取得)
     * @param unknown $tag_id タグID
     */
    private function makeTagSQL( $type = 'all', $tag_id ){

        $col = "";
        switch( $type ) {
            case 'all':
                $col= 'Item.* , Tag.*';
                break;
            case 'count':
                $col = 'COUNT(Item.id) ';
                break;
        }

        $sql = " SELECT "
            .  $col
            . " FROM "
            . "    item_tags ItemTag "
            . "        LEFT JOIN "
            . "            tags Tag "
            . "        ON  ItemTag.tag_id = Tag.id "
            . "        JOIN "
            . "            items Item "
            . "        ON  ItemTag.item_id = Item.id "
            . "            and Item.delete_flg = false "
            . "    WHERE "
            . "        Tag.id = " . $tag_id
            . "    ORDER BY "
            . "        Item.id DESC " ;
        return $sql;
    }


    /**
     * keywordを検索文字列としてSQLを作る
     *
     * @param unknown $type all(通常のカラムを取得)/count(件数取得)
     * @param $keyword キーワード
     * @return sql
     *
     */
    private function makeItemKeyword( $type ='all', $keyword ) {

        $col = "";
        switch( $type ) {
            case 'all':
                $col= 'Item.*';
                break;
            case 'count':
                $col = 'COUNT(Item.id) ';
                break;
        }


        $sql= " SELECT  "
            . $col
               ." FROM  "
            ."     items as Item   "
            ." WHERE  "
            ."  Item.delete_flg = false and  "
            ."  (  Item.title like '%". $keyword . "%'  "
            ." OR "
            ."    Item.genre like '%" . $keyword ."%'  "
            ." OR "
              ."   Item.comment like '%" . $keyword ."%' )  "
            ." ORDER BY  "
            ."    Item.id "
            ." DESC ";
        return $sql;
    }

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
            $this->addAttribute( $contents ,'index');
        }
        return $contentsList;
    }

    /**
     * 商品詳細のページ
     *
     * @param string $id
     * @param $size 動画サイズ
     * @throws NotFoundException 商品が存在しないときのエラー
     * @return 商品詳細データ
     */
    public function getItemDetail($id = null, $size = array() ) {
        if (! $this->exists ()) {
            throw new NotFoundException ( '存在しない商品です。' );
        }

        $params = array(
                'conditions' => array (
                        'Item.id' => $id
                )
        );

        $contentsDetail = $this->find ( 'first', $params);
        $this->setMovieSize( $contentsDetail, $size );
        return $contentsDetail;
    }


    private function setMovieSize( &$contentsDetail = array(), $size = array() ) {

        $movieUrl = $contentsDetail['Item']['movie_url'];
        $movieUrl =  preg_replace( '/width=("|\'|)\d{3}("|\'|)*/', 'width="'. $size['width'] .'"', $movieUrl);
        $movieUrl =  preg_replace( '/height=("|\'|)\d{3}("|\'|)*/', 'height="'. $size['height'] .'"', $movieUrl);
        //fc2パターン
        $movieUrl =  preg_replace( '/ w=("|\'|)\d{3}("|\'|)*/', ' w="'. $size['width'] .'"', $movieUrl);
        $movieUrl =  preg_replace( '/ h=("|\'|)\d{3}("|\'|)*/', ' h="'. $size['height'] .'"', $movieUrl);

        //erovideoのパターン
        $movieUrl =  preg_replace( '/"mcd=(.*?)".*?,.*?\d{3}.*?,.*?\d{3}.*?/', '"mcd=${1}" ,'. $size["width"] .' , '. $size["height"]  , $movieUrl);

        $contentsDetail['Item']['movie_url'] = $movieUrl;

    }

    /**
    *  サンプル動画の追加
    *  @param $item 動画
    *
    */
    private function addAttribute( &$item = null, $size = array()){

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

    /**
     *  同一id商品(同一サイト内も全サイトでもチェックする)が既存のテーブルにあるかいなか
     *
     * @param unknown $item 商品データ
     * @return true(あり)/false()
     */
    public function existItem( $item ) {

        $conditions = array();
        if( !empty($item['original_contents_id']) ) {

            $conditions = array(
                  'or' => array(
                       array( 'Item.original_id'          => $item['original_id'] ),
                       array( 'Item.original_contents_id' => $item['original_contents_id'] )
                  )
            );

        } else {
            $conditions = array(
                    'Item.original_id'     => $item['original_id']
            );
        }

        $itemCount = $this->find('count',array(
            'conditions' => $conditions
        ));

        return  ( $itemCount > 0 ) ? true:false;
    }

    /**
     * 商品を順番に並べる
     *  1 order_itemの昇順、
     *  2 更新日の昇順
     *
     */
    public function getItemOrderLine(){

        $this->unbindModel(
            array(
                   'hasAndBelongsToMany'=>array('Tag','Girl'),
            )
        );

        $itemData = $this->find('all',array(
                'fields'=>array(
                       'id',
                       'title',
                       'created',
                       'item_order'
                ),
                'order' => array(
                    'item_order' => 'ASC',
                    'modified'   => 'DESC'
                )
        ));
        return $itemData;
    }
    /**
    *   動画が存在している
    *
    * @param $url URL
    * @return true(存在する)/false(存在しない)
    */
    public function is_url_exist($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($code == 200){
            $status = true;
        }else{
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

    public function existOriginalItem(){
        $itemData = $this->find('all',array(
                'fields'=>array(
                       'id',
                       'title',
                       'created',
                       'item_order'
                ),
                'conditions' => array(
                    'item_order' => 'ASC',
                    'modified'   => 'DESC'
                )
        ));
        return $itemData;
    }

}
