		<!--event-calendar-->
          <div class="wrapper" style="margin-top:<?=$margin_top;?>;">
              <div class="widget-calendar">
				 <div id="eventCalendarShowDescription" class="eventCalendar-wrap" data-current-month="4" data-current-year="2014"></div>
			  </div>          
		  </div>
          <!--event-calendar-->
<!-- Grid CSS File (only needed for demo page) -->
<!--<link rel="stylesheet" href="jquery/event-calendar/css/paragridma.css">
<!-- Core CSS File. The CSS code needed to make eventCalendar works -->
<link rel="stylesheet" href="<?=site_url();?>assets/js/event-calendar/css/eventCalendar.css">
<!-- Theme CSS file: it makes eventCalendar nicer -->
<link rel="stylesheet" href="<?=site_url();?>assets/js/event-calendar/css/eventCalendar_theme_responsive.css">
<script src="<?=site_url();?>assets/js/event-calendar/js/jquery.eventCalendar.js" type="text/javascript"></script>
<script>
	$(document).ready(function() {
		$("#eventCalendarShowDescription").eventCalendar({
			eventsjson: '<?=base_url();?>assets/js/event-calendar/json/events.json.php',
			onlyOneDescription: false
		});
	});
</script>   
