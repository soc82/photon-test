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

		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'prospect_event',
				),
			),
		);
		$posts = get_posts($args);


		?>

		<form method="get">
			<table class="form-table">
				<tr>
					<th scope="row"><label>Event</label></th>
					<td>
						<select name="event_id">
							<option>All Events</option>
							<?php foreach ($posts as $post): ?>
								<option value="<?php echo $post->ID ?>"><?php echo $post->post_title ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>

				<tr>
					<th scope="row"><label>From</label></th>
					<td>
						<input type="date" name="from" >
					</td>
				</tr>

				<tr>
					<th scope="row"><label>Until</label></th>
					<td>
						<input type="date" name="until" >
					</td>
				</tr>

				<tr>
					<th scope="row"></th>
					<td>
						<input type="hidden" name="download_report" value="1">
						<input type="submit" value="Export" class="button button-primary button-large">
					</td>
				</tr>

			</table>
		</form>

		<?php


	}

	/**
	 * Converting data to CSV
	 */
	public function generate_csv()
	{
		global $wpdb;

		$where = '';
		if ($_GET['event_id']) {
			$where .= ' AND meta_value = ' . intval($_GET['event_id']);
		}
//		http://localhost:8081/wp-admin/edit.php?event_id=99&from=2018-01-01&until=&download_report=1
		if ($_GET['from']) {
			$where .= " AND post_modified > '" . $_GET['from'] . " 00:00:00'";
		}

		if ($_GET['until']) {
			$where .= " AND post_modified < '" . $_GET['until'] . " 23:59:00'";
		}

		$posts = $wpdb->get_results("SELECT p.* FROM {$wpdb->prefix}posts p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id AND pm.meta_key = 'event_id'  WHERE post_type = 'event-entry' $where ORDER BY ID ASC");
		if (!$posts) return;
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
