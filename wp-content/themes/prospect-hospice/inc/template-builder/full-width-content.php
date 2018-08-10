<?php
$heading = get_sub_field('heading');
$content = get_sub_field('content');
?>

<div class="full-wdith-content block" >
	<div class="container">
		<div class="row">
			<div class="col-12 ">
					<?php if($heading) echo '<h3>' . $heading . '</h3>' ?>
					<?php if($content) echo '<p>' . $content . '</p>'; ?>
			</div>
		</div>
	</div>
</div>
