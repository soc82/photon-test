<?php
$icon_block = get_sub_field('icon_block');
?>

<div class="icon_block block">
	<div class="container">
		<div class="row">
			<?php foreach($icon_block as $item) : ?>
				<div class="col-sm-12 col-md-4 icon-item">
					<?php if($item['icon']): ?>
						<span class="icon" <?php echo 'style="color: ' . $item['icon_colour'] . '"'; ?>>
							<?php echo $item['icon']; ?>
						</span>
					<?php endif; ?>
					<?php if($item['title']) echo '<h3>' . $item['title'] . '</h3>'; ?>
					<?php if($item['text']) echo '<p>' . $item['text'] . '</p>'; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
