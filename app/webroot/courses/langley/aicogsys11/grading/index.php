<?
$_POST['page_title'] = 'Grading';
include_once('../template/before.php');
?>
<form style="text-align:center" action="check_asurite.php" method="post"/>
  <p style="margin-top: 4em"><input type="text" class="big" name="asurite" id="asurite" placeholder="ASURITE" tabindex=1/></p>
  <p><input type="password" class="big" name="password" id="password" placeholder="super secret password" tabindex=2/></p>
  <p><input type="submit" value="Continue"/></p>
</form>
<?
include_once('../template/after.php');
?>
