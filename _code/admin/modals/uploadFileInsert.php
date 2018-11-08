<?php
// upload file modal
require($_SERVER['DOCUMENT_ROOT'].'/_code/inc/first_include.php');
require(ROOT.'_code/admin/not_logged_in.php');


// for creating sub-sections, we need the parent section:
if( isset($_GET['path']) ){
	$path = urldecode($_GET['path']);
}else{
	exit;
}

?>
<style>

</style>

<div class="modal" id="uploadFileInsertContainer">

    <a href="javascript:;" class="closeBut">&times;</a>

	<!-- upload file start -->
	<div>
    
	<p id="f1_upload_process"></p>
    <p id="result"></p>

	<div id="uploadFileDiv">

	<form enctype="multipart/form-data" name="uploadFileForm" id="uploadFileForm" action="/_code/admin/upload_file_to_insert.php" target="upload_target" method="post">
		<input type="hidden" name="path" value="<?php echo $path; ?>">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_UPLOAD_BYTES; ?>">
		<input type="hidden" name="contextUploadFileInsert" value="contextUploadFileInsert">
		<a class="button submit left" id="chooseFileLink">Upload an image</a>
		<input type="file" name="file" id="fileUpload" style="opacity:0;">
		<button type="submit" class="right" id="uploadFileSubmit" name="uploadFileSubmit" style="opacity:0;">Upload</button>
		<div class="progress">
    		<div class="bar"></div>
		</div>
	</form>
	<p class="above clearBoth hideUp" style="margin-top:0;">use this option to choose a file from your computer.<br>
	Supported file types: jpg, gif, png. Maximum Upload Size: <?php echo MAX_UPLOAD_SIZE; ?></p>

	</div>

	
	<h3 style="text-align:center; margin:20px 0;" class="hideUp"> —— OR —— </h3>

	
	<div id="imgUrlDiv" class="hideUp">
        <h3>Enter image URL <span class="question" title="The URL is the web address of the image, i.e. http://www.example.com/image.jpg">?</span></h3>
		<input id="img_url" value="" placeholder="http://" style="width:calc(100% - 120px);">
		<a class="button submit hideModal insertImage right">Insert URL</a>
		<p class="above" style="margin-top:0;">use this option to display an image from another website.</p>
	</div>
	<p class="clearBoth hideUp">&nbsp;</p>

	</div>
	<!-- upload file end -->


	<!-- tips start -->
	<div style="margin-top:20px; border-top:1px solid #ccc;" class="hideUp">
	<p>Tips:</p>
		<div class="tip">
			<a href="javascript:;" class="tipTitle">How to best optimize Images for the web, using Photoshop</a>
			<ol>
			<li>Open your file in Photoshop</li>
			<li>Under menu, select: Image > Image Size...</li>
			<li>Adjust the Width and Height, in pixels, so that neither exceeds 3000px</li>
			<li>Check "Constrain Proportions" and "Resample Image"</li>
			<li>Click OK.</li>
			<li>Under menu, select: File > Save for Web & Devices...</li>
			<li>Select JPEG format, Very High quality, check Optimized</li>
			<li>Click Save.</li>
			</ol>
		</div>

		<div class="tip">
			<a href="javascript:;" class="tipTitle">How to get the URL of an image from another web site.</a>
			<ol>
			<li>Browse to the image in the other web site.</li>
			<li>Control-click on the image (press the "ctrl" key and click at the same time).</li>
			<li>You'll see a list of options, click on the one that says "copy image address", or "copy image location" or something equivalent (the wording differs depending on the navigator).</li>
			<li>Come back here and paste it!</li>
			</ol>
		</div>
		
	</div>
	<!-- tips end -->

	<a class="button hideModal left hideUp">Cancel</a>

</div>


<!-- iframe width is set to 100% to avoid a wierd bug where the window width cookie is updated if iframe is small, causing the #content div to shrink to its minimum 300px width on page reload! -->
<iframe id="upload_target" name="upload_target" src="#" style="width:100%;height:0;border:none;"></iframe>


<script type="text/javascript">
// validate url before inserting... (function validateUrl is declared in edit_text.php)
$('a.insertImage').on('click', function(e){
	var img_url = $('input#img_url').val();
	if(img_url.length){
		var ok = validateUrl('img_url', event);
		if( ok != false ){
			insertImg(img_url);
		}else{
			$('input#img_url').focus();
			return false;
			e.preventDefault();
		}
	}else{
		alert('url is empty...');
		return false;
		e.preventDefault();
    }
});

// make sure only one of the input options (url and upload) has a value, disable the other on change
$('input#img_url').on('change, keypress, keyup', function(e){
	var thisVal = $(this).val();
	if( thisVal.length ){
		enable_url();
	}else{
		disable_url();
	}
});

$('input#img_url').bind('paste', function(e) { // text pasted
	enable_url();
});


// initialize url option submit button, so it's disabled until something is entered
disable_url();

function disable_url(){
	$('a.button.insertImage').addClass('disabled');
	$('input#img_url').val('');
}
function enable_url(){
	$('a.button.insertImage').removeClass('disabled');
}

// insert image url in text editor (using their API command)
function insertImg(img_url){
	// check for '_XL' directory in image path, and replace it with _L dir, so that inserted images are not huge
	var match = img_url.match("/_XL/");
	if(match != null){
		img_url = img_url.replace("/_XL/", "/_L/");
	}
    editor.composer.commands.exec("insertImage", {src:img_url, alt:''});
}

/*
* The upload Form action is set to upload_file_insert.php, but its target is the iframe#upload_target.
* So when upload is complete (processed via upload_file_insert.php, but from within the target iframe),
* a line of javascript in upload_file_to_insert.php calls the following function by invoquing the top window:
* window.top.window.stopUpload(upload_result);
* this works because the Form target attribute is (the DOM space of?) the iframe, so the javascript is executed from within it!...
* upload_result is either '0' (error) or the url of the image that was just uploaded. 
* This url is inserted in the editor via insertImg(upload_result)
*/ 
function stopUpload(upload_result){
	var result = '';
	var error = upload_result.match(/^0\|/);
    if(error == null){
		insertImg(upload_result);
        hideModal($('#uploadFileInsertContainer'));
    }else{
        var msg = upload_result.replace("0|", 'Error: ');
        $('#result').html('<p class="error">'+msg+'</p>');
    }
    $('button#uploadFileSubmit').css({'opacity':1,'cursor':'pointer'}); 
    $('img#uf').removeClass('visible');

    return true;   
}

</script>
