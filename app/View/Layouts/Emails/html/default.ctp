<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<?
echo $this->Html->url($this->Html->css('email'), true);
echo $this->fetch('css');
?>
</head>
<body>
	<?php echo $content_for_layout;?>
</body>
</html>
