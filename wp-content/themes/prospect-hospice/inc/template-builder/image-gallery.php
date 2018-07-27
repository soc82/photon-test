<?php
$gallery_items = get_sub_field('gallery_item');
?>

<div class="image-gallery-block">
	<div class="container">
		<div class="row">
			<?php foreach ($gallery_items as $gallery_item) : ?>
				<?php $image = $gallery_item['image']['sizes']['large']; ?>
				<div class="col-12">
					<img src="<?php echo $image; ?>">
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>