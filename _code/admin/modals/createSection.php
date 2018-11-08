<?php
// create section modal
require($_SERVER['DOCUMENT_ROOT'].'/_code/inc/first_include.php');
require(ROOT.'_code/admin/not_logged_in.php');

// for creating sub-sections, we need the parent section:
if(isset($_GET['parents']) && !empty($_GET['parents']) ){
	$parents = urldecode($_GET['parents']);
}else{
	$parents = '';
}
?>
<div class="modal" id="createSectionContainer">
	<a href="javascript:;" class="closeBut">&times;</a>
	<h3 class="first below">Section name:</h3>
	<form name="createSectionForm" action="" method="post" onsubmit="if($(this).find('input#createSection').val()==''){return false;}">
		In both languages, separated with a coma.
		<input type="hidden" name="parents" value="<?php echo $parents; ?>">
		<input type="text" name="createSection" id="createSection" maxlength="100" value="" style="width:97%; border-left:7px solid #000;" placeholder="<?php echo FIRST_LANG; ?>, <?php echo SECOND_LANG; ?>">
		<p><a class="button hideModal left">Cancel</a> <button type="submit" name="createSectionSubmit" class="right">Create</button></p>
	</form>
</div>
<!--
	removed because it interferes with checkmodalheight() (focus makes page natively scroll to modal...)
<script type="text/javascript">
document.forms[0].createSection.focus();
</script>
-->