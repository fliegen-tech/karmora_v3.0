// JavaScript Document
//console.log('wide = '+$(window).width());


//function DOCUMENT READY ---starts
$(document).ready(function() { 

/*------Archieves show hide-------*/
$('.filter_archives').click(function(e) {
	 if( $('.archievelisting').is(':visible') )
	 { 
	 	$('.archievelisting').stop().slideUp('fast');
		$(this).html('ARCHIVES &#9660;').css('border','#D4D4D4 1px solid');		
	 }
	 else
	 {
		$('.archievelisting').stop().slideDown('fast');
		$(this).html('ARCHIVES &#9650;').css('border-bottom','none');
	 }
});
	 


/*------Archieves show hide-------*/
$('.share_dd').click(function(e) {
	 if( $('.share_div').is(':visible') )
	 { 
	 	$('.share_div').stop().slideUp('fast');
		$(this).html('<img src="add.png"> Share your wish list').css('border','none');		
	 }
	 else
	 {
		$('.share_div').stop().slideDown('fast');
		$(this).html('<img src="sub.png">  Share your wish list');
		$('.share_div').css('border-top','1px solid #ccc');
	 }
});
	
});//Ready function ends
