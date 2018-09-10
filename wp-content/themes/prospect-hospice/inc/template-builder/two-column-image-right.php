<?php
$content_type = get_sub_field('content_type');
$image = get_sub_field('image');
$video_url = get_sub_field('video_url');
$heading = get_sub_field('heading');
$content = get_sub_field('content');
$button_text = get_sub_field('button_text');
$button_url = get_sub_field('button_url');
$background_colour = get_sub_field('background_colour');
$color_class = prospect_dark_colour_class();
?>

<div class="two-column-block two-column-image-right " <?php if ($background_colour && $background_colour != 'section') { echo 'style="background-color: ' . $background_colour . ';"'; } ?> >
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-10 offset-md-1">
				<div class="row">
					<div class="col-12 col-md-7 ">
						<div class="two-column-content">
							<?php if($heading) echo '<h3 class="' . $color_class .' ">' . $heading . '</h3>' ?>
							<?php if($content) echo '<div class="' . $color_class .' ">' . $content . '</div>'; ?>
							<?php if ($button_url && $button_text) : ?>
								<a class="btn btn-arrow-right <?php if($background_colour == '#8dc63f') echo 'btn-yellow'; ?>" href="<?php echo $button_url; ?>"><?php echo $button_text; ?></a>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-12 col-md-5">
						<div class="two-column-image">
							<?php if ($content_type == 'video'): ?>
								<?php if($video_url): ?>
								<a href="<?php echo $video_url; ?>" target="_blank">
									<span><i class="fas fa-play"></i></span>
								</a>
								<?php endif; ?>
							<?php endif; ?>
							<?php if($image): ?>
								<img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" class="img-fluid">
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
