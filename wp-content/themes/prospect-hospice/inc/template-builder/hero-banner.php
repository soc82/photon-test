<?php
$image = get_sub_field('background_image');
$heading = get_sub_field('heading');
$second_heading = get_sub_field('second_heading');
?>
<div class="hero-banner block"  <?php if($image) echo 'style="background:url(' . $image . ');"'; ?>>
    <?php if($heading || $second_heading): ?>
        <div class="container hero-banner-content">
            <div class="row">
                <div class="col-12">
                    <?php if($heading) : ?>
                        <h2><?php echo $heading; ?></h2>
                    <?php endif; ?>
                    <?php if ($second_heading) : ?>
                        <h1><?php echo $second_heading; ?></h1>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif;?>
</div>
