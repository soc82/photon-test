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
						$id = $testimonial_item->ID;
						$name = get_field('name', $id);
						$testimonial = get_field('testimonial', $id);
					?>
					<div class="testimonial">
						<p><?php echo $testimonial; ?></p>
						<span class="name"><?php echo $name; ?></span>
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>