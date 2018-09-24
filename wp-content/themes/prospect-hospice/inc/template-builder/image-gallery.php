<?php
$template = basename(get_page_template());
if(is_page_template('templates/flexible-template.php') || $template = 'page.php' && get_post_type() == 'page'):
	$gallery = get_sub_field('gallery_item');
else:
	$gallery = get_field('image_gallery');
endif;
if($gallery):
	echo '<div class="image-gallery-block block">';
		echo '<div class="container">';
			echo '<div class="row">';
				echo '<div class="col-12">';
					foreach($gallery as $image):
						if($image['image']): ?>
						<a class="lightbox-gallery" href="<?php echo $image['image']['sizes']['large']; ?>" data-caption="<?php if($image['image']['alt']) echo $image['image']['alt']; else echo ''; ?>" style="background:url(<?php echo $image['image']['sizes']['large']; ?>);"></a>
				<?php endif;
					endforeach;
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
endif; ?>
