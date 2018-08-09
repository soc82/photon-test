<?php
$testimonial_items = get_sub_field('testimonial_items');
$background_colour = get_sub_field('background_colour');
?>

<div class="testimonial-block block" style="background-color: <?php echo $background_colour; ?>" >
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="testimonials">
				<?php foreach ($testimonial_items as $testimonial_item) : ?>
					<?php
						$name = get_field('name', $testimonial_item->ID);
						$testimonial = get_field('testimonial', $testimonial_item->ID);
					?>
					<div class="testimonial">
						<?php if($testimonial) echo '<p>' . $testimonial . '</p>'; ?>
						<?php if($name) echo '<span class="name">' . $name . "</span>"; ?>
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
