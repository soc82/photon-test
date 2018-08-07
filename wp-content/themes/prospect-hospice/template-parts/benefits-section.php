<?php
$benefits_header = get_field('benefits_section_heading');
$benefits_items = get_field('benefits_section_items');
$benefits_background_colour = get_field('benefits_section_background_colour');
?>

<?php if ($benefits_header && $benefits_items) : ?>
	<div class="container-fluid">
		<div class="row benefits bg-very-light-grey">
			<div class="col-12">
				<h3><?php echo $benefits_header; ?>
			</div>
			<?php foreach ($benefits_items as $item) : ?>
				<div class="col-6 col-md-4 benefits-item">
					<span><?php echo $item['icon']; ?></span>
					<div class="title"><?php echo $item['text']; ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>