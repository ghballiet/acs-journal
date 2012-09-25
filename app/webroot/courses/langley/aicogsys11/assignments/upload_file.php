<?php
include_once('../includes/markdown.php');
$asurite = $_POST['asurite'];
$email = $_POST['email'];
$ex = $_POST['exercise'];
$ts = $_POST['timestamp'];
$addr = $_POST['remote_addr'];
$host = $_POST['remote_host'];
$port = $_POST['remote_port'];
$agent = $_POST['user_agent'];
$name = $_POST['name'];
$course = $_POST['course'];
$msg = "";

// check all required fields

$upload_dir = "/home/grhunt1/cse598_files/" . $course . "/ex" . $ex . "/" . $asurite . "/";

mkdir($upload_dir, 0777, true);

foreach($_FILES as $f) {
  $src = $f['tmp_name'];
  $dest = $upload_dir . $f['name'];
  move_uploaded_file($src, $dest);
}

// email stuff
$fmt = "| %-15s | %-150s |\n";

// pull in the appropriate css stylesheet
$body = '<style type="text/css">';
$body .= file_get_contents('../includes/email.css');
$body .= '</style>';

$body2 = '<style type="text/css">';
$body2 .= file_get_contents('../includes/email.css');
$body2 .= '</style>';

$body .= "\n\n# Upload Information\n";
$body .= sprintf($fmt, "", "");
$body .= sprintf($fmt, "---------------", "-------------------------------------------");
$body .= sprintf($fmt, "Name", $name);
$body .= sprintf($fmt, "Course", $course);
$body .= sprintf($fmt, "Timestamp", date("r",$ts));
$body .= sprintf($fmt, "ASURITE", $asurite);
$body .= sprintf($fmt, "Email", '[' . $email . '](mailto:' . $email . ')');
$body .= sprintf($fmt, "Assignment", "Exercise " . $ex);
$body .= sprintf($fmt, "Remote IP", $addr);
$body .= sprintf($fmt, "Remote Host", $host);
$body .= sprintf($fmt, "Remote Port", $port);
$body .= sprintf($fmt, "User Agent", $agent);

$body2 .= "\n\n# Upload Confirmation\n";
$body2 .= sprintf($fmt, "", "");
$body2 .= sprintf($fmt, "---------------", "-------------------------------------------");
$body2 .= sprintf($fmt, "Name", $name);
$body2 .= sprintf($fmt, "Course", $course);
$body2 .= sprintf($fmt, "Timestamp", date("r",$ts));
$body2 .= sprintf($fmt, "ASURITE", $asurite);
$body2 .= sprintf($fmt, "Email", '[' . $email . '](mailto:' . $email . ')');
$body2 .= sprintf($fmt, "Assignment", "Exercise " . $ex);

$body .= "# File Information\n";
$count = 1;

foreach($_FILES as $f) {
  $body .= "## File " . $count . "\n";
  $body .= sprintf($fmt, "", "");
  $body .= sprintf($fmt, "---------------", "-------------------------------------------");
  $body .= sprintf($fmt, "Name", $f['name']);
  $body .= sprintf($fmt, "Type", $f['type']);
  $body .= sprintf($fmt, "Temp Name", $f['tmp_name']);
  $body .= sprintf($fmt, "Path", $upload_dir . $f['name']);
  $body .= sprintf($fmt, "Size", $f['size']);
  $body .= sprintf($fmt, "Error", $f['error']);

  $body2 .= '## File ' . $count . "\n";
  $body2 .= sprintf($fmt, "", "");
  $body2 .= sprintf($fmt, "---------------", "-------------------------------------------");
  $body2 .= sprintf($fmt, "Name", $f['name']);
  // $body2 .= sprintf($fmt, "Type", $f['type']); CHANGED: on second thought, probably unneccesary
  $body2 .= sprintf($fmt, "Size", $f['size']);

  $count++;
}

$body = Markdown($body);
$body2 = Markdown($body2);

$headers = "From: CIRCAS Mailer <donotreply@circas.asu.edu>\r\n";
$headers .= "Reply-To: Glen Hunt <glenrhunt@asu.edu>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$to = "glenrhunt@asu.edu";
// $subject = "Exercise " . $ex . " uploaded by " . $asurite . " (" . $email . ")";
$subject = "Exercise " . $ex . " uploaded by " . $name . " (" . $asurite . ")";

$to2 = $email;
$subject2 = "Exercise " . $ex . " Submission";


if(mail($to2, $subject2, $body2, $headers)) {
  mail($to, $subject, $body, $headers);
  header('Location: thankyou.php?email=' . $email);
} else {
  // do something if there's an error.
}


?>