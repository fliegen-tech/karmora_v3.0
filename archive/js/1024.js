// JavaScript Document
//console.log('wide = '+$(window).width());
	

//function DOCUMENT READY ---starts
$(document).ready(function() {

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
