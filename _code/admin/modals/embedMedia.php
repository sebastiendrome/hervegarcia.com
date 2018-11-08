<?php
// embed media modal
require($_SERVER['DOCUMENT_ROOT'].'/_code/inc/first_include.php');
require(ROOT.'_code/admin/not_logged_in.php');

// path where new .emb file should be created. If 'edit' was clicked, the path is the path/to/file.emb
if(isset($_GET['path']) && !empty($_GET['path']) ){
    $path = urldecode($_GET['path']);
    $ext = file_extension($path);
    if($ext == '.emb'){
        $content = file_get_contents(ROOT.CONTENT.$path); // get file content if editing an already existing file.
    }
}else{
	exit;
}


?>
<div class="modal" id="embedMediaContainer">
<a class="closeBut">&times;</a>
	<!-- upload file start -->
	<div>
	<h3 class="first">Embed Media</h3>
	<p>Get embed code from Youtube, Vimeo, Soundcloud, Bandcamp, Twitter, etc.<br>
	Usually you'll find the embed code in these sites by clicking a "share" button and selecting the "embed" option; you'll see a piece of code that you can copy and paste.</p>
    <!-- <p class="note warning">Only paste code from trusted sources: malicious code could break your site and/or make it dangerous to use !</p> -->
	<form name="embedMediaForm" id="embedMediaForm" action="/_code/admin/embed_media.php" method="post">
		<input type="hidden" name="path" value="<?php echo $path; ?>">
		<textarea name="embedMedia" style="width:100%; height:200px;" placeholder="paste embed code here"><?php if(isset($content)){echo $content;} ?></textarea>
		<a class="button hideModal left">Cancel</a> <button type="submit" name="embedMediaSubmit" class="right" onclick="this.style.opacity=0; this.style.cursor='default'; var i=document.getElementById('uf'); i.className += ' visible';"> Save </button>
	</form>
	</div>
	<!-- upload file end -->


	

	
</div>

