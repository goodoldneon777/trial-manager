<?php
  if (isset($_GET['trialseq'])) {
    $pageType = 'trial';
    $seq = $_GET['trialseq'];
    $html_title = 'Trial Manager - View Trial';
  } else if (isset($_GET['groupseq'])) {
    $pageType = 'group';
    $seq = $_GET['groupseq'];
    $html_title = 'Trial Manager - View Group';
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $html_title; ?></title>

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

        create_info('readonly', $pageType, $seq);
        create_comment_list('readonly', $pageType, $seq);


        if ($pageType === 'trial') {
          require(SERVER_ROOT . '/module/heat_data/module.php');

          create_heat_data('readonly', $seq);
        } else if ($pageType === 'group') {
          require(SERVER_ROOT . '/module/child_list/module.php');

          create_child_list('readonly', $seq);
        }
      ?>

      <?php

        // if ($pageType === 'trial') {
        //   require('php/dist/m-info-trial.php');
        //   require('php/dist/m-commentList.php');
        //   require('php/dist/m-heatData-trial.php');

        //   create_info_trial('readonly', $trialSeq);
        //   create_commentList('readonly', $pageType, $trialSeq);
        //   create_heatData_trial('readonly', $trialSeq);
        // } else if ($pageType === 'group') {
        //   require('php/dist/m-info-group.php');
        //   require('php/dist/m-commentList.php');
        //   require('php/dist/m-childList-group.php');

        //   create_info_group('readonly', $groupSeq);
        //   create_commentList('readonly', $pageType, $groupSeq);
        //   create_childList_group('readonly', $groupSeq);
        // }
        
      ?>

		</div>



    <?php
      require(SERVER_ROOT . '/module/html_foot/module.php');

      create_html_foot();
    ?>


  </body>
</html>