<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Hervé Garcia - Art Portfolio</title>
<meta name="description" content="The artwork of Hervé Garcia.">

<style type="text/css" media="screen">
body, html{width:100%; height:100%; margin:0; padding:0; background-color:#fff; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; color:#000;}

/*h1{font-family:"Times New Roman", Times, serif; font-weight:normal; font-size:20px; letter-spacing:1px;}*/
h1{ font-size:21px; font-weight:normal; padding-bottom:20px;}

a{color:#000; text-decoration:none; background-color:#fff; line-height:23px}
a:hover{text-decoration:underline;}
.container{/*width:80%; margin:0 auto;*/ padding-top:20px;}
.stay{position:fixed; top:0; left:0; padding-top:30px; padding-left:40px;}
.images{text-align:center; padding:0 0 70px 0;}
.images img{
	display:inline-block; 
	max-height:560px; 
	margin:90px auto 10px auto; 
	cursor:zoom-in;
}
.images img:first-child {margin-top:20px; }
.images img.realSize{max-height:none; cursor:zoom-out;}
.images p{font-size:smaller;}

@media screen and (max-width: 730px) {
    .stay{position:relative; padding-top:0;}
}

</style>

<!-- jQuery -->
<script type="text/javascript" src="/js/jquery-1.7.2.min.js" charset="utf-8"></script>

</head>

<!--
<body style="background-image:url(/images/hg-home-bg.jpg); background-position:50% 50%; background-repeat:no-repeat; background-size:contain;">
-->
<body>

<div class="container">

<div class="stay">
<h1>RV GARCIA</h1>
<!--<a href="http://hervegarcia.tumblr.com" target="_blank">hervegarcia.tumblr.com</a><br>-->
<a href="http://thedoormateffect.tumblr.com" target="_blank">Archive pictures</a><br>
<a href="http://archiveobjectshervegarcia.tumblr.com" target="_blank">Archive objetcs</a><br>
<!--
<a href="/images/H GARCIA.pdf" target="_blank">PDF</a><br>
-->
<a href="/images/cv.pdf">CV</a><br>
<a href="mailto:h_garcia33@hotmail.com">Contact</a><br>
</div>

<div class="images">
<img src="/images/small/a.jpg" alt="Hervé Garcia: Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016">
<p>Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016</p>
<img src="/images/small/b.jpg" alt="Hervé Garcia: Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016">
<p>Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016</p>
<img src="/images/small/c.jpg" alt="Hervé Garcia: Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016">
<p>Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016</p>
<img src="/images/small/d.jpg" alt="Hervé Garcia: Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016">
<p>Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016</p>
<img src="/images/small/e.jpg" alt="Hervé Garcia: Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016">
<p>Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016</p>
<img src="/images/small/f.jpg" alt="Hervé Garcia: Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016">
<p>Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016</p>
<img src="/images/small/g.jpg" alt="Hervé Garcia: Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016">
<p>Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016</p>
<img src="/images/small/h.jpg" alt="Hervé Garcia: Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016">
<p>Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016</p>
<img src="/images/small/i.jpg" alt="Hervé Garcia: Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016">
<p>Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016</p>
<img src="/images/small/j.jpg" alt="Hervé Garcia: Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016">
<p>Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016</p>
<img src="/images/small/k.jpg" alt="Hervé Garcia: Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016">
<p>Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016</p>
<img src="/images/small/l.jpg" alt="Hervé Garcia: Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016">
<p>Untitled, collage, ballpoint pen on paper,  21 x 29.7 cm, 2016</p>

</div>

</div>


<script type="text/javascript">
$('.images').on('click', 'img', function(){
	if($(this).hasClass('realSize')){
		$(this).removeClass('realSize');
	}else{
		$(this).css('opacity', '.5');
		var oldSrc = $(this).attr("src");
		var newSrc = oldSrc.replace("small/","");
		var imgPreload = new Image();
    	$(imgPreload).attr({
        	src: newSrc
    	});

    	//check if the image is already loaded (cached):
    	if (imgPreload.complete || imgPreload.readyState === 4) {
			$(this).attr("src", newSrc);
		}
		$(this).css('opacity', 1);
		$(this).addClass('realSize');
	}
});
</script>



</body>
</html>

