<?php
$f = $_GET['f'];
$t = $_GET['title'];
$_POST['page_title'] = $t;
include_once('../template/before.php');
echo mark_file($f . '.txt');
include_once('../template/after.php');
?>