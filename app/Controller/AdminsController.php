<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

App::uses('AppController', 'Controller');
App::import('Vendor', 'IXR');

use Underbar\ArrayImpl as _;

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class AdminsController extends AppController {

/**
 * @var array
 */
    public $uses = array('Admin','Item','Tag','ItemTag','UserItem');

    public $layout ="admin";

    public $components = array (
            'Session',
            'Paginator',
            'Cookie',
            'Auth' => array (
                    'loginRedirect' => array (
                            'controller' => 'admins',
                            'action' => 'itemindex'
                    ),
                    'logoutRedirect' => array (
                            'controller' => 'admins',
                            'action' => 'login'
                    ),
                    'loginAction' => array (
                            'controller' => 'admins',
                            'action' => 'login'
                    ), // テーブル名がuserでないときは↓下記のように設定します。
                    'authenticate' => array (
                            'Form' => array (
                                    'userModel' => 'Admin'
                            )
                    )
            )
    );

    public function beforeFilter() {
    	parent::beforeFilter();
        AuthComponent::$sessionKey = 'Auth.admins';
        $this->Auth->allow ( 'login', 'logout');
    }

    public function itemindex() {
        $this->set('items' , $this->Paginator->paginate('Item'));
    }

    public function edit($id = null) {

    	$this->Item->id = $id;

    	if (! $this->Item->exists ()) {
    		throw new NotFoundException ( '存在しない商品です。' );
    	}

    	if( $this->request->is('post')) {
    		$inputData = $this->request->data['Item'];
    	    $this->Item->save( $inputData );

    	    if( !empty( $inputData['movie_image'])) {
    	        move_uploaded_file($inputData['movie_image']['tmp_name'],  MOVIE_IMAGE_URL . $inputData['original_id'] . '.jpg' );
    	    }
    	    $inputTagIdArr = array();
    	    $this->ItemTag->deleteAll( array('item_id'=>$id ) );
    	    if( !empty($inputData['tag'])) $inputTagIdArr = $inputData['tag'];
            $this->ItemTag->saveItemTagRelation( $id, $inputTagIdArr );
    	}

    	$itemDetail = $this->Item->findAllById($id);
    	$tagIdArr = $this->ItemTag->getTagIdFromTagData( array($id));
    	$itemDetail[0]['Item']['tag'] = $tagIdArr;
    	$this->request->data['Item'] = $itemDetail[0]['Item'];

    	$this->set( 'tagList' ,$this->Tag->makePulldownTagList());

    }


    /**
     * ログインメソッド
     */
    public function login() {

        if ($this->Auth->loggedIn ()) {
            $this->redirect ( $this->Auth->redirect () );
        }
        if ($this->request->is ( 'post' )) {
            if ($this->Auth->login () ) {
                $this->redirect ( $this->Auth->redirect () );
            } else {
                $this->Session->setFlash ( '管理画面ログインに失敗しました。正しいユーザー名とパスワードを入力してください。', 'default', array (), 'auth' );
            }
        }
    }
    /**
     * ログアウト処理を行います
     */
    public function logout() {
        $this->redirect ( $this->Auth->logout () );
    }

}
