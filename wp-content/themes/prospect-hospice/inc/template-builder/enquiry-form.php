<?php
$form_id = get_sub_field('form_id');
$background_colour = get_sub_field('background_colour');
$title = get_sub_field('title');
?>

<div class="enquiry-form-block block" style="
	<?php if ($background_colour) { echo 'background-color: ' . $background_colour . '; '; } ?>
	">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if ($title) : ?>
					<h2><?php echo $title; ?></h2>
				<?php endif; ?>
				<?php echo do_shortcode('[gravityform id=' . $form_id . ' title=false description=false ajax=true]'); ?>
			</div>
		</div>
	</div>
</div>