<?php $related_team = get_sub_field('related_team');?>
<?php $background_colour = get_sub_field('background_colour');?>
<?php $heading = get_sub_field('heading');?>
<?php $intro = get_sub_field('intro');
$color_class = prospect_dark_colour_class(); ?>
<?php if($related_team) : ?>
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
	        <div class="row">
	            <?php foreach($related_team as $team) : ?>
	                <div class="col-12 col-md-6 col-lg-4">
	                    <?php //print_r($team);?>
	                    <div class="team">
	                        <a href="#team-<?php echo $team->ID;?>" rel="modal:open">
	                            <?php $image = get_field('image', $team->ID);
	                            if($image) : ?>
	                                <div class="image-wrapper">
	                                    <div class="image" style="background-image:url(<?php echo $image['sizes']['large'];?>);"></div>
	                                </div>
	                            <?php endif;?>
	                           <h4><?php echo $team->post_title;?></h4>
	                           <?php $job_title = get_field('job_title', $team->ID);
	                            if($job_title) : ?>
	                               <p class="job_title"><?php echo $job_title;?></p>
	                           <?php endif;?>
	                        </a>
	                    </div>
	                </div>
	                <div id="team-<?php echo $team->ID;?>" class="modal">
	                    <h4><?php echo $team->post_title;?></h4>
	                    <?php $job_title = get_field('job_title', $team->ID);
	                    if($job_title) : ?>
	                        <p class="job_title"><?php echo $job_title;?></p>
	                    <?php endif;?>
	                    <p><?php echo $team->post_content;?></p>
	                    <p><a href="#" rel="modal:close">Close</a></p>
	                </div>
	            <?php endforeach;?>
	        </div>
	    </div>
	</div>
<?php endif;?>
