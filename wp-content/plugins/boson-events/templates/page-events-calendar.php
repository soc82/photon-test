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
<?php echo prospect_events_calendar_query(); ?>
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
      eventRender: function(event, element) {
          element.find('.fc-title').append("<span class='event-location'>" + event.location + "</span>");
      },
      eventLimit: true,
      defaultView: 'month',
      displayEventTime: false,
      eventLimitClick: "popover",
      eventColor: '#FFFFFF',
      handleWindowResize: true,
      editable: false,
      eventTextColor: '#FFFFFF',
      eventRender: function(event, $el) {
        $el.popover({
          title: event.title,
          content: '<span class="tooltip-location"><strong>Location: </strong>' + event.location + '</span>' + '<span class="tooltip-date"><strong>Start: </strong>' + event.startDate + ' - ' + event.startTime + '</span>' + '<span class="tooltip-date"><strong>End: </strong>' + event.endDate  + ' - ' + event.endTime +  '</span>',
          trigger: 'hover',
          placement: 'top',
          container: 'body',
          html: true,
          template: '<div class="popover"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>'
        });
      },
      eventClick: function(event, element) {
        if (event.link) {
            window.open(event.link,"_self");
            return false;
        }
      },
      windowResize: function (view) {
        if(jQuery(window).width() > 550) {
          jQuery('#event-calendar').fullCalendar('changeView', 'month');
        } else {
          jQuery('#event-calendar').fullCalendar('changeView', 'listWeek', { duration: { days: 90 } });
        }
      },
    })
    if(jQuery(window).width() > 550) {
      jQuery('#event-calendar').fullCalendar('changeView', 'month');
    } else {
      jQuery('#event-calendar').fullCalendar('changeView', 'listWeek', { duration: { days: 90 } });
    }
});
</script>
