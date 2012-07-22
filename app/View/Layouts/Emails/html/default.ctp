<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<?
$css = $this->Html->url('/css/email.css', true);
printf('<link type="text/css" rel="stylesheet" href="%s" />', $css);
echo $this->fetch('css');
?>
</head>
<body>
  <div class="container">
<? echo $content_for_layout; ?>
  </div>
</body>
</html>
