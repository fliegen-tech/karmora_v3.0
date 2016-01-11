// JavaScript Document
/*

/*------------	Featured Companies Home page slider start----------------*/
var slider_id = [];
 (function($){
		$.fn.horizontalSlider = function(){
			var timeStamp = 8000;
			var $this = $(this);
			var left = 0;
			var current = 1;
			var products = $this.children().children().size();
			
			var win = $(window).width();
			var winFig, liWidth = 0;
			if(win < 801) {
				winFig = 2;
				liWidth = 170;
			}
			else if(win > 800 && win < 1024) {
				winFig = 2;
				liWidth = 170;
			}
			else if(win > 1023) {
				winFig = 5;
				liWidth = 160;
			}
			
			var ulWidth = liWidth*winFig;
			var atTime = parseInt(products/winFig) ;
			$this.find('ul').css('width', products*liWidth);
			var last = (products*liWidth) - ulWidth;
			//alert(last);
			
			slider_id.push( setInterval(function(){showNext()},timeStamp) );
			
			function showNext(){
				
				if( atTime != current) {
					left = left - ulWidth;
					current++;
				}
				else {
					left = 0;
					current = 1;
				}
				$($this.children()).stop(true,false,true).animate({left:left});
				
				
			}
			
			function showPrev(){
				//debugger;
				if( current == 1) {
					//alert('1');
					left = -last;
					current= atTime;
				}
				else {
					//alert('2');
					left = left + ulWidth;
					current--;
				}
				$($this.children()).stop(true,false,true).animate({left:left});
			};
			
			$('#featuredNext').click(function(e) {
                window.clearInterval(slider_id.pop());
				showNext();
				slider_id.push( setInterval(function(){showNext()},timeStamp) );
            });
			
			$('#featuredPrev').click(function(e) {
                window.clearInterval(slider_id.pop());
				showPrev();
				slider_id.push( setInterval(function(){showNext()},timeStamp) );
            });
			
			$(this).mouseenter(function(){
				window.clearInterval(slider_id.pop());
			});
			$(this).mouseleave(function(){
				slider_id.push( setInterval(function(){showNext()},timeStamp) );
			});
			
			
			$(window).resize(function(e) {
				var resiz = $(window).width();
				if(win < 801) {
					if(resiz > 800 && resiz < 1024) { 
						liWidth = 170; winFig = 2;
						win = $(window).width();
						
					}
					else if(resiz > 1024) { 
						liWidth = 160; winFig = 5;
						win = $(window).width();
					}
				}
				else if(win > 800 && win < 1024) { 
					if(resiz < 800) {	
                         liWidth = 170; winFig = 2;
						 win = $(window).width();
					}
					else if(resiz > 1023) {
                         liWidth = 160; winFig = 5;
						 win = $(window).width();
					}
				}
				else if(win > 1023) {
					if(resiz < 1024) {
					liWidth = 170; winFig = 2;
					win = $(window).width();
					}
				}
				ulWidth = liWidth*winFig;
				atTime = parseInt(products/winFig) ;
				$($this.find('ul')).css('left','0');
				$this.find('ul').css('width', products*liWidth);
				last = (products*liWidth) - ulWidth;
				left = 0;
				current = 1;
			});
			
			
		}
})(jQuery);
	
/*------------	Featured Companies Home page slider ends----------------*/