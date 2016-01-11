//Document

// Global Variables and Checks
//----------------------------------------------	
	var _windowWidth = $(window).width();
	var _screen = 0; 
	if(_windowWidth > 1023) _screen =1;
	else if(_windowWidth > 800 && _windowWidth < 1024) _screen =2;
	else if(_windowWidth < 801) _screen =3;

	
// Window Resize Function
//---------------------------------------------
$(window).resize(function(e) {
	
    var newWidth = $(window).width();
	var scren = 0;
	if(newWidth > 1023) scren =1;
	else if(newWidth > 800 && newWidth < 1024) scren =2;
	else if(newWidth < 801) scren =3;
	
	if(scren != _screen)
	{
		var karmoraVideo = $('.banner-left iframe');
		if(newWidth > 1023)
		{	
			karmoraVideo.attr('width','640');
			karmoraVideo.attr('height','360');
			karmoraVideo.attr('src','https://www.youtube.com/embed/P2gC8bgNycA');
			_windowWidth = newWidth;
		}
		else
		{
			karmoraVideo.attr('width','560');
			karmoraVideo.attr('height','315');
			karmoraVideo.attr('src','https://www.youtube.com/embed/P2gC8bgNycA');
			_windowWidth = newWidth;
		}
		
		var karmoraVideo = $('.funraising_video iframe');
		if(newWidth > 1023)
		{	
			karmoraVideo.attr('width','640');
			karmoraVideo.attr('height','360');
			karmoraVideo.attr('src','https://www.youtube.com/embed/P2gC8bgNycA');
			_windowWidth = newWidth;
		}
		else
		{
			karmoraVideo.attr('width','460');
			karmoraVideo.attr('height','315');
			karmoraVideo.attr('src','https://www.youtube.com/embed/P2gC8bgNycA');
			_windowWidth = newWidth;
		}
		
	}
	
});// on Resize function ends


// Ready Function Starts
//---------------------------------------------
$(function(){
	var karmoraVideo = $('.banner-left iframe');
		if(_windowWidth > 1023)
		{	
			karmoraVideo.attr('width','640');
			karmoraVideo.attr('height','360');
			karmoraVideo.attr('src','https://www.youtube.com/embed/P2gC8bgNycA?rel=0&autoplay=1');
		}
		else
		{
			karmoraVideo.attr('width','560');
			karmoraVideo.attr('height','315');
			karmoraVideo.attr('src','https://www.youtube.com/embed/P2gC8bgNycA?rel=0&autoplay=1');
		}
});// Ready Function ends

$(function(){
	var karmoraVideo = $('.funraising_video iframe');
		if(_windowWidth > 1023)
		{	
			karmoraVideo.attr('width','640');
			karmoraVideo.attr('height','360');
			karmoraVideo.attr('src','https://www.youtube.com/embed/P2gC8bgNycA?rel=0&autoplay=1');
		}
		else
		{
			karmoraVideo.attr('width','460');
			karmoraVideo.attr('height','315');
			karmoraVideo.attr('src','https://www.youtube.com/embed/P2gC8bgNycA?rel=0&autoplay=1');
		}
});// Ready Function ends
