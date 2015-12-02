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
        require('php/dist/m-trialInfo.php');
        create_trialInfo('readonly', $_GET['trialseq']);
      ?>


      <?php
        require('php/dist/m-trialComment-list.php');
        create_trialComment_list('readonly', $_GET['trialseq']);
      ?>


      <?php
        require('php/dist/m-trialHeatData.php');
        create_trialHeatData('readonly', $_GET['trialseq']);
      ?>
 

		</div>



    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="plugin/bootstrap/js/bootstrap.min.js"></script>


  </body>
</html>