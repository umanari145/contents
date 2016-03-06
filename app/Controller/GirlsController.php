<?php

App::uses('AppController', 'Controller');

use Underbar\ArrayImpl as _;

class GirlsController extends AppController {

	public $uses = ['Girl','ItemGirl'];

	public $layout ="girls";

	public function index(){
		$girlList = $this->Girl->getGirlList();
		var_dump( $girlList);
		exit;
	}

}