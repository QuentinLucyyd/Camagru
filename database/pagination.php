<div class="pagination">
<?php
	$pagination = $count / 6;
	$pagination = floor($pagination);
	if (is_float($count / 6))
		$pagination = $pagination + 1;
	?>
	<a href="gallery.php" class="page gradient">1</a>
	<?php
	for($i = 2; $i < $pagination + 1; $i++){
?>
		<a href="<?php echo "gallery.php?page=".$i?>" class="page gradient"><?php echo $i?></a>
	<?php }?>
</div>
