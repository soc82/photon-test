<?php

$tile_items = get_sub_field('tile_items');
$heading = get_sub_field('heading');
$show_donate_button = get_sub_field('show_donate_button');
$donate_button_link = get_sub_field('donate_button_link');

?>
<div class="tile-block block">
	<div class="container">
		<div class="row">
			<div class="col-12 header">
				<h2><?php echo $heading; ?></h2>
				<?php if ($show_donate_button) : ?>
					<a class="btn btn-donate" href="#">Donate</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="row no-gutters">
		<?php foreach ($tile_items as $tile_item) : ?>
			<?php
				$image = $tile_item['image']['sizes']['large'];
				$heading = $tile_item['heading'];
				$link = $tile_item['link'];
			?>
			<div class="col-12 col-sm-4">
				<a class="image-tile" href="<?php echo $link; ?>" style="background-image: url(<?php echo $image; ?>)">
					<div class="overlay">
						<?php if($heading) echo '<h4>' . $heading . '</h4>'; ?>
						<span class="circle-arrow"><i class="far fa-long-arrow-right"></i></span>
					</div>
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</div>
