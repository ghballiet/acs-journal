<div class="page-header">
  <h1><? echo $name; ?></h1>
</div>
<p class="alert alert-error">
	<strong><?php echo __d('cake', 'Something went wrong.'); ?>: </strong>
	<?php echo __d('cake', 'An internal error has occured.'); ?>
</p>
<?php
if (Configure::read('debug') > 0 ):
	echo $this->element('exception_stack_trace');
endif;
?>
