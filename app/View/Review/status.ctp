<div class="page-header">
  <h1>Manage Reviews</h1>
</div>

<p class=" alert alert-info">
  Click the paper title to see reviews. 
</p>

<div class="accordion" id="reviews">
  <? foreach($papers as $slug=>$reviews): ?>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#reviews" href="#<? echo $slug; ?>">
        <? echo sprintf('<span class="pull-right">%s</span> %s', $authors[$slug]['full_name'], $titles[$slug]); ?>
      </a>
    </div>
    <div class="accordion-body collapse" id="<? echo $slug; ?>">
      <div class="accordion-inner">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>Reviewer</th>
              <th>Questions Answered</th>
              <!-- <th>Progress</th> -->
              <th></th>
            </tr>
          </thead>
          <tbody>
            <? foreach($reviews as $id=>$review): ?>
            <?
               $progress = count($review['Answer']) / $questions * 100;
               $remaining = 100 - $progress;
            ?>
            <tr>
              <td><? echo $this->Profile->badge($review['User']); ?></td>
              <td><? echo count($review['Answer'])?> / <? echo $questions; ?></td>
              <!--<td>
                <div class="progress">
                  <div class="bar bar-success" style="width: <? echo $progress; ?>%"></div>
                  <div class="bar bar-danger" style="width: <? echo $remaining; ?>%"></div>
                </div>
              </td> -->
              <td>
                <a href="<? echo $this->Html->url(array('action'=>'view', $id), true);?>" class="btn btn-primary pull-right">
                  View Review<i class="icon-chevron-right" style="margin-left:10px"></i>
                </a>
              </td>
            </tr>
            <? endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <? endforeach; ?>
</div>
