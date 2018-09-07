<?php
$heading = get_sub_field('heading', $post->ID);
$content = get_sub_field('content', $post->ID);
$background_colour = get_sub_field('background_colour', $post->ID);
$color_class = prospect_dark_colour_class();

?>

<div class="content-with-sub-menu block" >
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-8">
				<?php if($heading) echo '<h3>' . $heading . '</h3>' ?>
				<?php if($content) echo '<p>' . $content . '</p>'; ?>
			</div>
			<style>
				.sidebar-sub-menu:after {
					background-color: <?php echo $background_colour; ?> !important;
				}
			</style>
			<div class="col-12 col-md-4">
				<div class="sidebar-sub-menu" <?php if($background_colour) echo 'style="background-color:' . $background_colour . '"'; ?>>
					<div class="sidebar-inner">
						<?php
							$parent = get_post(get_the_ID())->post_parent;
							if($parent){
								$args = array(
									'post_type'	=> 'page',
									'posts_per_page'	=> -1,
									'post_parent'	=>	$parent,
								);
								$page_query = new WP_Query($args);
								if($page_query->have_posts()):
									echo '<h3 class="' . $color_class . '">' . get_the_title($parent) . '</h3>';
									echo '<ul>';
										while($page_query->have_posts()): $page_query->the_post();
											echo '<li class="' . $color_class . '" ><a href="' . get_permalink(get_the_ID()) . '" class="' . $color_class . '">' . get_the_title() . '</a></li>';
										endwhile;
										wp_reset_postdata();
									echo '</ul>';
								endif;
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
