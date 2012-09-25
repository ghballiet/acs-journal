<?
// necessary includes
include_once('../includes/markdown.php');
include_once('../includes/functions.php');

function mail_student($asurite) {
  // the fields we want to use
  $id = query("select id from students where asurite='$asurite';");
  $first = get_info_by_id("first_name", $id);
  $last = get_info_by_id("last_name", $id);
  $name = "$first $last";
  $email = get_info_by_id("email", $id);
  $course = "CSE " . get_info_by_id("course", $id);
  $hash = get_hash($id);
  $url = "http://circas.asu.edu/aicogsys/grading/view.php?id=$hash";

  $body = "";
  $text = "";

  // pull in the stylesheet
  $body .= '<style type="text/css">';
  $body .= file_get_contents('../includes/email.css');
  $body .= '</style>';
  $body .= "\n\n";

  $text .= "Hello $first,\n\n";
  $text .= "This message is to inform you that you can now view your grades\n";
  $text .= "for  **$course** online at:\n\n";
  $text .= "[$url]($url)\n\n";
  $text .= "**Please bookmark this URL,** as you will need it to view your grades\n";
  $text .= "in this course.\n\n";
  $text .= "Best,  \n";
  $text .= "Glen Hunt\n\n";

  $body .= Markdown($text);

  // email stuff
  $from = "CIRCAS Mailer <donotreply@circas.asu.edu>";
  $to = "$name <$email>";
  $reply_to = "Glen Hunt <glenrhunt@asu.edu>";
  $mime = "MIME-Version: 1.0";
  $content_type = "text/html; charset=ISO-8859-1";
  $bcc = "<glenrhunt@asu.edu>";
  $subject = "[ $course ] View Your Grades Online";
  $headers = "";

  // set up headers
  $headers .= "From: $from\r\n";
  $headers .= "Reply-To: $reply_to\r\n";
  $headers .= "$mime\r\n";
  $headers .= "Content-Type: $content_type\r\n";
  $headers .= "Bcc: $bcc\r\n";

  // actually try to send mail
  if(mail($to, $subject, $body, $headers)) {
    echo "Mail succesfully sent to $to.\n";
  }
}

$students = explode("\n", query("select asurite from students order by asurite;"));

foreach($students as $s) {
  mail_student($s);
}

?>