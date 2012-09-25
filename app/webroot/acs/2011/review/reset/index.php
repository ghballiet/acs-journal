<?
$_POST['page_title'] = 'Password Reset';
$_POST['extra_css'] = array('login.css');
$_POST['loginRequired'] = md5(true);
$_POST['hideMenu'] = true;
include_once('../template/before.php');
?>

<h1>Password Change Required</h1>
<p>Before continuing, you need to enter a new password.</p>

<?
if(isset($_GET['error'])) {
  $err = $_GET['error'];
  echo '<p class="error">';
  switch($err) {
    case 1:
      echo 'Current password is incorrect.';
      break;
    case 2:
      echo 'Passwords do not match.';
      break;
    case 3:
      echo 'Please fill in all required fields.';
      break;
  }
  echo '</p>';
}
?>

<form method="post" action="reset.php">
  <label for="oldPass">Current Password</label>
  <input type="password" name="oldPass"  id="oldPass"
    placeholder="current password">
  <label for="pass1">New Password</label>
  <input type="password" name="pass1"  id="pass1"
    placeholder="new password">
  <label for="pass2">Confirm New Password</label>
  <input type="password" name="pass2"  id="pass2"
    placeholder="confirm new password">
  <input type="hidden" name="userID"
    value="<?echo md5($_SESSION['userID']);?>">
  <input type="submit" value="Change Password">
</form>

<?
include_once('../template/after.php');
?>