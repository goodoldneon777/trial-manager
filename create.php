<?php
  if (!isset($_GET['type'])) {
    $type = 'trial';
  } else {
    $type = $_GET['type'];
  }

  if ($type === 'trial') {
    $html_title = '<title>Trial Manager - Create Trial</title>';
    $html_submitBtn = '<button id="submit" type="button" class="btn btn-xlarge btn-success" data-toggle="tooltip" title="Create this trial.">Create Trial</button>';
  } else if ($type === 'group') {
    $html_title = '<title>Trial Manager - Create Group</title>';
    $html_submitBtn = '<button id="submit" type="button" class="btn btn-xlarge btn-success" data-toggle="tooltip" title="Create this group.">Create Group</button>';
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->


    <?php 
      echo $html_title;

      require('php/dist/m-HTMLhead.php'); 
    ?>

    
  </head>
  <body>


    <?php require('php/dist/m-navBar.php'); ?>


    <div id="l-body">

      <?php

        require('php/dist/m-trialGroupBtn.php');
        create_trialGroupBtn($type);


        if ($type === 'trial') {
          require('php/dist/m-info-trial.php');
          require('php/dist/m-heatData-trial.php');

          create_info_trial('write');
          create_heatData_trial('write');

        } else if ($type === 'group') {
          require('php/dist/m-info-group.php');

          create_info_group('write');

        }
      ?>



      <div class="errorHolder"></div>

      <div style="text-align:center;">
        <?php echo $html_submitBtn; ?>
      </div>

    </div>



    
    <?php require('php/dist/m-HTMLfoot.php'); ?>

    <script src="js/dist/p-create.min.js"></script>


  </body>
</html>