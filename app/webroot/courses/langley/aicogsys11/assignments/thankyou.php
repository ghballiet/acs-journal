<?
$_POST['page_title'] = "Thank you for your submission.";
$email = $_GET['email'];
include_once("../template/before.php");

$str = "Your submission has been processed.\n\nA confirmation email with the details of your submission has been sent to **";
$str .= $email . "**.";

echo Markdown($str);

include_once("../template/after.php");
?>