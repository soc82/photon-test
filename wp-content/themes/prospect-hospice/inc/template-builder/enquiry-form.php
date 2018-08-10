<?php
$form_id = get_sub_field('form_id');
$title = get_sub_field('title');
?>

<div class="enquiry-form-block block">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
				<?php if ($title) : ?>
					<h2 class="section-heading"><?php echo $title; ?></h2>
				<?php endif; ?>
				<?php echo do_shortcode('[gravityform id=' . $form_id . ' title=false description=false ajax=true]'); ?>
			</div>
		</div>
	</div>
</div>
