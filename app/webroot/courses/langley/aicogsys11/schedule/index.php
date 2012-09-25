<?php
$_POST['page_title'] = 'Spring 2011 Schedule';
include_once('../template/before.php');
?>
                <div id="nav_left">
                    <strong>Jump to Date</strong>
                    <ul></ul>
                </div>
                <div id="schedule">
                    <? echo mark_file('01 jan.txt'); ?>
                    <? echo mark_file('02 feb.txt'); ?>        
                    <? echo mark_file('03 march.txt'); ?>
                    <? echo mark_file('04 april.txt'); ?>
                    <? echo mark_file('05 may.txt'); ?>
                </div>
            </div>
            <div class="clearfix"></div>
            <script type="text/javascript">
            $(document).ready(function() {
               add_names(); 
            });
            </script>
<?php
include_once('../template/after.php');
?>
