<?php
$intro_heading = get_sub_field('intro_heading');
$intro_description = get_sub_field('intro_description');
$testimonial_items = get_sub_field('testimonial_items');
$background_colour = get_sub_field('background_colour');
$color_class = prospect_dark_colour_class();
?>
<div class="container testimonial-intro">
	<div class="row">
		<div class="col-12">
			<div class="intro">
				<h2><?php echo $intro_heading; ?></h2>
				<p><?php echo $intro_description; ?></p>
			</div>
		</div>
	</div>
</div>
<div class="testimonial-block block <?php if($background_colour == 'white') echo 'white-background-block'; ?>" style="background-color: <?php echo $background_colour; ?>" >
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-10 offset-lg-1">
				<div class="testimonials">
				<?php foreach ($testimonial_items as $testimonial_item) : ?>
					<?php
						$name = get_field('name', $testimonial_item->ID);
						$testimonial = get_field('testimonial', $testimonial_item->ID);
						$testimonial_image = get_field('testimonial_image',$testimonial_item->ID);
					?>
					<div class="testimonial">
						<?php if($testimonial) echo '<p class="' . $color_class . '">' . $testimonial . '</p>'; ?>
						<?php if($testimonial_image) { ?>
							<div class="testimonial-image">
								<?php echo '<img class="testimonial-image" src="' . $testimonial_image['sizes']['medium'] . '" alt="' . $testimonial_image['alt'] . '" />'; ?>
								<?php if($name) echo '<div class="name ' . $color_class . '">' . $name . "</div>"; ?>
							</div>
						<?php } else {?>
							<?php if($name) echo '<span class="name ' . $color_class . '">' . $name . "</span>"; ?>
						<?php }?>
						
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
