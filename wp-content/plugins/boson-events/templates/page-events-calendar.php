<?php
/*
* Template Name: Events Calendar
*/

?>

<?php get_header(); ?>
<div class="inner-page-wrapper">
  <div class="container">
    <div class="tile-block block">

      <div class="row">
        <div class="col-12">
          <h1>Featured Events</h2>
        </div>
      </div>

      <div class="featured-events">
        <div class="row no-gutters">

          <?php  
          $args = array(
              'post_type'      => 'product',
              'posts_per_page' => 3,
              'product_cat'    => 'events',
              'meta_key'       => 'featured',
              'meta_value'     => 1
          );
          $loop = new WP_Query( $args );
          while ( $loop->have_posts() ) : $loop->the_post(); 
                global $product;?>
                <div class="col-12 col-sm-4">
                    <a class="image-tile" href="<?php echo get_permalink();?>" style="background-image: url(<?php echo my_get_the_product_thumbnail_url();?>)">
                        <div class="overlay">
                            <?php $event = prospect_get_event_info();?>
                           
                            <h4><?php echo get_the_title();?><br /><span class="date"><?php echo $event['start']->format('jS F o');?></span></h4>

                            <span class="circle-arrow"><i class="far fa-long-arrow-right"></i></span>
                        </div>
                    </a>
                </div>
          <?php endwhile;

        wp_reset_query();?>
      </div>
    </div>
  </div>


  <div class="container">
    <div class="row">
      <div class="col-12">
        <div id="event-calendar"></div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
<script>

function fullCalendar_resize(config) {
  var config = '';
  if(jQuery(window).width() > 550) {
    config = jQuery('#event-calendar').fullCalendar('changeView', 'month');
  } else {
    config = jQuery('#event-calendar').fullCalendar('changeView', 'listMonth', { duration: { days: 90 } }, {});
  }
  return config;
}

jQuery(document).ready(function() {
    jQuery('#event-calendar').fullCalendar({
      header: {
        left:   'title',
        center: 'month listYear',
        right:  'today prev,next',
      },
      weekends: true,
      events: <?php echo prospect_events_calendar_query(); ?>,
      eventLimit: true,
      defaultView: 'month',
      displayEventTime: false,
      eventLimitClick: "popover",
      handleWindowResize: true,
      editable: false,
      eventRender: function(event, $el) {
        console.log($el);
        $el.find('.fc-title').append("<span class='event-location'>" + event.location + "</span>");
        $el.addClass(event.type);
        $el.css('background-color', event.color);
        $el.popover({
          title: event.title,
          content: '<span class="tooltip-location"><strong>Location: </strong>' + event.location + '</span>' + '<span class="tooltip-date"><strong>Start: </strong>' + event.startDate + ' - ' + event.startTime + '</span>' + '<span class="tooltip-date"><strong>End: </strong>' + event.endDate  + ' - ' + event.endTime +  '</span>',
          trigger: 'hover',
          placement: 'top',
          container: 'body',
          html: true,
          template: '<div class="popover ' + event.type + '" style="background:' + event.color + '"><div class="arrow"><div class="arrow-inner" style="border-top-color:' + event.color + '"></div></div><div class="popover-title"></div><div class="popover-content"></div></div>'
        });
      },
      eventClick: function(event, element) {
        if (event.link) {
            window.open(event.link,"_self");
            return false;
        }
      },
      windowResize: function (view) {
        fullCalendar_resize();
      },
    })
    fullCalendar_resize();
});


</script>
