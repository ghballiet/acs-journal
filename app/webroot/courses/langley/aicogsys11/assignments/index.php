<?php
$_POST['page_title'] = 'Course Assignments';
include_once('../template/before.php');
?>
<? echo mark_file('assignments.txt'); ?>
<?php
include_once('../template/after.php');
?>