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
class ItemImage extends Model {


	/**
	 * 商品画像を取得
	 *
	 * @param string $itemId 商品Id
	 * @return 画像のURL配列
     */
    public function getItemImage($itemId = null ) {

        $itemImageArr = array();

        if( $itemId == null ) {
            return $itemImageArr;
        }

        $itemImageArr = $this->find('all', array(
                    'fields' => array(
                        'image_url'
                        ),
                    'conditions'=>
                    array(
                        'item_id' => $itemId
                        ))
                );

        $smallUrlArr = array();   
        $largeUrlArr = array();   
        if( !empty($itemImageArr)){                                                                                                                                   
            foreach( $itemImageArr as $image ){
                $smallUrlArr[] = $image['ItemImage']['image_url'];
                $largeImageUrl = preg_replace( '/^(.*)(-\d+\.jpg)$/','$1jp$2',$image['ItemImage']['image_url'] );
                if( $this->is_url_exist ( $largeImageUrl ) ){
                    $largeUrlArr[] = $largeImageUrl;
                }  
            }
        }
        return array($smallUrlArr , $largeUrlArr);
    
    }
    
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

}
