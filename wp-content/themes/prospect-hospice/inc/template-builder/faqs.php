<?php
if(is_page_template('templates/flexible-template')):
	$faq_items = get_sub_field('faq_items');


else:
	$faqs = get_field("faqs");
	if($faqs && array_filter($faqs)): ?>
		<div class="faqs-block block">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 text-center">
						<?php if($faqs['heading']) echo '<h3 class="section-heading">' . $faqs['heading'] . '</h3>'; ?>
						<?php if($faqs['faq_items']):
								foreach($faqs['faq_items'] as $faq):
										$q = get_field('question', $faq->ID);
										$a = get_field('answer', $faq->ID);
										echo '<div class="faq-item">';
											if($q) echo '<p class="faq-question">' . $q . '</p>';
											if($a) echo '<p class="faq-answer">' . $a . '</p>';
										echo '</div>';
								endforeach;
						 	endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

<?php endif; ?>
