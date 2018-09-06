<?php
$heading = get_sub_field('heading');
$content = get_sub_field('content');
$below_hero_banner = get_sub_field('below_hero_banner');
$heading_colour = get_sub_field('heading_colour');
?>

<div class="full-width-content block" >
	<div class="container">
		<div class="row">
			<div class="col-12 ">
				<?php if($heading) : ?>
					<h2 <?php if ($below_hero_banner) echo "class='below_hero'"; ?>
					<?php if ($heading_colour) echo 'style="background: ' . $heading_colour . '"'; ?>
					>
						<?php echo $heading; ?>
							
						</h2>
				<?php endif; ?>

				<?php if ($below_hero_banner) : ?>
					<div class="content-below-hero">
				<?php endif; ?>

				<?php echo $content; ?>
				
				<?php if ($below_hero_banner) : ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
