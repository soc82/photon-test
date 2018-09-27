<div class="hero-banner block" <?php if(isset($image)) echo 'style="background-image:url(' . $image . ');"'; ?>>
    <div class="overlay"></div>
    <?php if(isset($heading) || isset($second_heading)): ?>
        <div class="container hero-banner-content">
            <div class="row">
                <div class="col-12">
                    <?php if ($second_heading) : ?>
                        <h2 class="color-yellow"><?php echo $second_heading; ?></h2>
                    <?php endif; ?>
                    <?php if($heading) : ?>
                        <h1><?php echo $heading; ?></h1>
                    <?php endif; ?>
                    <?php if($description) : ?>
                        <p><?php echo $description; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if(isset($link_url)) : ?>
        <a class="btn-circle" href="<?php echo $link_url;?>"><i class="fal fa-arrow-right"></i></a>
    <?php endif; ?>

</div>
