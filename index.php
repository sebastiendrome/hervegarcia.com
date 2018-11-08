<?php
require('_code/inc/first_include.php');
if(LANG == 'de'){
    $seo_title = $seo_title_de;
    $seo_description = $seo_description_de;
}else{
    $seo_title = $seo_title_en;
    $seo_description = $seo_description_en;
}
if(empty($seo_title)){
    $title = USER.' Artist Portfolio';
}else{
    $title = $seo_title;
}
if(empty($seo_description)){
    $description = USER;
}else{
    $description = $seo_description;
}

$page = 'home';

require(ROOT.'_code/inc/doctype.php');

require(ROOT.'_code/inc/nav.php');

?>


<!-- start content -->
<div id="content">
&nbsp;
</div><!-- end content -->

<div class="clearBoth"></div>

<?php require(ROOT.'_code/inc/js.php'); ?>

<?php require(ROOT.'_code/inc/footer.php'); ?>

