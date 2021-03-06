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
App::uses ( 'AppController', 'Controller' );

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 *
 */
class TagsController extends AppController {

	/**
	 *
	 * @var array
	 */
	//ここの宣言で一番最初のものがページャーたいｓｈ
	public $uses = [
			'Item',
			'Tag'
	];
	public $layout = "contents";
	public function beforeFilter() {
		$this->set ( 'tagList', $this->Tag->getTagList () );
	}
	public function tagList($id) {
		$this->paginate = [
				'conditions' => [
						'Tags.id' => $id
				]
		];
		$items = $this->paginate ();

		$this->set ( 'items', $items );
	}
	public function view($id = null) {
		$this->Item->id = $id;

		if (! $this->Item->exists ()) {
			throw new NotFoundException ( '存在しない商品です。' );
		}
		$this->set ( 'itemDetail', $this->Item->getItemDetail ( $id ) );
	}
}
