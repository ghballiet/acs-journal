<?
$_POST['page_title'] = 'Manage Reviewers';
$_POST['extra_css'] = array('manage.css');
$_POST['loginRequired'] = md5(true);
$_POST['adminRequired'] = md5(true);

include_once('../template/before.php');
include_once('../includes/php/reviewers.php');
?>

<fieldset>
  <h1>Add User</h1>
  <form method="post" action="addReviewer.php">
    <section>
      <label for="name">Name</label>
      <input type="text" name="name" id="name"
        placeholder="Name" spellcheck="false" autofocus>
    </section>
    <section>
      <label for="surname">Surname</label>
      <input type="text" name="surname" id="surname"
        placeholder="Surname" spellcheck="false">
    </section>
    <section>
      <label for="email">Electronic Mail</label>
      <input type="email" name="email" id="email"
        placeholder="Electronic Mail" spellcheck="false">
    </section>
    <section>
      <label for="admin">Administrator?</label>
      <input type="checkbox" name="admin" id="admin">
    </section>
    <section>
      <input type="submit" value="Add">
    </section>
  </form>
</fieldset>

<fieldset>
  <h1>Reviewers</h1>
  <section class="table">
    <? getReviewers(); ?>
  </section>
</fieldset>

<fieldset>
  <h1>Administrators</h1>
  <section class="table">
    <? getAdmins(); ?>
  </section>
</fieldset>

<?
include_once('../template/after.php');
?>