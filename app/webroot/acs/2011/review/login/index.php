<?
$_POST['page_title'] = 'Login';
$_POST['extra_css'] = array('login.css');
$_POST['goHome'] = md5(true);
include_once('../template/before.php');
?>

<h1>Welcome.</h1>
<h2>Please log in to continue.</h2>
<form method="post" action="login.php">
  <label for="email">Email</label>
  <input type="email" name="email" id="email"
    placeholder="email" spellcheck="false">
  <label for="password">Password</label>
  <input type="password" name="password" id="password"
    placeholder="password">
  <input type="submit" value="Log In">
</form>

<?
include_once('../template/after.php');
?>