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
<?php echo $this->Form->button('登録する' , array(
		'class' => 'btn btn-primary	'
)); ?>
