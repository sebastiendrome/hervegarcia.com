<?php
require($_SERVER['DOCUMENT_ROOT'].'/_code/inc/first_include.php');
require(ROOT.'_code/admin/not_logged_in.php');
require(ROOT.'_code/admin/admin_functions.php');

/*********************** manage STRUCTURE ajax calls ***************************************/
// update name
if( isset($_GET['updateName']) ){
	$oldName = trim(urldecode($_GET['oldName']));
	$newName = trim(urldecode($_GET['newName']));
	$parents = urldecode($_GET['parents']); // if $parents is NOT empty or 'undefined', then we're renaming a sub-section
	$adminPage = urldecode($_GET['adminPage']);

	$result = update_section_name($oldName, $newName, $parents, $adminPage);
}

// update position
if(isset($_GET['updatePosition'])){
	$item = urldecode($_GET['item']);
	$oldPosition = urldecode($_GET['oldPosition']);
	$newPosition = urldecode($_GET['newPosition']);
	$parents = urldecode($_GET['parents']); // can be 'undefined', be can also be parent1/parent2
	$adminPage = urldecode($_GET['adminPage']);
	
	$result = update_position($item, $oldPosition, $newPosition, $parents, $adminPage);
}

// show or hide
if(isset($_GET['showHide'])){
	$item = urldecode($_GET['item']);
	$parents = urldecode($_GET['parents']);
	$result = show_hide($item, $parents);
}




/*********************** manage CONTENT ajax calls ***************************************/

// save text description (of files in manage content)
if(isset($_GET['saveTextDescription'])){
	$file = urldecode($_GET['file']); // full path to file
	$en_txt = urldecode($_GET['enText']);
	$de_txt = urldecode($_GET['deText']);
	$result = save_text_description($file, $en_txt, $de_txt);
}

// file upload
if(isset($_POST['contextNewFile'])){
	$path = urldecode($_POST['path']);
	$replace = urldecode($_POST['replace']);
	$result = upload_file($path, $replace);
}

// file upload background-image (in preferences.php)
if(isset($_POST['contextUploadFile'])){
	$path = urldecode($_POST['path']);
	$replace = urldecode($_POST['replace']);
	$replace_ext = file_extension(basename($replace));
    $file_type = $_FILES['file']['type'];
	
	// get and format file extension
	if(isset($file_type) && !empty($file_type)){ // get it from file metadata
		$split = explode('/', $file_type);
		$ext = '.'.strtolower($split[1]);
		$ext = str_replace('jpeg', 'jpg', $ext);
		// Mac .txt files can use the "plain" file type (for plain text)!...
		if($ext == '.plain' || $ext == '.text'){
			$ext = '.txt';
		}
		// msword file type (can be generated by open office)... and docx can be .doc, to use the doc.png icon...
		if($ext == '.msword' || $ext == '.docx'){
			$ext = '.doc';
		}
	}else{ // if no metadata, take file extension
		$ext = file_extension($file_name);
		$ext = strtolower($ext);
		$ext = str_replace('jpeg', 'jpg', $ext);
    }
    
	$file_name = 'bg'.$ext;
    $dest = $path.$file_name;
	if( up_file(ROOT.CONTENT.$dest) ){
        $result = 'file uploaded';
    }else{
        $result = 'error';
	}
	// if file uploaded successfully and was supposed to replace another file, remove the other file (if it has a different name.extension)
	if( $result == 'file uploaded' && !empty($replace) && $replace != $dest){
		unlink(ROOT.CONTENT.$replace);
	}
}

// file upload and insert (in edit_text.php)
if(isset($_POST['contextUploadFileInsert'])){

	$result_path = '_uploads/_XL/';
	$upload_path = ROOT.$result_path;

	$file_name = basename($_FILES['file']['name']);
	// get file extension
	$ext = file_extension($file_name);
	// re-format extension to standard, to avoid meaningless mismatch
	$ext = strtolower($ext);
	if($ext == '.jpeg' || $ext == '.jpe'){
		$ext = '.jpg';
	}

	// check if file type is supported
	if( !preg_match($_POST['types']['resizable_types'], $ext) ){
		$upload_result = '0|this file type is not supported: '.$ext;
	}else{
		$filename_no_ext = filename(file_name_no_ext($file_name),'encode');
		$rand = rand(1,9999);

		$result_path .= $filename_no_ext.'-'.$rand.$ext;
		$upload_dest = $upload_path.$filename_no_ext.'-'.$rand.$ext;

		// upload file and resize. Return the image url to be inserted on success, 0 on failure
		if( up_file($upload_dest) ){
			$result = PROTOCOL.SITE.$result_path;
			$root_upload_dest = ROOT.$result_path;
			list($w, $h) = getimagesize($root_upload_dest);
			$resize_result = resize_all($root_upload_dest, $w, $h);
		}else{
			$result = '0|There was an error during file upload!';
		}
	}
}

/*
// save text description (of files in manage content)
if(isset($_POST['saveTextEditor'])){
	$file = urldecode($_POST['item']); // full path to file
	$content = urldecode($_POST['content']);
	$result = save_text_editor($file, $content);
}
*/

if( isset($result) ){
	echo $result;
}
