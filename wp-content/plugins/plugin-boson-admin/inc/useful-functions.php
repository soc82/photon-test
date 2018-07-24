<?php

// Useful Functions to be called by devs

/***********************************************
GET CUSTOM POST TYPE
***********************************************/
function get_custom_post_type($title = null, $qty = 99, $meta_key = null, $meta_value = null, $orderby = 'menu_order', $sort = 'ASC', $parent_only = 0){

    if($parent_only == 1) {
        $options = array(
            'numberposts' => $qty,
            'post_type' => $title,
            'post_parent' => 0,
            'orderby' => $orderby,
            'order' => $sort
        );
     } else {
        $options = array(
            'numberposts' => $qty,
            'post_type' => $title,
            'meta_key' => $meta_key,
            'meta_value' => $meta_value,
            'orderby' => $orderby,
            'order' => $sort
        );
    }
  $posts = get_posts($options);

  if($posts) {
    return $posts;
  }
  return false;
}


/***********************************************
GET SUBPAGES
***********************************************/
function wpb_list_child_pages($showParent = true) {
    global $post;
    $parent = "";
    $string = "";

    if ( is_page() && $post->post_parent ) {
        $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
        $parent =  get_the_title($post->post_parent);
        $parentLink = get_the_permalink($post->post_parent);
    } else {
        $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );
        $parent = $post->post_title;
        $parentLink = get_the_permalink($post->ID);
    }

    // Team Page
    $teams = get_post_type_object( 'teams' );

    if ( $childpages ) {
        $string = '<ul class="nav">';
        if($showParent == true) {
            $string .='<li class="parent page_item"><a href="'.$parentLink.'">' . $parent . '</a></li>';
        }
        $string .= $childpages;
        if($teams) $string .='<li class="page_item"><a href="/teams">Our Team</a></li>';
        $string .= '</ul>';
    }

    return $string;
}    
add_shortcode( 'wpb_childpages', 'wpb_list_child_pages' );

/***********************************************
SET ACTIVE STATE
***********************************************/
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}

/***********************************************
YOUTUBE ID
***********************************************/
function get_youtube_id($youtubeUrl) {
  if(isset($youtubeUrl)){
        // Try Embed
        $url = explode("/embed/", $youtubeUrl);
        if(count($url) > 1) {
            $url = explode("?", $url[1]);
            $url = $url[0];
            return $url;
        }
        // Try URL
        $url = explode("/watch?v=", $youtubeUrl);
        if(count($url) > 1) {
            $url = $url[1];
            return $url;
        }
        return null;
    }
}

/***********************************************
PASS PARAMETERS THROUGH URL
***********************************************/
add_filter('query_vars', 'parameter_queryvars' );
function parameter_queryvars( $qvars ) {
    $qvars[] = 'categoryID';
    return $qvars;
}

/***********************************************
CUSTOM EXCERPT
***********************************************/
function excerpt($excerpt, $limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  } 
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}


/***********************************************
GET FEATURED IMAGE URL
***********************************************/
function get_featured_image ($postType = 'page', $size = 'medium') {
    $thumb_id = get_post_thumbnail_id($postType);

    // If no featured image try get page banner
    if(!$thumb_id) :
        $pageBanners = get_field('page_banners', $postType);
        if($pageBanners) :
            return $pageBanners[0]['image']['sizes'][$size];
        else:
            return null;
        endif;
    endif;

    $thumb_url_array = wp_get_attachment_image_src($thumb_id, $size, true);
    return $thumb_url_array[0];
}