<script src="<?php echo base_url('public/admin'); ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('public/admin'); ?>/vendor/plugins/datepicker/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="<?php echo base_url('public/admin'); ?>/vendor/plugins/formswitch/js/bootstrap-switch.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url('public/admin'); ?>/vendor/plugins/jquerymask/jquery.maskedinput.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url('public/admin'); ?>/vendor/plugins/tags/tagmanager.js"></script> 

<!-- Theme Javascript --> 
<script type="text/javascript" src="<?php echo base_url('public/admin'); ?>/js/uniform.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url('public/admin'); ?>/js/main.js"></script>
<script type="text/javascript" src="<?php echo base_url('public/admin'); ?>/js/custom.js"></script> 
<script type="text/javascript">
    jQuery(document).ready(function() {

        // Init Theme Core 	  
        Core.init();

        // Create an example page animation. Really
        // not suitable for production enviroments
        var headerAnimate = setTimeout(function() {
            // Animate Header from Top
            $('header').css("display", "block").addClass('animated bounceInDown');
        }, 300);

        // Add an aditional delay to hide the loading spinner
        // and animate body content from bottom of page
        var bodyAnimate = setTimeout(function() {
            // hide spinner
            $('#page-loader').css("display", "none");

            // show body and animate from bottom. At end of animation 
            // add several css properties because the animation will bug 
            // existing psuedo backgrounds(:after)
            $('#main').css("display", "block").addClass('animated animated-short bounceInUp').one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function() {
                $('body').css({background: "#FFFFFF", overflow: "visible"});
                $('#content, #sidebar').addClass('refresh');
                // Init sparkline animations
                
            });
        }, 1150);



    });
</script>
<script type="text/javascript">
 jQuery(document).ready(function() {

	 // Init Theme Core
	// Core.init();

	 //Init jquery Date Picker
	 $('.datepicker').datepicker()
	 $('.datepicker2').datepicker()
	 
	 //Init jquery Date Range Picker
	 $('input[name="daterange"]').daterangepicker();
	 
	 //Init jquery Color Picker
	 $('.colorpicker').colorpicker() 
	 $('.rgbapicker').colorpicker() 
	 
	 //Init jquery Time Picker
	 $('.timepicker').timepicker();
	  
	 //Init jquery Tags Manager 
	 $(".tm-input").tagsManager({
        tagsContainer: '.tag-container',
		prefilled: ["Miley Cyrus", "Apple", "Wow This is a really Long tag", "Na uh"],
		tagClass: 'tm-tag-info',
     });

	 //Init jquery spinner init - default  
	 $(".checkbox").uniform();
 	 $(".radio").uniform();

	//Init jquery spinner init - default
	$("#chosen-list1").chosen();
	$("#chosen-list2").chosen(); 
	  
	//Init jquery spinner init - default
	$("#spinner1").spinner();
	
	//Init jquery spinner init - currency 
	$("#spinner2").spinner({
      min: 5,
      max: 2500,
      step: 25,
      start: 1000,
      //numberFormat: "C"
    });
	
	//Init jquery spinner init - decimal  
	$( "#spinner3" ).spinner({
      step: 0.01,
      numberFormat: "n"
    });
	
	//Init jquery time spinner
    $.widget( "ui.timespinner", $.ui.spinner, {
		options: {
		  // seconds
		  step: 60 * 1000,
		  // hours
		  page: 60
		},
		_parse: function( value ) {
		  if ( typeof value === "string" ) {
			// already a timestamp
			if ( Number( value ) == value ) {
			  return Number( value );
			}
			return +Globalize.parseDate( value );
		  }
		  return value;
		},
	 
		_format: function( value ) {
		  return Globalize.format( new Date(value), "t" );
		}
	  });
    $( "#spinner4" ).timespinner();

	//Init jquery masked inputs
	$('.date').mask('99/99/9999');
	$('.time').mask('99:99:99');
	$('.date_time').mask('99/99/9999 99:99:99');
	$('.zip').mask('99999-999');
	$('.phone').mask('(999) 999-9999');
	$('.phoneext').mask("(999) 999-9999 x99999");
	$(".money").mask("999,999,999.999"); 
	$(".product").mask("999.999.999.999"); 
	$(".tin").mask("99-9999999");
	$(".ssn").mask("999-99-9999");
	$(".ip").mask("9ZZ.9ZZ.9ZZ.9ZZ");
	$(".eyescript").mask("~9.99 ~9.99 999");
	$(".custom").mask("9.99.999.9999");
	
});
</script>
</body>
</html>
