<?php
$icon_block = get_sub_field('icon_block');
?>

<div class="icon_block block">
	<div class="container">
		<div class="row">
			<?php foreach($icon_block as $item) : ?>
				<div class="col-lg-4 col-md-6 col-sm-12 icon-item">
					<span class="icon" <?php echo 'style="color: ' . $item['icon_colour'] . '"'; ?>>
						<?php echo $item['icon']; ?>
					</span>
					<h3><?php echo $item['title']; ?></h3>
					<p><?php echo $item['text']; ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>