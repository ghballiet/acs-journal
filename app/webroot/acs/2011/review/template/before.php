<?
session_start();
$title = $_POST['page_title'];
$css = $_POST['extra_css'];
$js = $_POST['extra_js'];
$hideMenu = $_POST['hideMenu'];
$site = 'ACS 2011 Review Site';
include_once('../includes/php/session.php');

if(passwordResetRequired() && $title!='Password Reset')
  header('Location: ../reset/');

if($_POST['goHome'] == md5(true))
  goHome();

if($_POST['loginRequired'] == md5(true))
  loginRequired();

if($_POST['adminRequired'] == md5(true))
  adminRequired();

?>
<html>
  <head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">    
    <title><? echo $title . ' | ' . $site; ?></title>
    <!-- css -->
    <link type="text/css" rel="stylesheet"
          href="../includes/css/style.css">
<?
if($css != null) {
  foreach($css as $link) {
?>
    <link type="text/css" rel="stylesheet"
          href="../includes/css/<? echo $link ?>">
<?
  }
}
?>
   <link type="text/css" rel="stylesheet"
         media="print" href="../includes/css/print.css">
 
    <!-- js -->
    <script src="../includes/js/jquery-1.6.1.min.js"></script>
    <!-- <script src="../includes/js/less.min.js"></script> -->
    <script src="../includes/js/message.js"></script>
<?
if($js != null) {
  foreach($js as $src)
?>
    <script src="../includes/js/<?echo $src; ?>"></script>
<?
}
?>
  </head>
  <body>
    <header>
      <section class="wrap">
        <img src="../includes/img/acs_cropped_white.png">
<? if(isLoggedIn()) {?>
        <section class="user">
          Welcome back, <span><? echo $_SESSION['userName']; ?></span>
        </section>
<? } ?>
      </section>
    </header>
    <article>
      <section class="wrap">
<? if(isLoggedIn() && !$hideMenu) { ?>
          <menu>
            <? menu(); ?>
            <a href="../logout/">Logout</a>
          </menu>
<? }?>
          <section id="content">