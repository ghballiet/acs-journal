<div class="page-header">
  <h1>Welcome!</h1>
</div>

<p>Dear <? printf('%s %s', $user['name'], $user['surname']); ?>,</p>

<p>Thank you for creating an account with the Cognitive Systems
Foundation. Your account information is given below:</p>

<table class="table table-condensed">
  <tr>
    <th>Name</th>
    <td><? printf('%s %s', $user['name'], $user['surname']); ?></td>
  </tr>
  <tr>
    <th>Email</th>
    <td><? echo $user['email']; ?></td>
  </tr>
</table>

<hr />

<p>The ACS Robot</p>
