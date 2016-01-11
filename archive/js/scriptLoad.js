// JavaScript Document

    detectBrowser();
	var windowWidth = $(window).width();
	if(_browserName == "Microsoft Internet Explorer") { _ieFlag = 1;adjustStyle(windowWidth); }
	jsChanger(windowWidth);
    
	$(window).resize(function() {
		var windowWidth = $(window).width();
	if ($($("body").children()[0]).height() > $(window).height() )
	 {
	 	if ( (_browserName == "Chrome") || (_browserName == "Safari" && _majorVersion > 4) ) windowWidth;
		else if(_browserName == "Microsoft Internet Explorer"){
			windowWidth = windowWidth + 17 ;
			adjustStyle(windowWidth);
		}
		else windowWidth = windowWidth + 17 ;
	 }
	 else
	 {	
		jsChanger(windowWidth);
		adjustStyle(windowWidth);
	 }
    });
// READY FUNCTION ENDS



//---------GLOBAL VARIABLES
var _browserName  = navigator.appName;
var _majorVersion = parseInt(navigator.appVersion,10);
var _ieFlag = 0;
//GLOBAL VARIABLES ENDS


//---- Browser Detection start
// JavaScript Document


function detectBrowser(){
// detect browsers if FF <=3, OPera <=9 and safari < 4

var nVer = navigator.appVersion;
var nAgt = navigator.userAgent;
var fullVersion  = ''+parseFloat(navigator.appVersion); 
var nameOffset,verOffset,ix;

// In Opera, the true version is after "Opera" or after "Version"
if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
 _browserName = "Opera";
 fullVersion = nAgt.substring(verOffset+6);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In MSIE, the true version is after "MSIE" in userAgent
else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
 _browserName = "Microsoft Internet Explorer";
 fullVersion = nAgt.substring(verOffset+5);
}
// In Chrome, the true version is after "Chrome" 
else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
 _browserName = "Chrome";
 fullVersion = nAgt.substring(verOffset+7);
}
// In Safari, the true version is after "Safari" or after "Version" 
else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
 _browserName = "Safari";
 fullVersion = nAgt.substring(verOffset+7);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In Firefox, the true version is after "Firefox" 
else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
 _browserName = "Firefox";
 fullVersion = nAgt.substring(verOffset+8);
}

// trim the fullVersion string at semicolon/space if present
if ((ix=fullVersion.indexOf(";"))!=-1)
   fullVersion=fullVersion.substring(0,ix);
if ((ix=fullVersion.indexOf(" "))!=-1)
   fullVersion=fullVersion.substring(0,ix);

_majorVersion = parseInt(''+fullVersion,10);
if (isNaN(_majorVersion)) {
 fullVersion  = ''+parseFloat(navigator.appVersion); 
 _majorVersion = parseInt(navigator.appVersion,10);
}

//alert(_browserName + " " + _majorVersion);
//insert js and css using below javascript
function unsuportedAndAllIE(){
	var element = document.createElement("link");
	element.setAttribute("rel", "stylesheet");
	element.setAttribute("type", "text/css");
	element.setAttribute("id", "size-stylesheet");
	var width= $(this).width();
	var path="css/";
	
	if(width < 801)
	element.setAttribute("href", path+"601x800.css");
	else if(width > 800 && width < 1024)
	element.setAttribute("href", path+"801x1023.css");
	else if(width > 1023)
	element.setAttribute("href", path+"1024.css");
	
	document.getElementsByTagName("head")[0].appendChild(element);

	/*var js = document.createElement("script");
	js.setAttribute("type", "text/javascript");
	js.setAttribute("src", "js/styleLoad.js");
	document.getElementsByTagName("head")[0].appendChild(js);*/
}

function responsive(){
	var element = document.createElement("link");
	element.setAttribute("rel", "stylesheet");
	element.setAttribute("type", "text/css");
	element.setAttribute("href", "css/responsive.css");
	document.getElementsByTagName("head")[0].appendChild(element);
}
// for css3media quries
if( (_browserName == "Firefox" && _majorVersion <= 3) || (_browserName == "Opera" && _majorVersion <= 9) || (_browserName == "Safari" && _majorVersion < 4) || (_browserName == "Microsoft Internet Explorer") )
	unsuportedAndAllIE();

else if ( (_browserName == "Firefox" && _majorVersion > 3) || (_browserName == "Opera" && _majorVersion > 9) || (_browserName == "Chrome") || (_browserName == "Safari" && _majorVersion > 4) )
	responsive();
else// For all other browsers
	responsive();

/* variables info that can be used above --- _browserName, fullVersion, _majorVersion, navigator.appName, navigator.userAgent */
}
//--- DETECT BROWSER FUNCTION ENDS



/*---- jsChanger
8	Change script file according to resolution
*   1. small.js
*   2. medium.js
*   3. mediPlus.js
*   4. wide.js
*/
function jsChanger(width) {
	
    width = parseInt(width);
	jsDir = "js/";
	fileName = "";
	jsPath = "";
	
   
	if (width < 801){// console.log('med JS'); 
	fileName = "601x800.js"; }
	else if (width > 800 && width < 1024){// console.log('med JS'); 
	fileName = "801x1023.js"; }
	else if(width > 1023) {fileName = "1024.js";}
	jsPath = jsDir + fileName;
	var flag = 0;
	if( $('#scriptLoad').attr('src') == jsPath )
		flag = 1;
	if(flag == 0){
		
		$('#scriptLoad').remove();
		var js = document.createElement("script");
		js.setAttribute("type", "text/javascript");
		js.setAttribute("src", jsPath);
		js.setAttribute("id", 'scriptLoad');
		document.getElementsByTagName("head")[0].appendChild(js);
	}
}//----jsChanger FUNCTION ENDS

function adjustStyle(width) {
    width = parseInt(width);
	var cssPath = "css/";
	if (width < 801 ) {//console.log('601');
        $("#size-stylesheet").attr("href", cssPath+"601x800.css");
	}
	if (width > 800 && width < 1024 ) {//console.log('801');
        $("#size-stylesheet").attr("href", cssPath+"801x1023.css");
	}
	
	else if(width > 1023) {//alert('wide');
       $("#size-stylesheet").attr("href", cssPath+"1024.css"); //console.log('1024');
	}
}

