
// make sure nav height never desappears below page bottom (it is positioned fixed...)
function limitNavHeight(){
	var nH = $('#nav').height(); // recalculate nav height
	//alert(nH);
	if(nH > wH){
		//alert('too high!');
		if($('#nav').hasClass('collapsible')){
			$('#nav').removeClass('collapsible');
		}
		$('#nav').css({'height':wH+'px', 'overflow':'auto'});
		$('#nav ul').css('margin-right', 0);
	}
}

/* cookie functions */
function setCookie(c_name,value,exdays){
	var exdate=new Date();exdate.setDate(exdate.getDate()+exdays);
	var c_value=escape(value)+((exdays==null) ? "" : "; expires="+exdate.toUTCString()+"; path=/");
	document.cookie=c_name+"="+c_value;
}
/*
function getCookie(c_name){
	var c_value=document.cookie;var c_start=c_value.indexOf(" "+c_name+"=");
	if(c_start==-1){c_start=c_value.indexOf(c_name+"=");}
	if(c_start==-1){c_value=null;}
	else{c_start=c_value.indexOf("=",c_start)+1;
		var c_end=c_value.indexOf(";",c_start);
		if(c_end==-1){c_end=c_value.length;}
		c_value=unescape(c_value.substring(c_start,c_end));}
	return c_value;
}
*/

// get window width and height
var wW = $(window).width();
var wH = $(window).height();

var contentW = $('#content').innerWidth();
if(contentW > wW){
	contentW = wW;
}

// max width and height for images
var max_w = contentW;
var max_h = wH-40;

// set cookies of window width and height for later use
setCookie('wW', wW, 2);
setCookie('wH', wH, 2);

setCookie('iW', max_w, 2);
setCookie('iH', max_h, 2);

$(document).ready(function(){

	// get footer height
	var fH = $('#footer').outerHeight();
	// get nav height
	var navH = $('#nav').outerHeight();

	limitNavHeight();

	// this var will detremine where the footer stands, when content container is empty
	var contentMinHeight = wH-fH-87;

	// if viewport width is less than 980px, 
	if (document.documentElement.clientWidth < 980) {
		contentMinHeight = wH-fH-60;
	}

	// if viewport width is less than 720px, 
	if (document.documentElement.clientWidth < 720) {
		contentMinHeight = wH-fH-78;
		
		// show/hide navigation for small screens
		$('#nav').on('click', 'a#mobileMenu', function(e){
			if($('#nav').hasClass('collapsible')){
				$('#nav').removeClass('collapsible').removeAttr("style");
			}else if($('#nav').height() == wH){ // collaspible class has been removed by limitNavHeight function, so just look for nav_height = window_height
				$('#nav').css({'height':navH+'px', 'overflow':'hidden'});
				$('#nav ul').css('margin-right', '10px');
			}else{
				$('#nav').addClass('collapsible').removeAttr("style");
				limitNavHeight();
			}
			e.preventDefault();
		
			// avoid propagation of nav click if click on site title (#nav h1 a)
			/*$('#nav h1 a').click(function(event){
				event.stopPropagation();
			});*/
		});
	}
	

	// position footer at bottom of page even if no content
	$('#content').css('min-height', contentMinHeight+'px');


	// underline '.aMore' link when mouse over '.imgMore' (for sub-sections)
	$('div.divItem').on('mouseenter', 'a.imgMore', function(){
		$(this).closest('.divItem').children('.title').children('.aMore').css('text-decoration', 'underline');
	});
	// un-underline '.aMore' link when mouse over '.imgMore' (for sub-sections)
	$('div.divItem').on('mouseleave', 'a.imgMore', function(){
		$(this).closest('.divItem').children('.title').children('.aMore').css('text-decoration', '');
	});

});

// show tooltip below the span.question element on click (native title tooltip will show on moue hover)
// reposition it if it is below the bottom window edge
$('body').on('click', 'span.question', function(){
	var msg = $(this).attr("title");
	if($(this).children('span.tooltip').length == 0){
		$(this).append('<span class="tooltip">'+msg+'</span>');
	}
	var $tooltip = $(this).find('span.tooltip');
	// calculate verticaly
	var offsetTop = $tooltip.offset().top;
	var sTop = $(window).scrollTop();
	var tH = $tooltip.outerHeight();
	// calculate orizontaly
	var offsetLeft = $tooltip.offset().left;
	var sLeft = $(window).scrollLeft();
	var tW = $tooltip.outerWidth();
	/*
	// alerts for left and top values
	alert('offsetLeft: '+offsetLeft+' tW: '+tW+' sLeft: '+sLeft+' calcul: '+(offsetLeft+tW-sLeft)+' wW:'+wW);
	alert('offsetTop: '+offsetTop+' tH: '+tH+' sTop: '+sTop+' calcul: '+(offsetTop+tH-sTop)+' wH:'+wH);
	*/
	// reposition verticaly
	if(offsetTop+tH-sTop > wH){
		$tooltip.css('top', (-tH-10)+'px');
	}
	// reposition orizontaly
	if(offsetLeft+tW-sLeft > wW){
		$tooltip.css('left', (-tW)+'px');
	}
}).on('mouseleave', 'span.question', function(){
	$(this).children('span.tooltip').remove();
});