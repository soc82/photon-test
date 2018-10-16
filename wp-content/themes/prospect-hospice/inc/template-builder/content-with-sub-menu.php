<?php
$heading = get_sub_field('heading', $post->ID);
$content = get_sub_field('content', $post->ID);
$background_colour = get_sub_field('background_colour', $post->ID);
?>

<div class="content-with-sub-menu block" >
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-8">
				<?php if($heading) echo '<h3>' . $heading . '</h3>' ?>
				<?php if($content) echo '<p>' . $content . '</p>'; ?>
			</div>
			<div class="col-12 col-md-4">
				<div class="sidebar-sub-menu" >
					<div class="sidebar-inner">
						<?php
							$parent = get_post(get_the_ID())->post_parent;
							if($parent){
								$args = array(
									'post_type'	=> 'page',
									'posts_per_page'	=> -1,
									'post_parent'	=>	$parent,
									'orderby'	=> 'name',
									'order'	=> 'ASC',
								);
								$page_query = new WP_Query($args);
								if($page_query->have_posts()) :
									$parentURL = get_the_permalink($parent);
									echo '<a href="' . $parentURL . '"><h3>' . get_the_title($parent) . '</h3></a>';
									echo '<ul>';
										while($page_query->have_posts()): $page_query->the_post();
											echo '<li ><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></li>';
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
