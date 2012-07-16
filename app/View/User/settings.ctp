<div class="page-header">
   <h1>Account Settings
     <small>
<? printf('%s %s', $user['name'], $user['surname']); ?>
     </small>
   </h1>
</div>

<div class="row">
   <div class="span4">
     <h3>Profile Image</h3>
<?
echo $this->Profile->gravatar($user['email'], '100px');
?>
   </div>
   <div class="span8">
   </div>
</div>