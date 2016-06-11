<?php

App::uses('AppController', 'Controller');
use Underbar\ArrayImpl as _;

class UsersController extends AppController {

    public $uses = array('User','UserItem');


    public $layout ="contents";

    public $components = array (
            'Session',
            'Paginator'
    );

    public $paginate = array(
            'UserItem'=>array(
                    'limit'    => 8,
                    'recursive'=> 1
    ));


    /**
     * ユーザーの登録
     *
     * @throws NotFoundException
     */
    public function regist() {

        if ($this->request->is ( 'post' ) || $this->request->is ( 'put' )) {
            if( $this->User->save( $this->request->data['User'] )){
                $userId =  $this->User->getLastInsertId();
                if( !empty($userId)) {
                    $user['User']['id'] = $userId;
                    $itemId = $this->Session->read('favorite_item_id');
                    $this->regsitFavoriteItemAndRedirect( $user['User'], $itemId );
                }
            }
        }

        $this->render ( 'regist' );
    }
    /**
     * ログアウト処理を行います
     */
    public function logout() {
        $this->doLogout();
        //var_dump($this->Session->read('User'));
    }

    /**
     * ログイン処理を行う
     */
    public function login() {

        if( $this->request->is('post') ) {
            $user = $this->User->loginCheck( $this->request->data );
            if( $user !== false ) {
                //セッションがあったら取り出し
                $itemId = $this->Session->read('favorite_item_id');
                $this->regsitFavoriteItemAndRedirect( $user, $itemId );
            } else {
                echo 'fail';
                exit;
            }
        }
    }

    /**
     * お気に入り商品の登録とリダイレクト
     *
     * @param string $itemId
     */
    private function regsitFavoriteItemAndRedirect( $user = null, $itemId = "" ) {

        //user_itemsに保存
        if( !empty( $itemId ) ) {
            //itemidがあるとき
            $data =  array(
                    'user_id' => $user['id'],
                    'item_id' => $itemId
            );

            if( !$this->UserItem->hasFavorite( $data )){
                $this->UserItem->create();
                $this->UserItem->save( array( 'UserItem' => $data ) );
                $this->Session->setFlash ( 'お気に入りを追加しました。','default' , array('class' => 'success') );
                $this->Session->delete('favorite_item_id');
            }

            $this->doLogin( $user );
                return $this->redirect(
                    array('controller' => 'items', 'action' => 'view' , $itemId)
            );

        } else {
            return $this->redirect(
                    array('controller' => 'items', 'action' => 'index' )
            );
        }
    }


    /**
     * ログインメソッド(Ajax お気に入りボタン経由)
     */
    public function isLoginCheck() {

        $this->autoRender = false;
        if ( !$this->request->is ( 'ajax' )) {
            echo "fail";
            exit;
        }

        $itemId = $this->request->data['item_id'];

        if( !empty($itemId) ) $this->Session->write('favorite_item_id', $itemId);

        if( $this->isLogin() !== true ) {
            echo 'fail';
            exit;
        }

        $user = $this->getUser();
        $data = array(
                'item_id' => $itemId,
                'user_id' => $user['id']
        );
        if( !$this->UserItem->hasFavorite( $data )){
            $this->UserItem->create();
            $this->UserItem->save( array( 'UserItem' => $data ));
            $this->Session->setFlash ( 'お気に入りを追加しました。','default' , array('class' => 'success') );
            $this->Session->delete('favorite_item_id');
        }

        echo "success";
        exit;

    }

    /**
     * お気に入りの削除
     */
    public function deleteFavoriteItem(){
        $this->autoRender = false;
        if ( !$this->request->is ( 'ajax' )) {
        	echo "fail";
        	exit;
        }

        if( $this->isLogin() !== true ) {
        	echo 'fail';
        	exit;
        }

        $itemId = $this->request->data['item_id'];
        $user = $this->getUser();
        $conditions = array(
        		'item_id' => $itemId,
        		'user_id' => $user['id']
        );
        if( $this->UserItem->deleteAll( $conditions , false)){
            $this->Session->setFlash ( 'お気に入りを削除しました。' );
            echo "success";
            exit;
        }
    }
}