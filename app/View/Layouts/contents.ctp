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
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <title>
	 	<?php echo SITE_TITLE ;?>
	 </title>
	 <?php
	 	echo $this->Html->css('default');
	 	echo $this->Html->css('bootstrap');
	 	echo $this->Html->script('jquery-1.11.3.min');
	 	echo $this->Html->script('bootstrap.min');
	 	echo $this->Html->script('jquery.infinitescroll.min');
	 	echo $this->Html->script('default');
	 	echo $this->fetch('meta');
	 	echo $this->fetch('css');
	 	echo $this->fetch('script');
	 ?>
     </head>
     <script>
       (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
       (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
       m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
       })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

       ga('create', 'UA-75310888-3', 'auto');
       ga('send', 'pageview');

     </script>
<body>
    <input type="hidden" name="site_url" id="site_url_id" value="<?php echo $siteUrl; ?>" >
	<?php echo $this->element('headnav'); ?>

	<div class="container-fluid">
		<div id="total_container" class="row">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
   	    	<?php echo $this->element('leftnav'); ?>
			<?php //echo $this->element('sql_dump'); ?>
		</div><!-- total -->
	</div><!-- container-fluid -->

    <?php // echo $this->element('footer'); ?>
</body>
</html>
