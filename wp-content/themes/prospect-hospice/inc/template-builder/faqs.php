<?php
$faq_items = get_sub_field('faq_items');
?>

<div class="faqs-block block">
	<div class="container">
		<div class="row">
		<?php foreach ($faq_items as $faq_item) : ?>
			<?php
			$question = (get_field('question', $faq_item->ID) ? get_field('question', $faq_item->ID) : $faq_item->post_title);
			$answer = get_field('answer', $faq_item->ID);
			?>
			<div class="col-12">
				<div class="accordion">
					<div class="question">
						<?php echo $question; ?>
					</div>
					<div class="answer">
						<?php echo $answer; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</div>

