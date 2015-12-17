<?php

  if (isset($_GET['trialseq'])) {
    $pageType = 'trial';
    $seq = $_GET['trialseq'];
    $pageTitle = 'Trial Manager - View Trial';
    $html_updateBtn = '<button id="submit" type="button" class="btn btn-xlarge btn-success" data-toggle="tooltip" title="Update this trial.">Update Trial</button>';
    $html_deleteBtn = '<button id="delete" type="button" class="btn btn-xlarge btn-danger" data-toggle="tooltip" title="Permanently delete this trial.">Delete Trial</button>';
  } else if (isset($_GET['groupseq'])) {
    $pageType = 'group';
    $seq = $_GET['groupseq'];
    $pageTitle = 'Trial Manager - View Group';
    $html_updateBtn = '<button id="submit" type="button" class="btn btn-xlarge btn-success" data-toggle="tooltip" title="Update this group.">Update Group</button>';
    $html_deleteBtn = '<button id="delete" type="button" class="btn btn-xlarge btn-danger" data-toggle="tooltip" title="Permanently delete this group.">Delete Group</button>';
  }

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trial Manager - Update Trial</title>

    <?php
      require(SERVER_ROOT . '/module/html_head/module.php');

      create_html_head();
    ?>

  </head>
  <body>


    <?php
      require(SERVER_ROOT . '/module/nav_bar/module.php');
    
      create_nav_bar();
    ?>


    <div id="l-body">

      <?php
        require(SERVER_ROOT . '/module/info/module.php');
        require(SERVER_ROOT . '/module/comment_list/module.php');

        create_info('write', $pageType, $seq);
        create_comment_list('write', $pageType, $seq);


        if ($pageType === 'trial') {
          require(SERVER_ROOT . '/module/heat_data/module.php');

          create_heat_data('write', $seq);
        } else if ($pageType === 'group') {
          require(SERVER_ROOT . '/module/child_list/module.php');

          create_child_list('write', $seq);
        }
      ?>

      <?php

        // if ($pageType === 'trial') {
        //   require('php/dist/m-info-trial.php');
        //   require('php/dist/m-commentList.php');
        //   require('php/dist/m-heatData-trial.php');

        //   create_info_trial('write', $trialSeq);
        //   create_commentList('write', $pageType, $trialSeq);
        //   create_heatData_trial('write', $trialSeq);
        // } else if ($pageType === 'group') {
        //   require('php/dist/m-info-group.php');
        //   require('php/dist/m-commentList.php');
        //   require('php/dist/m-childList-group.php');

        //   create_info_group('write', $groupSeq);
        //   create_commentList('write', $pageType, $groupSeq);
        //   create_childList_group('write', $groupSeq);
        // }
      ?>



      <div class="errorHolder"></div>

      <div style="text-align:center;">
        <?php
          echo $html_updateBtn;
          echo $html_deleteBtn;
        ?>
      </div>

		</div>



    
    <?php
      require(SERVER_ROOT . '/module/html_foot/module.php');

      create_html_foot();
    ?>

    <!--
    <script src="js/dist/p-update.min.js"></script>
-->

  </body>
</html>