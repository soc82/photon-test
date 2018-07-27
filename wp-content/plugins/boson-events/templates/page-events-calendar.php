<?php
/*
* Template Name: Events Calendar
*/
?>

<?php get_header(); ?>
<div class="inner-page-wrapper">
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
      //defaultView: function getCalendarView(),
      displayEventTime: false,
      eventLimitClick: "popover",
      eventColor: '#FFFFFF',
      eventTextColor: '#FFFFFF',
      eventBackgroundColor: '$primaryColor',
      eventClick: function(event, element) {
        if (event.link) {
            window.open(event.link,"_self");
            return false;
        }
      },
    })
});
</script>
