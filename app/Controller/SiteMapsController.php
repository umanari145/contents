<?php 

App::uses('AppController', 'Controller');
App::import('Vendor', 'IXR');

use Underbar\ArrayImpl as _;

class SiteMapsController extends AppController {

   public $uses = array('Item');

   public $helpers = array('Time');
   public $components = array('RequestHandler');

   function index() {

       $this->layout = "/xml/sitemap";

       $item = $this->Item->find('all');
       $this->set('item', $item );
       $this->RequestHandler->respondAs('xml'); //xmlファイルとする
   }

}
