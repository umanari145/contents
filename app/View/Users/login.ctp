<div class="regist_area pull-right col-xs-12 col-sm-8 col-md-10 col-lg-10">

    <?php echo $this->Form->create('User'); ?>
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
</div>