
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
/*
// load sub-section via ajax for orizontal scroll within top-section page (if set so by user)
function loadSubSection(path, elem){
	$(elem).css('opacity', '.5');
	$.ajax({
		method: "GET",
		url: "/_code/load_sub_section.php",
		data: 'path='+path
	})
	.done(function(msg){
		$(elem).css('opacity', 1);
		if(!msg.match("^<p class=\"error")){
			
			// update the title/link above the sub-section
			var $title = $(elem).find('p.title.orizontal');
			var $aMore = $title.find('a.aMore.orizontal');
			var $href = $aMore.attr("href");
			var fields = $href.split('/');
			$title.html('<a href="/'+fields[1]+'/" class="aLess orizontal" data-close="'+fields[2]+'"><- '+fields[1]+'</a> | '+fields[2]);

			// position the layer
			var $firstEl = $(elem).find('a.imgMore');
			var offSetTop = $firstEl.offset().top;
			var offsetLeft = $(elem).offset().left;
			var containerWidth = wW-offsetLeft;

			$('body').append('<div class="subContainer" id="'+fields[2]+'" style="width:'+containerWidth+'px; top:'+offSetTop+'px; left:0; padding-left:'+offsetLeft+'px;">'+msg+'</div>');
			$('.subContainer').wrapInner('<table cellspacing="0" cellpadding="0"><tr>');
    		$('.subContainer .divItem').wrap('<td>');
		}else{
			alert(msg);
		}
	});
}
*/

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

// set cookies of window width and height for later use
setCookie('wW', wW, 2);
setCookie('wH', wH, 2);

$(document).ready(function(){

	// get footer height
	var fH = $('#footer').outerHeight();
	// gte nav height
	var navH = $('#nav').outerHeight();

	limitNavHeight();

	// this var will detremine where the footer stands, when content container is empty
	var contentMinHeight = wH-fH-87;

	// if viewport width is less than 980px, 
	if (document.documentElement.clientWidth < 980) {
		contentMinHeight = wH-fH-60;
	}

	// show/hide navigation for small screens
	$('#nav').on('click', function(e){
		// if viewport width is less than 720px, 
		if (document.documentElement.clientWidth < 720) {

			contentMinHeight = wH-fH-100;
			if($(this).hasClass('collapsible')){
				$(this).removeClass('collapsible').removeAttr("style");
			}else if($(this).height() == wH){ // collaspible class has been removed by limitNavHeight function, so just look for nav_height = window_height
				$(this).css({'height':navH+'px', 'overflow':'hidden'});
				$('#nav ul').css('margin-right', '10px');
			}else{
				$(this).addClass('collapsible').removeAttr("style");
				limitNavHeight();
			}
		
			// avoid propagation of nav click if click on site title (#nav h1 a)
			$('#nav h1 a').click(function(event){
				event.stopPropagation();
			});
		}
	});

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

	// sub-section should load via ajax (and scroll orizontally) if set so by user
	$('div.divItem').on('click', 'a.aMore.orizontal, a.imgMore.orizontal', function(e){
		var path = $(this).attr("href");
		var elem = $(this).closest('div.divItem');
		//alert(path);
		loadSubSection(path, elem);
		e.preventDefault();
	});
	// close sub-section
	$('div.divItem').on('click', '.aLess.orizontal', function(e){
		var closeId = $(this).data("close");
		//alert(closeId);
		$('#'+closeId).hide();
		e.preventDefault();
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