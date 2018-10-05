<?php

class CSVExport
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		if(isset($_GET['download_report']))
		{
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private", false);
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"report.csv\";" );
			header("Content-Transfer-Encoding: binary");

			$this->generate_csv();
			exit;
		}

// Add extra menu items for admins
		add_action('admin_menu', array($this, 'admin_menu'));

// Create end-points
		add_filter('query_vars', array($this, 'query_vars'));
		add_action('parse_request', array($this, 'parse_request'));
	}

	/**
	 * Add extra menu items for admins
	 */
	public function admin_menu()
	{
		add_submenu_page('edit.php?post_type=event-entry', 'Export', 'Export', 'manage_options', 'download_report', array($this, 'download_report'));
	}

	/**
	 * Allow for custom query variables
	 */
	public function query_vars($query_vars)
	{
		$query_vars[] = 'download_report';
		return $query_vars;
	}

	/**
	 * Parse the request
	 */
	public function parse_request(&$wp)
	{
		if(array_key_exists('download_report', $wp->query_vars))
		{
			$this->download_report();
			exit;
		}
	}

	/**
	 * Download report
	 */
	public function download_report()
	{
		echo '<div class="wrap">';
		echo '<div id="icon-tools" class="icon32"></div>';
		echo '<h2>Export Event Entries</h2>';


		echo '<p>Export the event entries</p>';

		echo '<a href="' . $_SERVER['REQUEST_URI'] . '&download_report=1">Download</a>';
	}

	/**
	 * Converting data to CSV
	 */
	public function generate_csv()
	{
		global $wpdb;

		$posts = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'event-entry' ORDER BY ID DESC");
		$ids = array_map(function ($el) { return $el->ID; }, $posts);
		$post_keys = array_keys(get_object_vars($posts[0]));

		$meta_keys = $wpdb->get_col("SELECT DISTINCT meta_key FROM {$wpdb->prefix}postmeta WHERE post_id IN (" . implode(',', $ids) . ") AND meta_key NOT LIKE '\_%' ORDER BY post_id DESC" );


		$export_keys = array_merge($post_keys, $meta_keys);

		$output = fopen('php://temp', 'w+');
		fputcsv($output, $export_keys);

		foreach ($posts as $post) {
			$data = array_values(get_object_vars($post));
			$meta = $wpdb->get_results("SELECT meta_key, meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = " . $post->ID . " AND meta_key IN ('" . implode("','", $meta_keys) . "')");
			$keyed_meta = [];
			foreach ($meta as $v) {
				$keyed_meta[$v->meta_key] = $v->meta_value;
			}

			foreach ($meta_keys as $k) {
				$val = $keyed_meta[$k] ?: '';
				switch ($k) {
					case 'event_id':
						$val = get_the_title($val);
						break;


				}
				$data[] = $val;

			}

			fputcsv($output, $data);
		}

		rewind($output);
		fpassthru($output);
		fclose($output);

	}
}

// Instantiate a singleton of this plugin
$csvExport = new CSVExport();
