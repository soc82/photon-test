<?php
$user = wp_get_current_user();

?>
<?php if ($users_applications) : ?>
  <table id="events-table">
    	<thead>
      	<tr>
        		<th scope="col">Job Title</th>
        		<th scope="col">Reference</th>
        		<th scope="col">Application Date</th>
        		<th scope="col">Job Spec</th>
      	</tr>
    	</thead>
    	<tbody>
      <?php foreach ($users_applications as $application) : ?>
      	<?php
      		$date = date('d-m-y', $application['application_date']);
      	?>
  		  <tr>
  	      	<th scope="row"><?php echo $application['job_title']; ?></th>
  	      	<td><?php echo $application['job_reference']; ?></td>
  	      	<td><?php echo $date; ?></td>
  	      	<td><a href="<?php echo $application['job_link']; ?>">Open</a></td>
  	    </tr>
  	<?php endforeach; ?>
    	</tbody>
  </table>
<?php else: ?>
    You aren't attending any events yet.
<?php endif; ?>



