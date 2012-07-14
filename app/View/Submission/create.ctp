<div class="page-header">
  <h1>Submit Paper</h1>
</div>

<?
echo $this->BootstrapForm->create('Submission', array('type'=>'file'));
?>
<div class="row">
  <div class="span7">
   <div class="left">
<?
echo $this->BootstrapForm->input('collection_id', array('label'=>'Venue', 'autofocus'=>true));
echo $this->BootstrapForm->input('title');
echo $this->BootstrapForm->input('abstract');
echo $this->BootstrapForm->input('Upload', array('type'=>'file'));
?>
    </div>
  </div>
  <div class="span5">
    <div class="right">
<?
echo $this->Html->link('Add Coauthor', '#', array('class'=>'btn btn-mini pull-right'));
echo $this->Html->tag('h4', 'Coauthors');
?>
      <div class="coauthor">
<?
echo $this->BootstrapForm->input('Coauthor.0.name', array('label'=>'Name'));
echo $this->BootstrapForm->input('Coauthor.0.email', array('label'=>'Email'));
echo $this->BootstrapForm->input('Coauthor.0.institution', array('label'=>'Institution'));
?>
      </div>
    </div>
  </div>
</div>
<?
echo $this->BootstrapForm->end('Submit');
?>
