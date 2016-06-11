<?php

App::uses('Component', 'Controller');
App::uses('Component', 'Controller');

class LoginComponent extends Component{

    /**
    *  ログインしているか否か
    */
    private $isLogin;

    /**
    *  ユーザー名
    */
    private $username;

    /**
     * ログインしているか否か
     *
     * @return boolean trueログイン / false ログインしていない
     */
    public function isLogin(){
         return ( $this->isLogin === true ) ? true : false ;
    }

    /**
     * ユーザー名の取得
     *
     */
    public function getLoginUserName(){
        return $this->username;
    }

    public function login($username = "", $password ="") {
        if( $username === "" || $password === "") return false;

        $userInstance = ClassRegistry::init('User');
        $params = array(
            'conditions' => array(
                'username' => $username,
                'password' => $password
            )
        );

        echo $userInstance->find('count' , $params);
    }
}