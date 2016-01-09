


<?php echo $itemDetail['Item']['productName'];?>
<?php echo $this->Html->image($itemDetail['Item']['pictureUrl'],
						array(  'class'=>'contents_image',
								'id' =>'contents_image_id_' . $itemDetail['Item']['id']
								));
				 ?>
<?php echo $itemDetail['Item']['summary'];?>

