<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo SITE_TITLE ;?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('default');
		echo $this->Html->css('bootstrap');
		echo $this->Html->script('jquery-1.11.3.min');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('default');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
    <input type="hidden" name="site_url" id="site_url_id" value="<?php echo $siteUrl; ?>" >
	<?php echo $this->element('headnav'); ?>

	<div class="container maincontents">
		<?php echo $this->element('leftnav'); ?>
		<div class="row col-md-8">
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
			<?php //echo $this->element('sql_dump'); ?>
		</div>
	</div>
</body>
</html>
