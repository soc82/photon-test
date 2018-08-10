<?php
$testimonial_items = get_sub_field('testimonial_items');
$background_colour = get_sub_field('background_colour');
$color_class = prospect_dark_colour_class();
?>

<div class="testimonial-block block <?php if($background_colour == 'white') echo 'white-background-block'; ?>" style="background-color: <?php echo $background_colour; ?>" >
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-10 offset-lg-1">
				<div class="testimonials">
				<?php foreach ($testimonial_items as $testimonial_item) : ?>
					<?php
						$name = get_field('name', $testimonial_item->ID);
						$testimonial = get_field('testimonial', $testimonial_item->ID);
					?>
					<div class="testimonial">
						<?php if($testimonial) echo '<p class="' . $color_class . '">' . $testimonial . '</p>'; ?>
						<?php if($name) echo '<span class="name ' . $color_class . '">' . $name . "</span>"; ?>
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
