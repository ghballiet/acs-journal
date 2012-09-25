<?
include_once('../includes/php/functions.php');
init();

$fn = $_POST['first_name'];
$ln = $_POST['last_name'];
$email = $_POST['email'];
$org = $_POST['organization'];
$addr = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$postal = $_POST['postal'];
$country = intval($_POST['country']);
$summary = $_POST['summary'];

$paper = $_FILES['paper'];
$fname = $paper['name'];
$ftype = $paper['type'];
$ftname = $paper['tmp_name'];
$ferror = $paper['error'];
$fsize = $paper['size'];

$dest = '../uploads/' . basename($ftname) . '.pdf';
move_uploaded_file($ftname, $dest);

$query = "insert into application values (NULL,?,?,?,?,?,?,?,?,?,?,?,'')";
$q = $db->prepare($query);
$q->bindParam(1, $fn);
$q->bindParam(2, $ln);
$q->bindParam(3, $email);
$q->bindParam(4, $org);
$q->bindParam(5, $addr);
$q->bindParam(6, $city);
$q->bindParam(7, $state);
$q->bindParam(8, $postal);
$q->bindParam(9, $country);
$q->bindParam(10, $summary);
$q->bindParam(11, $dest);
$success = $q->execute();

cleanup();

if($success) {
  $to = "$fn $ln <$email>";
  $subject = "ACS 2011 Application Confirmation";
  $body = '<style type="text/css">';
  $body .= '* { font-family:helvetica,arial,sans-serif; }';
  $body .= '</style>';
  $body .= "\n\n";
  $body .= "<p>$fn $ln,</p>";
  $body .= "<p>Thank you for your interest in the AAAI Fall 2011 ";
  $body .= "Symposium on Advances in Cognitive Systems. Your ";
  $body .= "application has been submitted and will be processed in ";
  $body .= "the order it was received.</p>";

  $headers = "From: ACS Mailer <donotreply@cogsys.org>\r\n";
  $headers .= "Reply-To: Pat Langley <langley@asu.edu>\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

  $s = 'ACS 2011 Application Submission';
  $b = '<style type="text/css">';
  $b .= '* { font-family: helvetica,arial,sans-serif; }';
  $b .= 'body { font-size: 14px; color: #222; }';
  $b .= 'p { line-height:1.4em; margin-bottom: 1.4em;}';
  $b .= '</style>';
  $b .= "\n\n";
  $b .= '<p>A new application was submitted with the following ';
  $b .= 'information:</p>';
  $b .= "<p><b>Name:</b> $fn $ln<br>";
  $b .= "<b>Email:</b> <a href=\"mailto:$email\">$email</a><br>";
  $b .= "<b>Organization:</b> $org<br>";
  $b .= "<b>Address:</b> $addr<br>";
  $b .= "<b>City:</b> $city<br>";
  $b .= "<b>State:</b> $state<br>";
  $b .= "<b>Country:</b> $country<br>";
  $b .= "<b>Postal:</b> $postal</p>";
  $b .= "<p><b>Summary:</b><br>";
  $b .= "$summary</p>";

  if($ftname != NULL) {
    $b .= "<p><b>Paper:</b> <a href=\"http://cogsys.org/acs/2011/uploads/";
    $b .= basename($ftname) . ".pdf\">View Paper</a></p>";
  }
  
  $t = "Glen Hunt <glenrhunt@asu.edu>";
  $h = "From: ACS Mailer <donotreply@cogsys.org>\r\n";
  $h .= "MIME-Version: 1.0\r\n";
  $h .= "Content-Type: text/html; charset-ISO-8859-1\r\n";
  mail($t, $s, $b, $h);
  

  if(mail($to, $subject, $body, $headers)) {
    // do something if mailing works
  } else {
    // send an email letting us know that the message
    // failed to send
    $s = "ACS Email Failure";
    $b = "Message delivery to $email failed during the application process.";
    $t = "glenrhunt@gmail.com";
    $h = "From: ACS Mailer <donotreply@cogsys.org>\r\n";
    mail($t,$s,$b,$h);    
  } 
  header('Location: success.php');
}

?>
