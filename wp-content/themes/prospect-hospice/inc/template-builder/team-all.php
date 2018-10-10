<?php $background_colour = get_sub_field('background_colour');?>
<?php $heading = get_sub_field('heading');?>
<?php $intro = get_sub_field('intro');
$color_class = prospect_dark_colour_class(); ?>
<?php $categories = get_terms( array(
    'taxonomy' => 'team-category',
    'hide_empty' => true,
));
wp_reset_postdata();
?>
<div class="team-block" <?php if($background_colour && $background_colour != 'section') echo 'style="background-color:'.$background_colour.'"';?>>
    <div class="container">
    	<?php if($heading) : ?>
	        <div class="row">
	            <div class="col-12">
	                <h2 class="<?php echo $color_class; ?>"><?php echo $heading;?></h2>
	                <?php if($intro) : ?>
		                <p class="intro <?php echo $color_class; ?>"><?php echo $intro;?></p>
		            <?php endif;?>
	            </div>
	        </div>
	    <?php endif;?>

	    <?php if($categories) : ?>
	    	<?php foreach($categories as $category) : ?>
	    		<div class="row">
	    			<div class="col-12">
	    				<h3 class="title-block bg-yellow"><?php echo $category->name;?></h3>
	    			</div>
	    		</div>

	    		<?php // Get Team Members
	    		$team_members = get_posts(
	    			array(
	    				'showposts' => -1,
						'post_type' => 'team',
						'tax_query' => array(
					        array (
					            'taxonomy' => 'team-category',
					            'field' => 'term_id',
					            'terms' => $category->term_id,
					        )
					    ),
					)
				);

				//print_r($items); die();
				if ( $team_members ) : ?>
					<div class="row">

						<?php foreach($team_members as $team) : ?>
			                <div class="col-12 col-md-6 col-lg-3">
			                    <?php //print_r($team);?>
			                    <div class="team">
			                        <a href="#team-<?php echo $team->ID;?>" rel="modal:open">
			                            <?php $image = get_field('image', $team->ID);
			                            if($image) : ?>
			                                <div class="image-wrapper">
			                                    <div class="image" style="background-image:url(<?php echo $image['sizes']['large'];?>);"></div>
			                                </div>
			                            <?php endif;?>
			                           <h4 class="<?php echo $color_class; ?>"><?php echo $team->post_title;?></h4>
			                           <?php $job_title = get_field('job_title', $team->ID);
			                            if($job_title) : ?>
			                               <p class="job_title <?php echo $color_class; ?>"><?php echo $job_title;?></p>
			                           <?php endif;?>
			                        </a>
			                    </div>
			                </div>
			                <div id="team-<?php echo $team->ID;?>" class="modal">
                         <?php if($image) : ?>
                              <img src="<?php echo $image['sizes']['large'];?>" alt="<?php echo $image['sizes']['medium'];?>"  />
                        <?php endif;?>
			                    <h4><?php echo $team->post_title;?></h4>
			                    <?php if($job_title) : ?>
			                        <p class="job_title"><?php echo $job_title;?></p>
			                    <?php endif;?>
			                    <p><?php echo $team->post_content;?></p>
			                </div>
			            <?php endforeach;?>

			        </div>

				<?php endif;?>

	    	<?php endforeach;?>
	    <?php endif;?>

    </div>
</div>
