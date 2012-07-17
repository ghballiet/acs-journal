<?
$this->start('css');
echo $this->Html->css('settings');
$this->end();
?>

<div class="page-header">
   <h1>Account Settings
     <small>
<? printf('%s %s', $user['name'], $user['surname']); ?>
     </small>
   </h1>
</div>

<div class="row">
   <div class="span2">
     <ul class="thumbnails">
       <li>
         <div class="thumbnail">
           <a href="http://gravatar.com/emails/">
<? echo $this->Profile->gravatar($user['email'], '160px'); ?>           
           </a>
           <div class="caption">
             <h4>Profile Image</h4>
             <p>You can change your avatar on
               <a href="http://gravatar.com/emails/">gravatar.com</a>.</p>
           </div>
         </div>
       </li>
     </ul>
   </div>
   <div class="span10">
   </div>
</div>
