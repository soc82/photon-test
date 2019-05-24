<?php
$url = get_sub_field('iframe_url');
?>

<div class="full-width-content block" >
	<div class="container">
		<div class="row">
			<div class="col-12 ">
				<?php if($url) echo '<div class="iframe-container"><iframe width="100%" height="500" src="' . $url . '"></iframe></div>'; ?>
			</div>
		</div>
	</div>
</div>
