<?php


class prospect_desktop_walker extends Walker_Nav_Menu {

	function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class='sub-menu'><div class='container-fluid'><div class='row'>\n";
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</div></div></ul>\n";
	}

  function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
    	$object = $item->object;
    	$type = $item->type;
    	$title = $item->title;
    	$description = $item->description;
    	$permalink = $item->url;

			$content_menu_item = get_field('menu_content', $item);
			$heading = get_field('heading', $item);
			$content = get_field('content', $item);


			if($content_menu_item) {
				$output .= '<div class="col-md-6 mega-menu-content-wrapper">';
				if($heading) $output .= '<h6>' . $heading . '</h6>';
				if($content) $output .= '<p>' . $content . '</p>';
			}

      $output .= "<li class='" .  implode(" ", $item->classes) . "'>";


      //Add SPAN if no Permalink
      if( $permalink && $permalink != '#' ) {
      	$output .= '<a href="' . $permalink . '">';
      } else {
      	$output .= '<span>';
      }

      $output .= $title;
      if( $description != '' && $depth == 0 ) {
      	$output .= '<small class="description">' . $description . '</small>';
      }
      if( $permalink && $permalink != '#' ) {
      	$output .= '</a>';
      } else {
      	$output .= '</span>';
      }

			if($content_menu_item) {
				$output .= '</div><div class="col-md-6 mega-menu-links-wrapper">';
			}
			
    }

}


 ?>
