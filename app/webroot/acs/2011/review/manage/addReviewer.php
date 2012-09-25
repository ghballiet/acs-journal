<?
session_start();
include_once('../includes/php/session.php');
loginRequired();
adminRequired();

$name = trim($_POST['name']);
$surname = trim($_POST['surname']);
$email = trim($_POST['email']);
$admin = $_POST['admin'];

// useful, but not at the moment
$password = generatePassword();

$admin = ($admin == 'on');

if(!$admin)
  $admin = 0;
  
$admin = intval($admin);

$valid = ($name!=null && $surname!=null && $email!=null);

if(!$valid)
  header('Location: ../manage/');
  
$q = 'INSERT INTO user VALUES (NULL, :name, :surname, :email, ' .
  ':password, :isAdmin)';
$arr = array(':name'=>$name, ':surname'=>$surname,
  ':email'=>$email, ':password'=>md5($password), ':isAdmin'=>$admin);  
pStmt($q, $arr);

$body = '<p>Welcome to the ACS 2011 Paper Review System. Your ' .
  'login information is below: </p>';
$body .= '<ul>';
$body .= sprintf('<li><b>Email:</b> %s</li>', $email);
$body .= sprintf('<li><b>Password:</b> %s</li>', $password);
$body .= '</ul>';

$body .= '<p><b>Note:</b> this password was generated ' . 
  'automatically by the system. The first time you login, you ' . 
  'will be asked to change it.</p>';
$body .= '<p>Please direct any questions regarding the login ' .
  'process to <a href="mailto:glenrhunt@asu.edu">Glen ' .
  'Hunt</a>. All other inquiries should be directed to ' .
  'the program chair, <a href="mailto:langley@asu.edu">Pat ' .
  'Langley</a>.</p>';

$subject = 'ACS 2011 Reviewer Account Information';

$headers = "From: ACS Mailer <donotreply@cogsys.org>\r\n";
$headers .= "Reply-To: Glen Hunt <glenrhunt@asu.edu>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$headers .= "Bcc: Glen Hunt <glenrhunt@asu.edu>\r\n";

$to = $name . ' ' . $surname . '<' . $email . '>';

mail($to, $subject, $body, $headers);
  
header('Location: ../manage/');
?>