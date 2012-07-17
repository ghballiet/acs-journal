<div class="page-header">
   <h1>Account Settings
     <small>
<? printf('%s %s', $user['name'], $user['surname']); ?>
     </small>
   </h1>
</div>

<div class="row">
   <div class="span3">
     <ul class="thumbnails">
       <li>
         <div class="thumbnail">
<? echo $this->Profile->gravatar($user['email'], '260px'); ?>           
           <div class="caption">
             <h4>Profile Image</h4>
             <p>You can change your avatar on
               <a href="http://gravatar.com/emails/">gravatar.com</a>.</p>
           </div>
         </div>
       </li>
     </ul>
   </div>
   <div class="span8">
   </div>
</div>
