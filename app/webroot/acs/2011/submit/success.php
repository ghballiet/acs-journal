<?

mark_file('success.txt');

function sendConfirmationEmail($data) {
  $txt = file_get_contents('email.txt');
  $ca = '';
  $caEmails = array();
  
  $num = intval($data['paperNumCoauthors']);

  for($i=1; $i<=$num; $i++) {
    $ca .= sprintf('- **%s:** [%s](mailto:%s), %s',
      $data['caName' . $i], $data['caEmail' . $i],
      $data['caEmail' . $i], $data['caInstitution' . $i]);
    
    $caEmails[] = sprintf('%s <%s>', $data['caName' . $i],
      $data['caEmail' . $i]);
  }
  
  $data['coauthors'] = $ca;
  
  foreach($data as $k => $v) {
    $txt = str_replace('?' . $k, $v, $txt);
  }
  
  $mdTxt = Markdown($txt);
  
  $subject = 'ACS 2011 Submission Confirmation';
  $css = file_get_contents('email.css');
  $body = '<style type="text/css">' . $css . "</style>\n\n";
  $body .= $mdTxt;
  
  $headers = "From: ACS Mailer <donotreply@cogsys.org>\r\n";
  $headers .= "Reply-To: Pat Langley <langley@asu.edu>\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  $headers .= sprintf("Cc: %s\r\n", implode(', ', $caEmails));
  $headers .= "Bcc: Glen Hunt <glenrhunt@asu.edu>\r\n";
  
  
  $to = sprintf(' %s <%s>', $data['name'] . ' ' . $data['surname'], $data['email']);
  
  $success = mail($to, $subject, $body, $headers);  
}

?>