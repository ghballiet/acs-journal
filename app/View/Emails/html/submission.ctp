<div class="page-header">
  <h3>Thank you!</h3>
</div>

<p>Dear <? printf('%s %s', $User['name'], $User['surname']); ?>,</p>

<p>Thank you for your submission to <strong><? echo
$Collection['title'] ?></strong>. You may view your submission by
clicking the link below:</p>

<p>
  <center>
    <a href="<? echo $url; ?>" class="btn btn-primary btn-large">View
    Submission</a>
  </center>
</p>
