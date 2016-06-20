<?php echo $this->Form->create('Admin'); ?>
<?php
echo $this->Form->input ( 'username', array (
        'label' => 'ユーザー名'
) );
?>
<?php
echo $this->Form->input ( 'password', array (
        'label' => 'パスワード'
) );
?>
<p><?php echo $this->Form->button('ログインする', array(
		'class' =>'btn btn-primary'
)); ?>
</p>
