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

                    // End of the loop.
                    endwhile;
                    ?>

                    <!-- Filter -->
                    <?php $terms = $terms = get_terms( array(
                        'taxonomy' => 'category',
                        'hide_empty' => false,
                    )); ?>

                    <div class="filter">        
                        <form method="get" action="">
                            <div class="dropdown">
                                <select name="category" class="autosubmit-field" >
                                    <option value="">Filter news by ...</option>
                                    <?php foreach($terms as $term) : ?>
                                        <?php if($term->name != 'Uncategorized') : ?>
                                            <option <?php if(!empty($_GET['category']) && $_GET['category'] == sanitize_title($term->name)) echo 'selected';?> data-filter=".<?php echo sanitize_title($term->name);?>" value="<?php echo sanitize_title($term->name);?>"><?php echo $term->name;?></option>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </form>
                    </div>
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
    'posts_per_page' => 20,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
);

// If category is passed, add to query
if(!empty($_GET['category'])) :
    $query_args['tax_query'] = [[
        'taxonomy' => 'category',
        'field'    => 'slug',
        'terms'    => $_GET['category'],
    ]];
endif;
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