<?php
/**
 * The template for displaying all single team member
**/

get_header(); ?>

<div class="team-detail">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				
				<div class="imageBg">
					<?php $teamImg = get_field("image", $post->ID);?>
					<img src="<?php echo $teamImg['sizes']['medium'];?>" class="img-responsive" alt="<?php echo $post->post_title;?>" />
				</div>    
			
				<h1><?php echo $post->post_title;?></h1>
				<?php
				$category = '';
				$category = wp_get_post_terms( $post->ID, 'category' );
				$position = get_field("job_title", $post->ID);
				if($position) : 
					$categoryName = $category[0]->name . ' | ' . $position;
				else : 
					$categoryName = $category[0]->name; 
				endif;?>
				<p class="position"><?php echo $categoryName;?></p>
				<div class="social">
					<?php // Social Links
					$facebook_profile =  get_field("facebook_profile", $post->ID);
					$twitter_profile =  get_field("twitter_profile", $post->ID);
					$linkedin_profile =  get_field("linkedin_profile", $post->ID);
					$google_plus_profile =  get_field("google_plus_profile", $post->ID);
					?>

					<?php if($facebook_profile) : ?>
						<a title="View <?php echo $post->post_title;?>'s Facebook Profile" href="<?php echo $facebook_profile;?>" target="_blank"><i class="fa fa-facebook-square"></i></a>
					<?php endif; ?>
					<?php if($twitter_profile) : ?>
						<a title="View <?php echo $post->post_title;?>'s Twitter Profile" href="<?php echo $twitter_profile;?>" target="_blank"><i class="fa fa-twitter-square"></i></a>
					<?php endif; ?>
					<?php if($linkedin_profile) : ?>
						<a title="View <?php echo $post->post_title;?>'s LinkedIn Profile" href="<?php echo $linkedin_profile;?>" target="_blank"><i class="fa fa-linkedin-square"></i></a>
					<?php endif; ?>
					<?php if($google_plus_profile) : ?>
						<a title="View <?php echo $post->post_title;?>'s Google Plus Profile" href="<?php echo $google_plus_profile;?>" target="_blank"><i class="fa fa-google-plus-square"></i></a>
					<?php endif; ?>
					
				</div>

				<div class="content">
					<?php while ( have_posts() ) : the_post();
						the_content();
					endwhile;?>
					<div class="clearfix"></div>
					<a href="/who-we-are/#team-section" class="btn btn-primary" title="back to the <?php echo bloginfo('name');?> team"><i class="fa fa-angle-left"></i> Back to team</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>