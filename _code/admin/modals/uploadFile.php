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

// uploaded file should replace a previous one?
if(isset($_GET['replace']) && !empty($_GET['replace'])){
	$replace = urldecode($_GET['replace']);
}else{
	$replace = '';
}


?>
<div class="modal" id="uploadFileContainer">

<a href="javascript:;" class="closeBut">&times;</a>

	<!-- upload file start -->
	<div>
	<form enctype="multipart/form-data" name="uploadFileForm" id="uploadFileForm" action="/_code/admin/up_file.php" method="post">
		<input type="hidden" name="path" value="<?php echo $path; ?>">
		<input type="hidden" name="replace" value="<?php echo $replace; ?>">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_UPLOAD_BYTES; ?>">
		<input type="hidden" name="contextUploadFile" value="contextUploadFile">
		<a class="button submit left" id="chooseFileLink">Upload a file</a>
		<input type="file" name="file" id="fileUpload" style="opacity:0;"> 
		<button type="submit" name="uploadFileSubmit" style="opacity:0;" id="uploadFileSubmit">Upload</button>
		<div class="progress">
    		<div class="bar"></div>
		</div>
	</form>
	</div>
	<!-- upload file end -->

	<p>Supported File Types: jpg, gif, png. Maximum Upload Size: <?php echo MAX_UPLOAD_SIZE; ?></p>
	
	<!-- tips start -->
	<div style="margin-top:20px;">
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
		
	</div>
	<!-- tips end -->

	<a class="button hideModal left">Cancel</a>

	
</div>

