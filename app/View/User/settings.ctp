<div class="page-header">
   <h1>Account Settings
     <small>
<? printf('%s %s', $user['name'], $user['surname']); ?>
     </small>
   </h1>
</div>

<div class="row">
   <div class="span4">
     <div class="image well">
       <h3>Profile Image</h3>
<?
// TODO: make this work with Bootstrap Thumbnails
// http://twitter.github.com/bootstrap/components.html#thumbnails
echo $this->Profile->gravatar($user['email'], '100px');
?>
     </div>
   </div>
   <div class="span8">
   </div>
</div>
