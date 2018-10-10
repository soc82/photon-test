<?php
/*
Template Name: Team Contact Page
*/
get_header(); ?>

<?php $contact_details = get_field('contact_details');
$related_team = get_field('related_team'); ?>

<div class="inner-page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-7">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="page-header">
                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                    </div>
                    <div class="entry-content">
                        <?php the_content();?>

                        <?php $form_id = get_field('form_id');
                        if($form_id) : ?>

                            <?php if(isset($_GET['course'])) {
                                $course = $_GET['course'];
                            } else {
                                $course = 'N/A';
                            }?>

                            <?php echo do_shortcode('[gravityform field_values=’course='.$course.' id='.$form_id.' title=false description=false ajax=true]');?>
                        <?php endif;?>
                    </div>
                </article>
            </div>

            <div class="col-12 offset-lg-1 col-lg-4">
                <div class="sidebar-sub-menu bg-yellow">
                    <div class="sidebar-inner">
                        <?php if ($contact_details) : ?>
                            <h3><?php echo $contact_details; ?></h3>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if($related_team) : ?>
            <div class="block">
                <div class="row">
                    <div class="col-12">
                        <h3>Our Education Team</h3>
                    </div>
                </div>
                <div class="row">
                    <?php foreach($related_team as $team) : ?>
                        <div class="col-12 col-md-6 col-lg-3">
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
        <?php endif;?>

    </div>
</div>

<?php get_footer(); ?>
