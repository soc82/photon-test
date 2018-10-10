<?php
$image = (get_sub_field('background_image') ? get_sub_field('background_image') : get_field('hero_banner_image'));
$heading = (get_sub_field('heading') ? get_sub_field('heading') : get_field('hero_banner_heading'));
$second_heading = (get_sub_field('second_heading') ? get_sub_field('second_heading') : get_field('hero_banner_second_heading'));
$description = (get_sub_field('description') ? get_sub_field('description') : get_field('hero_banner_description'));
$link_url = (get_sub_field('link_url') ? get_sub_field('link_url') : get_field('hero_banner_link_url'));
?>

<?php if(isset($image)):?>
    <div class="hero-banner block" <?php if($image) echo 'style="background-image:url(' . $image . ');"'; ?>>
        <div class="overlay"></div>
        
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

        <?php if($link_url) : ?>
            <a class="btn-circle" href="<?php echo $link_url;?>"><i class="fal fa-arrow-right"></i></a>
        <?php endif; ?>

    </div>
<?php endif;?>