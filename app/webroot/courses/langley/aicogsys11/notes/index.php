<?php
$_POST['page_title'] = 'Selected Course Notes';
include_once('../template/before.php');
?>
<? echo mark_file('notes.txt'); ?>
<?php
include_once('../template/after.php');
?>