<?php
$user = wp_get_current_user();
$users_applications = get_field('applications', 'user_' . $user->ID);
?>
<table id="applications-table">
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
    		$date = new DateTime(strtotime($application['application_date']));
    	?>
		<tr>
	      	<th scope="row"><?php echo $application['job_title']; ?></th>
	      	<td><?php echo $application['job_reference']; ?></td>
	      	<td><?php echo $date->format('d-m-y'); ?></td>
	      	<td><a href="<?php echo $application['job_link']; ?>">Open</a></td>
	    </tr>
	<?php endforeach; ?>
  	</tbody>
</table>



