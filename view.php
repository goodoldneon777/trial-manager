<?php
  $trialSeq = $_GET['trialseq'];
  $groupSeq = $_GET['groupseq'];

  if (!$groupSeq) {
    $pageType = 'trial';
  } else {
    $pageType = 'group';
  }

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trial Manager - View Trial</title>

    <?php require('php/dist/m-HTMLhead.php'); ?>

  </head>
  <body>


    <?php require('php/dist/m-navBar.php'); ?>


    <div id="l-body">

      <?php

        if ($pageType === 'trial') {
          require('php/dist/m-info-trial.php');
          require('php/dist/m-commentList.php');
          require('php/dist/m-heatData-trial.php');

          create_info_trial('readonly', $trialSeq);
          create_commentList('readonly', $pageType, $trialSeq);
          create_heatData_trial('readonly', $trialSeq);
        } else if ($pageType === 'group') {
          require('php/dist/m-info-group.php');
          require('php/dist/m-commentList.php');

          create_info_group('readonly', $groupSeq);
          create_commentList('readonly', $pageType, $groupSeq);

        }
        
      ?>

		</div>



    <?php require('php/dist/m-HTMLfoot.php'); ?>


  </body>
</html>