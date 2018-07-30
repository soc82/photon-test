<?php
$content_type = get_sub_field('content_type');
$image = get_sub_field('image');
$video_url = get_sub_field('video_url');
$heading = get_sub_field('heading');
$content = get_sub_field('content');
$button_text = get_sub_field('button_text');
$button_url = get_sub_field('button_url');
$background_colour = get_sub_field('background_colour');
?>

<div class="two-column-image-left block" <?php if ($background_colour) { echo 'style="background-color: ' . $background_colour . ';"'; } ?> >
	<div class="container">
		<div class="row">
			<div class="col-6 left">
				<?php if ($content_type == 'image'): ?>
					<img src="<?php echo $image; ?>">
				<?php elseif ($content_type == 'video'): ?>

				<?php endif; ?>
			</div>
			<div class="col-6 right">
				<h3><?php echo $heading; ?></h3>
				<p><?php echo $content; ?></p>
				<?php if ($button_url && $button_text) : ?>
					<a class="btn" href="<?php echo $button_url; ?>"><?php echo $button_text; ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
