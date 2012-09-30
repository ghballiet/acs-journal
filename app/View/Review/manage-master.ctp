<div class="page-header">
  <h1>Manage Reviews</h1>
</div>

<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active">
      <a href="#mine" data-toggle="tab">My Reviews</a>
    </li>
    <? foreach($user_roles as $role): ?>
    <li>
      <a href="#<? echo $role['Collection']['slug']; ?>" data-toggle="tab">
        <? echo $role['Collection']['title']; ?>
      </a>
    </li>
    <? endforeach; ?>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="mine">
      <!-- reviews assigned to this user -->
      <? pr($mine); ?>
    </div>
    <? foreach($user_roles as $role): ?>
    <div class="tab-pane" id="<? echo $role['Collection']['slug'];?>">
      
    </div>
    <? endforeach; ?>
  </div>
</div>
