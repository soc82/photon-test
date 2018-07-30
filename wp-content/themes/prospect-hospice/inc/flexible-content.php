<?php
if( have_rows('template_builder') ):

		while ( have_rows('template_builder') ) : the_row();
			// Make sure the layout name is in the correct format
			$layout = str_replace( '_', '-', get_row_layout());

			$template_path = 'inc/template-builder/' . $layout;

			get_template_part($template_path);

		endwhile;

endif;
?>
