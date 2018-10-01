<?php
$user = wp_get_current_user();

$args = [
  'post_type' => 'event-entry',
  'posts_per_page' => -1,
  'meta_key' => 'user_id',
  'meta_value' => get_current_user_id(),
];

$users_events = new WP_Query($args);

?>
<?php if ($users_events->posts) : ?>
  <table id="events-table">
    	<thead>
      	<tr>
        		<th scope="col">Event</th>
        		<th scope="col">Actions</th>
      	</tr>
    	</thead>
    	<tbody>
      <?php foreach ($users_events->posts as $event) : ?>
        <?php 
        $event_id = get_post_meta($event->ID, 'event_id', true);
        $event_title = get_the_title($event_id);
        ?>
  		  <tr>
  	      	<th scope="row"><?php echo $event_title; ?></th>
  	      	<td><a href="/attendee-form/?event_entry=<?php echo $event->ID; ?>">Complete attendee details</a></td>
  	    </tr>
  	<?php endforeach; ?>
    	</tbody>
  </table>
<?php else: ?>
    You aren't attending any events yet.
<?php endif; ?>



