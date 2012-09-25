<?
session_start();
include_once('../includes/php/session.php');

$email = $_POST['email'];
$pass = md5($_POST['password']);

checkLogin($email, $pass);

?>