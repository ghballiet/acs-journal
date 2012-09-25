<?
$title = $_POST['page_title']; 
?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../includes/css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="../includes/css/master.css" media="screen,print"/>
    <link rel="stylesheet" type="text/css" href="../includes/css/print.css" media="print"/>
<?
  if(isset($_POST['extra_css'])) {
    foreach($_POST['extra_css'] as $style) {
      echo '    <link rel="stylesheet" type="text/css" href="../includes/css/' . $style . '" media="screen,print"/>' . "\n";
    }
  }
?>
    <script type="text/javascript" src="../includes/scripts/jquery-1.5.2.min.js"></script>
    <script type="text/javascript" src="../includes/scripts/jquery.validate.min.js"></script>
    <title><? echo $title; ?> | ACS 2011</title>
  </head>
  <body>
    <div id="wrapper">
      <div id="top">
	<img src="../includes/img/brain.jpg" class="left"/>
	<h2>The AAAI Fall 2011 Symposium on </h2>
	<h1>Advances in Cognitive Systems</h1>
	<div class="clearfix"></div>
      </div>
      <div id="nav">
	<ul>
	  <li><a href="../">Home</a></li>
	  <li><a href="../apply">Application for Participation</a></li>
	</ul>
      </div>
      <div id="content">
