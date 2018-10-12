<?php
$user = wp_get_current_user();

$args = [
	'post_type'      => 'event-entry',
	'posts_per_page' => -1,
	'meta_query'     => array(
		'relation' => 'OR',
		array(
			'key'   => 'event_user_id',
			'value' => get_current_user_id(),
		),
		array(
			'key'   => 'lead_user_id',
			'value' => get_current_user_id(),
		)
	)
];

$users_events = new WP_Query($args);

?>
<?php if ($users_events->posts) : ?>
  <p>Please note that after the event, this information will be deleted.</p>
    <table id="events-table" class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
        <thead>
        <tr>
            <th scope="col">Event</th>
            <th scope="col">Attendee</th>
            <th scope="col">Complete</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
		<?php foreach ($users_events->posts as $event) : //print_r($event);?>

			<?php
			$event_id = get_post_meta($event->ID, 'event_id', true);
			$event_title = get_the_title($event_id);

			$editable = event_are_attendees_editable($event_id);

			?>

            <tr>
                <th scope="row"><?php echo $event_title; ?></th>
                <td><?php echo get_field('first_name', $event->ID) . ' ' . get_field('last_name', $event->ID) ?></td>
                <td><?php echo is_attendee_complete($event) ? 'Yes' : 'No' ?></td>
                <td>
					<?php if($editable) :?>
                        <a class="woocommerce-button button view" href="/attendee-form/?event_entry=<?php echo $event->ID; ?>">Edit details</a>
					<?php else : ?>
                        Can't edit details as the event is <?php echo days_to_event($event_id);?> days away
					<?php endif;?>
                </td>
            </tr>

		<?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    You aren't attending any events yet.
<?php endif; ?>



