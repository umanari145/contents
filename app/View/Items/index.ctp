
<table cellpadding="0" cellspacing="0" >
	<tr>
		<th>No</th>
   		<th>アイテム名</th>
	</tr>

    <?php foreach ($items as $item): ?>
	<tr>
		<td><?php echo $item['Item']['contents_num']; ?></td>
		<td><?php echo $item['Item']['contents_name']; ?></td>
	</tr>
    <?php endforeach;?>
    <!--items_area end-->
</table>

