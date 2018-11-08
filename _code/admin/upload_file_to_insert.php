<?php
// upload file form POST process (from uploadFile.php, modal window)
require($_SERVER['DOCUMENT_ROOT'].'/_code/inc/first_include.php');
require(ROOT.'_code/admin/not_logged_in.php');
require(ROOT.'_code/admin/admin_functions.php');

// increase memory size to allow heavy image manipulations (rotating large image and generating sized-down copies)
ini_set('memory_limit','160M');

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
        $upload_result = PROTOCOL.SITE.$result_path;
        $root_upload_dest = ROOT.$result_path;
        list($w, $h) = getimagesize($root_upload_dest);
        $resize_result = resize_all($root_upload_dest, $w, $h);
    }else{
        $upload_result = '0|There was an error during file upload!';
    }
}

sleep(1);
?>
<script language="javascript" type="text/javascript">
   window.top.window.stopUpload('<?php echo $upload_result; ?>');
</script>