<?
$this->start('css');
echo $this->Html->css('submit');
$this->end();

$this->start('scripts');
echo $this->Html->script('create_submission');
$this->end();
?>

<div class="page-header">
  <h1>Submit Revision</h1>
</div>

<?
echo $this->BootstrapForm->create('Submission', array('type'=>'file'));
?>
<h3>Submission Information</h3>
<?
echo $this->BootstrapForm->input('previous_submission', array(
  'type'=>'hidden', 'value'=>$submission['Submission']['id']));
echo $this->BootstrapForm->input('collection_id', array(
  'type'=>'hidden', 'value'=>$submission['Submission']['collection_id']));
echo $this->BootstrapForm->input('title', array('icon'=>'pencil'));
echo $this->BootstrapForm->input('abstract', array('icon'=>'align-justify'));

// build the list of keywords
$words = array();
foreach($submission['Keyword'] as $keyword)
  $words[] = $keyword['value'];
$keywords = implode(', ', $words);

echo $this->BootstrapForm->input('Keyword', array('icon'=>'tag',
                                                  'required'=>false,
                                                  'value' => $keywords));

// TODO: add keywords

echo $this->BootstrapForm->input('Upload', array('type'=>'file'));
echo $this->BootstrapForm->input('pages', array('icon'=>'paper-clip'));

$add_btn = $this->Html->link('Add Coauthor', '#', array('class'=>'btn btn-mini add-coauthor'));
?>
<h3>Coauthors</h3>
<div class="coauthor base">
<?
// TODO: add code here to rebuild the full list of coauthors (if sent in request data)
$coauthors = $submission['Coauthor'];

$next_num = count($coauthors);

foreach($coauthors as $i=>$ca) {
  echo $this->BootstrapForm->input(
    sprintf('Coauthor.%d.name', $next_num),
    array('label'=>'Name', 'required'=>false, 'icon'=>'user'));
  echo $this->BootstrapForm->input(
    sprintf('Coauthor.%d.email', $next_num),
    array('label'=>'Email', 'type'=>'email', 'required'=>false,
          'icon'=>'envelope'));
  echo $this->BootstrapForm->input(
    sprintf('Coauthor.%d.institution', $next_num),
    array('label'=>'Institution', 'required'=>false, 
          'icon'=>'home'));
}

echo $this->BootstrapForm->input(
  sprintf('Coauthor.%d.name', $next_num),
  array('label'=>'Name', 'required'=>false, 'icon'=>'user'));
echo $this->BootstrapForm->input(
  sprintf('Coauthor.%d.email', $next_num),
  array('label'=>'Email', 'type'=>'email', 'required'=>false,
        'icon'=>'envelope'));
echo $this->BootstrapForm->input(
  sprintf('Coauthor.%d.institution', $next_num),
  array('label'=>'Institution', 'required'=>false, 
        'icon'=>'home'));
?>
</div>
<?
echo $add_btn;
echo $this->BootstrapForm->end('Submit Revision');
?>
