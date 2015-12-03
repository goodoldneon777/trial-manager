<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trial Manager - Create Trial</title>

    <?php require('php/dist/m-HTMLhead.php'); ?>
    
  </head>
  <body>


    <?php require('php/dist/m-navBar.php'); ?>


    <div id="l-body">

      <?php
        require('php/dist/m-trialInfo.php');
        create_trialInfo('write');
      ?>


      <?php
        require('php/dist/m-trialHeatData.php');
        create_trialHeatData('write');
      ?>


      <div class="errorHolder"></div>

      <div style="text-align:center;">
        <button id="submit" type="button" class="btn btn-xlarge btn-success" data-toggle="tooltip" title="Update this trial.">Create Trial</button>
      </div>

    </div>



    
    <?php require('php/dist/m-HTMLfoot.php'); ?>

    <script src="js/dist/p-create.min.js"></script>


  </body>
</html>