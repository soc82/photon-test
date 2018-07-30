<?php
$benefits_header = get_field('benefits_section_heading');
$benefits_items = get_field('benefits_section_items');
$benefits_background_colour = get_field('benefits_section_background_colour');
?>

<?php if ($benefits_header && $benefits_items) : ?>
	<div class="row benefits">
		<div class="col-12">
			<h3><?php echo $benefits_header; ?>
		</div>
		<?php foreach ($benefits_items as $item) : ?>
			<div class="col-md-4 col-12 benefits-item">
				<span><?php echo $item['icon']; ?> <?php echo $item['text']; ?></span>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>