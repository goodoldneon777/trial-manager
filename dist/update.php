<?php
  $trialSeq = $_GET['trialseq'];
  $groupSeq = $_GET['groupseq'];

  if (!$groupSeq) {
    $pageType = 'trial';
    $html_updateBtn = '<button id="submit" type="button" class="btn btn-xlarge btn-success" data-toggle="tooltip" title="Update this trial.">Update Trial</button>';
    $html_deleteBtn = '<button id="delete" type="button" class="btn btn-xlarge btn-danger" data-toggle="tooltip" title="Permanently delete this trial.">Delete Trial</button>';
  } else {
    $pageType = 'group';
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

          create_info_trial('write', $trialSeq);
          create_commentList('write', $pageType, $trialSeq);
          create_heatData_trial('write', $trialSeq);
        } else if ($pageType === 'group') {
          require('php/dist/m-info-group.php');
          require('php/dist/m-commentList.php');
          require('php/dist/m-childList-group.php');

          create_info_group('write', $groupSeq);
          create_commentList('write', $pageType, $groupSeq);
          create_childList_group('write', $groupSeq);
        }
      ?>



      <div class="errorHolder"></div>

      <div style="text-align:center;">
        <?php
          echo $html_updateBtn;
          echo $html_deleteBtn;
        ?>
      </div>

		</div>



    
    <?php require('php/dist/m-HTMLfoot.php'); ?>
    
    <script src="js/dist/p-update.min.js"></script>


  </body>
</html>