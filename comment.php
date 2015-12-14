<?php
  if (isset($_GET['trialseq'])) {
    $pageType = 'trial';
    $trialSeq = $_GET['trialseq'];
    $html_title = 'Trial Manager - View Trial';
  } else if (isset($_GET['groupseq'])) {
    $pageType = 'group';
    $groupSeq = $_GET['groupseq'];
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
    <title>Trial Manager - Add Comment</title>

    <?php require('php/dist/m-HTMLhead.php'); ?>

  </head>
  <body>


    <?php require('php/dist/m-navBar.php'); ?>


    <div id="l-body">

      <?php

        if ($type === 'trial') {
          require('php/dist/m-info-trial.php');
          create_info_trial('readonly', $trialSeq);
        } else if ($type === 'group') {
          require('php/dist/m-info-group.php');
          create_info_group('readonly', $groupSeq);
        }
        
      ?>



      <?php require('php/dist/m-commentAdd.php'); ?>


      <div class="errorHolder"></div>


			<div style="text-align:center;">
				<button id="submit" type="button" class="btn btn-xlarge btn-success" data-toggle="tooltip" title="Upload this trial to the database. Everything can be modified later on the 'Update' page.">Submit Comment</button>
			</div>

			<br><br><br>

		</div>



    <?php require('php/dist/m-HTMLfoot.php'); ?>
    
    <script src="js/dist/p-comment.min.js"></script>

  </body>
</html>