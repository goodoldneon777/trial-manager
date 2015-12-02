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
        require('php/dist/m-trialInfo.php');
        create_trialInfo('write', $_GET['trialseq']);
      ?>


      <?php
        require('php/dist/m-trialComment-list.php');
        create_trialComment_list('write', $_GET['trialseq']);
      ?>


      <?php
        require('php/dist/m-trialHeatData.php');
        create_trialHeatData('write', $_GET['trialseq']);
      ?>


      <div id="error-box"></div>

      <div style="text-align:center;">
        <button id="submit" type="button" class="btn btn-xlarge btn-success" data-toggle="tooltip" title="Update this trial.">Update Trial</button>

        <button id="delete" type="button" class="btn btn-xlarge btn-danger" data-toggle="tooltip" title="Permanently delete this trial.">Delete Trial</button>
      </div>

		</div>



    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="plugin/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/dist/p-update.min.js"></script>


  </body>
</html>