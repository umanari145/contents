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
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

     public $uses = array('Item','Tag','Girl','ItemGirl','ItemTag');

    public function beforeFilter(){
        $tagList = $this->ItemTag->calcItemCountGroupByTag($this->Tag->getTagNameList());
        $this->set( 'siteUrl' , SITE_URL);
        $this->set( 'tagList' , $tagList);
//        $this->set( 'girlList' , $this->Girl->getGirlList() );
        $this->set( 'girlList' , array() );
    }

	public function debugSQLlog( $sqlLog = array()){
		foreach ( $sqlLog['log'] as $sqlEachLog ) {
			$this->log($sqlEachLog['query']);
			$this->log($sqlEachLog['took']/1000 . "s");
		}
	}

}
