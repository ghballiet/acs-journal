<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<?
// TODO: this needs to read the file contents, and dump it here
// between a couple of style tags.
$css = $this->Html->url('/css/email.css', true);
printf('<link type="text/css" rel="stylesheet" href="%s" />', $css);
echo $this->fetch('css');
?>
</head>
<body>
  <div class="main">
<? echo $content_for_layout; ?>
  </div>
</body>
</html>
