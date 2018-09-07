<?php
$template = basename(get_page_template());

if (is_page_template('templates/flexible-template.php') || $template == 'page.php'):

	$faq_items = get_sub_field('faq_items');
	$heading = get_sub_field('heading');
	if($faq_items && array_filter($faq_items)): ?>
		<div class="faqs-block block">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 text-center">
						<?php if($heading) echo '<h3 class="section-heading">' . $heading . '</h3>'; ?>
						<?php if($faq_items):
								$i = 0;
								foreach($faq_items as $faq):
										$q = get_field('question', $faq->ID);
										$a = get_field('answer', $faq->ID); ?>
										<div class="faq-item <?php if($i == 0) echo 'active-faq'; ?>">
											<?php if($q) echo '<p class="faq-question">' . $q . '</p>';
											if($a) echo '<p class="faq-answer">' . $a . '</p>'; ?>
										</div>
										<?php $i++;
								endforeach;
							endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif;
else:
	$faqs = get_field("faqs");
	if($faqs && array_filter($faqs)): ?>
		<div class="faqs-block block">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 text-center">
						<?php if($faqs['heading']) echo '<h3 class="section-heading">' . $faqs['heading'] . '</h3>'; ?>
						<?php if($faqs['faq_items']):
								$i = 0;
								foreach($faqs['faq_items'] as $faq):
										$q = get_field('question', $faq->ID);
										$a = get_field('answer', $faq->ID); ?>
										<div class="faq-item <?php if($i == 0) echo 'active-faq'; ?>">
											<?php if($q) echo '<p class="faq-question">' . $q . '</p>';
											if($a) echo '<p class="faq-answer">' . $a . '</p>'; ?>
										</div>
										<?php $i++;
								endforeach;
						 	endif; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

<?php endif; ?>
