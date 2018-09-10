<div class="col-12 col-md-6 col-lg-4">
    <div class="item">  
        <a href="<?php echo the_permalink();?>" title="<?php echo $post->post_title;?>">
            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );?>
            <?php if($image) : ?>
                <div class="image-wrapper">
                    <div class="image" style="background-image:url(<?php echo $image[0];?>)"></div>
                </div>
            <?php endif;?>
            <div class="caption">
                <h2><?php echo $post->post_title;?></h2>
                <p><?php echo the_date('d F Y');?></p>
            </div>
        </a>
    </div>
</div>