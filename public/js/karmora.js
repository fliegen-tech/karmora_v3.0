$(document).ready(function() {
	
	// Featured Store Slider
	$('#Carousel').carousel({
		interval: 0
	})
	
	// News Fade in out
	$("#slideshow > i:gt(0)").hide();
	setInterval(function () {
		$('#slideshow > i:first')
			.fadeOut(900)
			.next()
			.fadeIn(1000)
			.end()
			.appendTo('#slideshow');
	}, 3000);

});

