<?php
// upload file modal
require($_SERVER['DOCUMENT_ROOT'].'/_code/inc/first_include.php');
require(ROOT.'_code/admin/not_logged_in.php');
require(ROOT.'_code/admin/admin_functions.php');

if(isset($_GET['path']) && !empty($_GET['path']) ){
	$path = urldecode($_GET['path']);
}else{
	exit;
}

// uploaded file should replace a previous one?
if(isset($_GET['replace']) && !empty($_GET['replace'])){
	$replace = urldecode($_GET['replace']);
	$replace_filename = basename($replace);
}else{
	$replace = $replace_filename = '';
}

$supported_types = str_replace(array("/^\.(", ")$/i", 's?', 'e?', 'a?', '?'), '', $_POST['types']['supported_types']);
$file_types = str_replace('|', ', ', $supported_types);


?>
<div class="modal" id="newFileContainer">
	<a href="javascript:;" class="closeBut">&times;</a>
	
	<!-- upload file start -->
	<div>
	<form enctype="multipart/form-data" name="uploadFileForm" id="uploadFileForm" action="/_code/admin/upload_file.php" method="post">
	<a class="button submit left" id="chooseFileLink">Upload a file</a>
	<div class="progress">
    	<div class="bar"></div>
	</div>
	<input type="file" name="file" id="fileUpload" style="opacity:0;">
		<input type="hidden" name="path" value="<?php echo $path; ?>">
		<input type="hidden" name="replace" value="<?php echo $replace; ?>">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_UPLOAD_BYTES; ?>">
		<input type="hidden" name="contextNewFile" value="contextNewFile">
		
		<button type="submit" name="uploadFileSubmit" id="uploadFileSubmit" class="right"  style="opacity:0;">Upload</button>
	</form>
	<span class="hideUp">(Maximum Upload Size: <?php echo MAX_UPLOAD_SIZE; ?>)</span>
	<?php 
// only show the create file option if the modal is not opened from the replace button
if(empty($replace)){
?>
	<p class="above clearBoth hideUp">Use this option to upload images (jpg, png or gif) or other files from your computer.
	</p>
<?php } ?>
	</div>
	<!-- upload file end -->
	
<?php 
// only show the create file option if the modal is not opened from the replace button
if(empty($replace)){
?>
	
	<h3 style="text-align:center; margin:20px 0;" class="hideUp"> —— OR —— </h3>
	
	<!-- create file start -->
	<div id="createFileDiv" class="hideUp">
	<form name="createTextForm" action="/_code/admin/edit_text.php" method="post">
	<button type="submit" name="createText" class="left">Create a file</button>
		<input type="hidden" name="path" value="<?php echo $path; ?>">
		<!--File name:
		<input type="text" name="fileName" value="" style="width:55%; padding:5px 0;" placeholder="&nbsp;(optional)" maxlength="50">
		<button type="submit" name="createText">Create</button> -->
	</form>
	<p class="above clearBoth">Use this option to write, paste and format text. You can also insert images in your text.
	</p>
	</div>
	<!-- create file end -->


	<h3 style="text-align:center; margin:20px 0;" class="hideUp"> —— OR —— </h3>

	<a href="javascript:;" class="button showModal submit hideUp left" rel="embedMedia?path=<?php echo $path; ?>" onclick="$('div.modalContainer, div.overlay').hide();">Embed media</a>
	<p class="above clearBoth hideUp">Use this option to insert media content from other sites (video from youtube or vimeo, audio/playlist from soundcloud or bandcamp, post from twitter, etc...)</p>
	</p>

<?php
}
?>
	
	<!-- tips start -->
	<div style="border-top:1px solid #ccc; margin-top:20px;" class="hideUp">
	<p>Tips:</p>
		<div class="tip">
			<a href="javascript:;" class="tipTitle">Supported File Types for upload</a>
			<ol><?php echo $file_types; ?>.<br>
			<i>Note: pdf, docx, msword and odt files won't be displayed in the pages but will be accessible via a download link.</i></ol>
		</div>
		<div class="tip">
			<a href="javascript:;" class="tipTitle">How to best optimize Images for the web, using Photoshop</a>
			<?php include(ROOT.'_code/inc/optimize.php'); ?>
		</div>
		
	</div>
	<!-- tips end -->

	<a class="button hideModal left hideUp">Cancel</a>
	
</div>
