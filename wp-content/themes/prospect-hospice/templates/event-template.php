<?php
/*
** Template overide for woocommerce single product (just for event product type)
*/

get_header(); ?>

<?php $event = prospect_get_event_info();
$banner = get_field('event_banner', get_the_ID());
if($banner): ?>
      </div>
    </div>
  </div>
  <div class="event-hero-banner" style="background:url(<?php echo $banner['sizes']['slider']; ?>)">
  	<div class="hero-container">
  		<p class="hero-heading" <?php if($event['color']) echo 'style="background:' . $event['color'] . '"'; ?>><?php echo get_the_title(get_the_ID()); ?></p>
  	</div>
  </div>
<?php else: ?>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="single-event-details">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-8 col-lg-9 event-information">
        <?php
        if($event):
          if($event['location']):  ?>
            <p class="event-location"><span <?php if($event['color']) echo 'style="color:' . $event['color'] . '"'; ?>>Location: </span><?php echo $event['location']; ?></p>
          <?php endif;
          if($event['start']): ?>
            <p class="event-start"><span <?php if($event['color']) echo 'style="color:' . $event['color'] . '"'; ?>>Start: </span><?php echo $event['start']->format('l jS F o') . ' @ ' . $event['start']->format('g:ha'); ?></p>
          <?php endif;
          if($event['end']): ?>
            <p class="event-end"><span <?php if($event['color']) echo 'style="color:' . $event['color'] . '"'; ?>>End: </span><?php echo $event['end']->format('l jS F o') . ' @ ' . $event['end']->format('g:ha'); ?></p>
          <?php endif;
        endif; ?>
        <div class="event-description">
          <?php the_content(); ?>
        </div>
      </div>
      <div class="col-12 col-md-4 col-lg-3">
      </div>
    </div>
  </div>
</div>



<?php get_footer(); ?>
