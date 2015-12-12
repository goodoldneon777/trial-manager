<?php
  $trialSeq = $_GET['trialseq'];
  $groupSeq = $_GET['groupseq'];

  if (!$groupSeq) {
    $type = 'trial';
  } else {
    $type = 'group';
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

        if ($type === 'trial') {
          require('php/dist/m-trialInfo.php');
          require('php/dist/m-trialComment-list.php');
          require('php/dist/m-trialHeatData.php');

          create_trialInfo('readonly', $trialSeq);
          create_trialComment_list('readonly', $trialSeq);
          create_trialHeatData('readonly', $trialSeq);
        } else if ($type === 'group') {
          require('php/dist/m-groupInfo.php');

          create_groupInfo('write', $groupSeq);

        }
      ?>

		</div>



    <?php require('php/dist/m-HTMLfoot.php'); ?>


  </body>
</html>