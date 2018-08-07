<div class="col-12 col-md-6 col-xl-5">
	<?php theme_get_post_thumbnail('large', array('class' => 'img-fluid')); ?>	
	<div class="social">
		<h4>Share article</h4>
		<?php echo do_shortcode('[addtoany]');?>
	</div>
</div>

<div class="col-12 col-md-6 col-xl-7">
	<?php the_title( '<h1>', '</h1>' ); ?>
	<!-- Categories -->
	<?php $categories = get_the_category();
	if($categories) : 
		$catString = array();
		foreach ($categories as $category) {
			$catString[] = $category->name;
		}?>
		<h3 class="title-block bg-yellow"><?php echo implode(', ', $catString);?></h3>
	<?php endif;?>
	<div class="entry-content">
		<?php the_content();?>
		<a href="/news/" title="Back to news"><i class="fa fa-angle-left"></i> Back to News</a>
	</div>
</div>