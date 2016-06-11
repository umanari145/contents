<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package        app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $uses = array('Item','Tag','Girl','ItemGirl','ItemTag');
    public $components = array('Session');

    public function beforeFilter(){

        //$tagList =  $this->Session->read("tagList");
        //if( empty( $tagList)){
            $tagList = $this->ItemTag->calcItemCountGroupByTag($this->Tag->getTagNameList());
        //    $this->Session->write("tagList" , $tagList);
        //}

        //女優は一時外す
        //$popularGirlList = $this->Session->read("popularGirlList");
        //if( empty( $popularGirlList)) {
        //    $popularGirlList = $this->ItemGirl->calculateGirlCount();
        //    $this->Session->write("popularGirlList", $popularGirlList);
        //}

        $this->set( 'siteUrl' , SITE_URL);
        $this->set( 'tagList' , $tagList);
        //女優は一時外す
        //$this->set( 'popularGirlList' ,$popularGirlList );
    }

    public function debugSQLlog( $sqlLog = array()){
        foreach ( $sqlLog['log'] as $sqlEachLog ) {
            $this->log("---------------------------------------------------------------------------------------", 'debug');
            $this->log($sqlEachLog['query'],'debug');
            $this->log($sqlEachLog['took']/1000 . "s" , 'debug');
            $this->log("---------------------------------------------------------------------------------------", 'debug');
        }
    }


    public function beforeRender(){
        $username = "ゲスト";
        $isLogin = false;
        if( $this->isLogin() === true ) {
            $user     = $this->getUser();
            $username = $user['username'];
            $isLogin  = true;
        }
        $this->set('username', $username );
        $this->set('isLogin', $isLogin );

    }

    /**
     * ログイン処理
     *
     * @param unknown $user ユーザー
     */
    public function doLogin( $user = array() ){
    	if( !empty( $user) ) $this->writeUserData( $user );
    }

    /**
     * ユーザーデータの削除
     *
     */
    public function doLogout(){
		$this->Session->delete( 'User' );
    }

    /**
     * ログインしているか否か
     *
     * @return boolean (ユーザー)/ false(ログインしていない)
     */
    public function isLogin(){
    	$user = $this->Session->read('User');
		return ( !empty($user) )? true : false ;
    }

    /**
     * ユーザーの取得
     *
     * @return User ユーザーデータ
     */
    public function getUser(){
    	if( $this->isLogin()){
    		return $this->Session->read('User');
    	} else {
    		return false;
    	}
    }

    /**
     * セッションデータを書き込む
     * @param $user ユーザー
     */
    public function writeUserData( $user = array() ){
    	if( !empty( $user) ) $this->Session->write('User' , $user);
    }
}
