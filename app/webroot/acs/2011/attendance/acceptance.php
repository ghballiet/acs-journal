<?
include_once('../includes/php/functions.php');
init();

$fn = $_POST['first_name'];
$ln = $_POST['last_name'];
$attend = $_POST['attend'];
$num_papers = $_POST['num_papers'];
$titles = $_POST['titles'];

$titles = implode("^",explode("\n",$titles));

$query = "insert into attendance values (NULL,?,?,?,?,?,'')";
$q = $db->prepare($query);
$q->bindParam(1, $fn);
$q->bindParam(2, $ln);
$q->bindParam(3, $attend);
$q->bindParam(4, $num_papers);
$q->bindParam(5, $titles);
$success = $q->execute();

cleanup();

if($success) {
  $t = "Glen Hunt <glenrhunt@gmail.com>, Pat Langley <langley@asu.edu>";
  $s = "ACS 2011 Attendance Confirmation";
  $b = '<style type="text/css">';
  $b .= '* { font-family: helvetica,arial,sans-serif; }';
  $b .= 'body { font-size: 14px; color: #222; }';
  $b .= 'p { line-height:1.4em; margin-bottom: 1.4em;}';
  $b .= '</style>';
  $b .= "\n\n";
  $b .= '<p>The following attendance was confirmed:</p>';
  $b .= "<p><b>Name:</b> $fn $ln<br>";
  $b .= "<b>Attendance:</b> $attend<br>";
  $b .= "<b>Papers:</b> $num_papers<br>";
  $b .= "<b>Paper Titles:</b><br>";
  $b .= implode("<br>",explode("^",$titles));
  $b .= "</p>";

  $h = "From: ACS Mailer <donotreply@cogsys.org>\r\n";
  $h .= "MIME-Version: 1.0\r\n";
  $h .= "Content-Type: text/html; charset-ISO-8859-1\r\n";
  mail($t, $s, $b, $h);
}

header('Location: success.php');

?>