<div class="page-header">
<?
   echo $this->Html->link('Create Collection',
                          array('controller'=>'collections', 'action'=>'add'),
                          array('class'=>'pull-right btn btn-primary'));
?>
  <h1>Manage Collections</h1>
</div>

<?
   pr($collections);
?>