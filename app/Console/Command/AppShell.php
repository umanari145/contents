<?php
/**
 * AppShell file
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
 * @since         CakePHP(tm) v 2.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Shell', 'Console');

/**
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package       app.Console.Command
 */
class AppShell extends Shell {


    public function main() {

        $this->loadModel('TransactionManager');
        $transaction = $this->TransactionManager->begin();
        try {
            $this->out ( "start_batch" );
            $this->out ( date ( "Y-m-d H:i:s" ) );
            $this->getItemData ();
            $this->out ( date ( "Y-m-d H:i:s" ) );
            $this->out ( "last_batch" );
            $this->TransactionManager->commit($transaction);
        }catch(Exception $e) {
            $this->log( $e->getMessage(),'error');
            $this->TransactionManager->rollback($transaction);
        }
    }

}
