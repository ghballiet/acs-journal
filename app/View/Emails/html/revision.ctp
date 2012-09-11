<div class="page-header">
  <h3>Thank you!</h3>
</div>

<p>Dear <? printf('%s %s', $User['name'], $User['surname']); ?>,</p>

<p>Your revised submission to <strong><? echo $Collection['title']
?></strong> has been received. You may view your revised submission by
clicking the link below:</p>

<p>
  <center>
    <a href="<? echo $url; ?>" class="btn btn-primary btn-large">View
    Revised Submission</a>
  </center>
</p>
