<?php
/*
Template Name: News Template
*/
get_header(); ?>

<?php get_template_part('inc/template-builder/hero-banner'); ?>

<div class="inner-page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="intro">

                    <?php
                      // Start the loop.
                      while ( have_posts() ) : the_post();

                        // Include the page content template.
                        get_template_part( 'template-parts/content', 'page' );

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) {
                          comments_template();
                        }

                      // End of the loop.
                      endwhile;
                      ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- News -->
<?php $query_args = array(
    'post_type' => 'post',
    'posts_per_page'  => -1,
    'order' => 'DESC',
    'orderby' => 'date',
    'posts_per_page' => 6,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1
);
$items = new WP_Query($query_args);

if ( $items->posts ) : ?>
    <div class="grid-overlap">
        <div class="row no-gutters">

            <?php // Start the loop.
            while ( $items->have_posts()) : $items->the_post();

                get_template_part( 'template-parts/content', 'posts' );

            // End the loop.
            endwhile; ?>
        </div>
    </div>

    

    <?php // Pagination
    $total_pages = $items->max_num_pages;
    if ($total_pages > 1) : ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="pagination">
                        <?php $current_page = max(1, get_query_var('paged'));
                        echo paginate_links(array(
                            'base' => get_pagenum_link(1) . '%_%',
                            'format' => '/page/%#%',
                            'current' => $current_page,
                            'total' => $total_pages,
                            'prev_text'    => __('« prev'),
                            'next_text'    => __('next »'),
                        ));?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
    <?php wp_reset_postdata();?>

<?php // If no content, include the "No posts found" template.
else :
    get_template_part( 'template-parts/content', 'none' );

endif;?>

<?php get_footer(); ?>