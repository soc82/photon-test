<?php
/*
Plugin Name: Simple URLs
Plugin URI: http://www.studiopress.com/plugins/simple-urls

Description: Simple URLs is a complete URL management system that allows you create, manage, and track outbound links from your site by using custom post types and 301 redirects.

Author: Nathan Rice
Author URI: http://www.nathanrice.net/

Version: 0.9.7

Text Domain: simple-urls
Domain Path: /languages

License: GNU General Public License v2.0 (or later)
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

class SimpleURLs {

	// Constructor
	function __construct() {

		//register_activation_hook( __FILE__, 'flush_rewrite_rules' );

		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'columns_data' ) );
		add_filter( 'manage_edit-surl_columns', array( $this, 'columns_filter' ) );

		add_filter( 'post_updated_messages', array( $this, 'updated_message' ) );

		add_action( 'admin_menu', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'meta_box_save' ), 1, 2 );
		add_action( 'template_redirect', array( $this, 'count_and_redirect' ) );

	}

	function load_textdomain() {
		load_plugin_textdomain( 'simple-urls', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}

	function register_post_type() {

		$slug = 'surl';

		$labels = array(
			'name'               => __( 'Simple URLs', 'simple-urls' ),
			'singular_name'      => __( 'URL', 'simple-urls' ),
			'add_new'            => __( 'Add New', 'simple-urls' ),
			'add_new_item'       => __( 'Add New URL', 'simple-urls' ),
			'edit'               => __( 'Edit', 'simple-urls' ),
			'edit_item'          => __( 'Edit URL', 'simple-urls' ),
			'new_item'           => __( 'New URL', 'simple-urls' ),
			'view'               => __( 'View URL', 'simple-urls' ),
			'view_item'          => __( 'View URL', 'simple-urls' ),
			'search_items'       => __( 'Search URL', 'simple-urls' ),
			'not_found'          => __( 'No URLs found', 'simple-urls' ),
			'not_found_in_trash' => __( 'No URLs found in Trash', 'simple-urls' ),
			'messages'           => array(
				 0 => '', // Unused. Messages start at index 1.
				 1 => __( 'URL updated. <a href="%s">View URL</a>', 'simple-urls' ),
				 2 => __( 'Custom field updated.', 'simple-urls' ),
				 3 => __( 'Custom field deleted.', 'simple-urls' ),
				 4 => __( 'URL updated.', 'simple-urls' ),
				/* translators: %s: date and time of the revision */
				 5 => isset( $_GET['revision'] ) ? sprintf( __( 'Post restored to revision from %s', 'simple-urls' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				 6 => __( 'URL updated. <a href="%s">View URL</a>', 'simple-urls' ),
				 7 => __( 'URL saved.', 'simple-urls' ),
				 8 => __( 'URL submitted.', 'simple-urls' ),
				 9 => __( 'URL scheduled', 'simple-urls' ),
				10 => __( 'URL draft updated.', 'simple-urls' ),
			),
		);

		$labels = apply_filters( 'simple_urls_cpt_labels', $labels );

		$rewrite_slug = apply_filters( 'simple_urls_slug', 'go' );

		register_post_type( $slug,
			array(
				'labels'        => $labels,
				'public'        => true,
				'query_var'     => true,
				'menu_position' => 20,
				'supports'      => array( 'title' ),
				'rewrite'       => array( 'slug' => $rewrite_slug, 'with_front' => false ),
			)
		);

	}

	function columns_filter( $columns ) {

		$columns = array(
			'cb'        => '<input type="checkbox" />',
			'title'     => __( 'Title', 'simple-urls' ),
			'url'       => __( 'Redirect to', 'simple-urls' ),
			'permalink' => __( 'Permalink', 'simple-urls' ),
			'clicks'    => __( 'Clicks', 'simple-urls' ),
		);

		return $columns;

	}

	function columns_data( $column ) {

		global $post;

		$url   = get_post_meta( $post->ID, '_surl_redirect', true );
		$count = get_post_meta( $post->ID, '_surl_count', true );

		if ( 'url' == $column ) {
			echo make_clickable( esc_url( $url ? $url : '' ) );
		}
		elseif ( 'permalink' == $column ) {
			echo make_clickable( get_permalink() );
		}
		elseif ( 'clicks' == $column ) {
			echo esc_html( $count ? $count : 0 );
		}

	}

	function updated_message( $messages ) {

		$surl_object = get_post_type_object( 'surl' );
		$messages['surl'] = $surl_object->labels->messages;

		if ( $permalink = get_permalink() ) {
			foreach ( $messages['surl'] as $id => $message ) {
				$messages['surl'][ $id ] = sprintf( $message, $permalink );
			}
		}

		return $messages;

	}

	function add_meta_box() {
		add_meta_box( 'surl', __( 'URL Information', 'simple-urls' ), array( $this, 'meta_box' ), 'surl', 'normal', 'high' );
	}

	function meta_box() {

		global $post;

		printf( '<input type="hidden" name="_surl_nonce" value="%s" />', wp_create_nonce( plugin_basename(__FILE__) ) );

		printf( '<p><label for="%s">%s</label></p>', '_surl_redirect', __( 'Redirect URI', 'simple-urls' ) );
		printf( '<p><input style="%s" type="text" name="%s" id="%s" value="%s" /></p>', 'width: 99%;', '_surl_redirect', '_surl_redirect', esc_attr( get_post_meta( $post->ID, '_surl_redirect', true ) ) );
		printf( '<p><span class="description">%s</span></p>', __( 'This is the URL that the Redirect Link you create on this page will redirect to when accessed in a web browser.', 'simple-urls' ) );

		$count = isset( $post->ID ) ? get_post_meta($post->ID, '_surl_count', true) : 0;
		echo '<p>' . sprintf( __( 'This URL has been accessed %d times', 'simple-urls' ), esc_attr( $count ) ) . '</p>';

	}

	function meta_box_save( $post_id, $post ) {

		$key = '_surl_redirect';

		//	verify the nonce
		if ( ! isset( $_POST['_surl_nonce'] ) || ! wp_verify_nonce( $_POST['_surl_nonce'], plugin_basename( __FILE__ ) ) ) {
			return;
		}

		//	don't try to save the data under autosave, ajax, or future post.
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
		if ( defined('DOING_AJAX') && DOING_AJAX ) return;
		if ( defined('DOING_CRON') && DOING_CRON ) return;

		//	is the user allowed to edit the URL?
		if ( ! current_user_can( 'edit_posts' ) || 'surl' != $post->post_type )
			return;

		$value = isset( $_POST[ $key ] ) ? $_POST[ $key ] : '';

		if ( $value ) {
			//	save/update
			update_post_meta( $post->ID, $key, $value );
		} else {
			//	delete if blank
			delete_post_meta( $post->ID, $key );
		}

	}


	function count_and_redirect() {

		if ( ! is_singular( 'surl' ) ) {
			return;
		}

		global $wp_query;

		// Update the count
		$count = isset( $wp_query->post->ID ) ? get_post_meta( $wp_query->post->ID, '_surl_count', true ) : 0;
		update_post_meta( $wp_query->post->ID, '_surl_count', $count + 1 );

		// Handle the redirect
		$redirect = isset( $wp_query->post->ID ) ? get_post_meta( $wp_query->post->ID, '_surl_redirect', true ) : '';

		/**
		 * Filter the redirect URL.
		 *
		 * @since 0.9.5
		 *
		 * @param string  $redirect The URL to redirect to.
		 * @param int  $var The current click count.
		 */
		$redirect = apply_filters( 'simple_urls_redirect_url', $redirect, $count );

		/**
		 * Action hook that fires before the redirect.
		 *
		 * @since 0.9.5
		 *
		 * @param string  $redirect The URL to redirect to.
		 * @param int  $var The current click count.
		 */
		do_action( 'simple_urls_redirect', $redirect, $count );

		if ( ! empty( $redirect ) ) {
			wp_redirect( esc_url_raw( $redirect ), 301);
			exit;
		}
		else {
			wp_redirect( home_url(), 302 );
			exit;
		}

	}

}

new SimpleURLs;
