<?php echo $this->Form->create('Item' , array('type' => 'post', 'enctype' => 'multipart/form-data')); ?>


<?php
   echo $this->Html->image ( $this->request->data['Item'] ['original_id'] .".jpg", array (
     'url' => array (
             'controller' => 'items',
             'action' => 'view',
             $this->request->data ['Item'] ['id']
     ),
     'width'  => 150,
     'class' => 'contents_image'
                                    ) );
 ?>

<?php
echo $this->Form->input ( 'movie_image', array (
        'label' => '画像','type'=>'file'
) );
?>


<?php
echo "投稿日" . $this->request->data ['Item']['created'];
?>

<?php
echo $this->Form->input ( 'title', array (
        'label' => '商品タイトル'
) );
?>
<?php
echo $this->Form->input ( 'original_id', array (
        'label' => 'オリジナルID',
		'type' =>"text"
) );
?>

<?php
echo $this->Form->input ( 'volume', array (
        'label' => '時間'
) );
?>


<?php
echo $this->Form->input ( 'movie_url', array (
        'label' => '動画URL'
) );
?>

<?php
echo $this->request->data['Item']['movie_url'];
?>

<?php
echo $this->Form->input ( 'original_contents_id', array (
        'label' => 'オリジナルコンテンツID',
		'type' =>"text"
) );
?>

<?php
echo $this->Form->input ( 'tag', array (
		'label' => 'タグ',
		'type'  => "select",
		'multiple' => 'checkbox',
		'options' => $tagList
) );

?>

<?php echo $this->Form->button('登録する' , array(
		'class' => 'btn btn-primary	'
)); ?>
