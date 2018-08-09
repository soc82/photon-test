<?php
$background_image = get_sub_field('background_image');
//$background_colour = get_sub_field('background_colour');
$heading = get_sub_field('heading');
$content = get_sub_field('content');
$buttons = get_sub_field('buttons');
?>
<div class="cta-block block" style="
	<?php // if ($background_colour) { echo 'background-color: ' . $background_colour . '; '; } ?>
	<?php if ($background_image) { echo 'background-image: url(' . $background_image . ');'; } ?>
	" >
	<?php if ($background_image){ ?>
		<div class="overlay"></div>
	<?php } ?>
	<div class="container cta-block-content">
		<div class="row">
			<div class="col-12 col-md-8 col-lg-6">
				<h2><?php echo $heading; ?></h2>
				<?php if ($content) : ?>
					<p><?php echo $content; ?></p>
				<?php endif; ?>
				<?php if ($buttons) : ?>
					<?php foreach ($buttons as $button) : ?>
						<a href="<?php echo $button['button_link']; ?>" class="btn btn-arrow-right"><?php echo $button['button_text']; ?></a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
