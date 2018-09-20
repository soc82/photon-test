<?php
$background_image = (get_sub_field('background_image') ? get_sub_field('background_image') : get_field('background_image'));
$heading = (get_sub_field('heading') ? get_sub_field('heading') : get_field('heading'));
$content = (get_sub_field('content') ? get_sub_field('content') : get_field('content'));
$buttons = (get_sub_field('buttons') ? get_sub_field('buttons') : get_field('buttons'));
?>
<div class="cta-block block" style="
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
					<?php echo $content; ?>
				<?php endif; ?>
				<?php if ($buttons) : ?>
					<?php foreach ($buttons as $button) :
						if($button['button_link']['url']): ?>
							<a href="<?php echo $button['button_link']['url']; ?>" class="btn <?php echo $button['button_type']; ?>"><?php echo $button['button_text']; ?></a>
					<?php endif;
				endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
