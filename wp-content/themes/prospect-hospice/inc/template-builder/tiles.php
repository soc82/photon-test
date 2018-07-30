<?php

$tile_items = get_sub_field('tile_items');

?>
<div class="tile-block block">
	<div class="row no-gutters">
		<?php foreach ($tile_items as $tile_item) : ?>
			<?php
				$image = $tile_item['image']['sizes']['large'];
				$heading = $tile_item['heading'];
				$link = $tile_item['link'];
			?>
			<div class="col-4">
				<a class="image-tile" href="<?php echo $link; ?>" style="background-image: url(<?php echo $image; ?>)">
					<div class="overlay">
						<h4><?php echo $heading; ?></h4>
					</div>
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</div>


