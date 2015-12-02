<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trial Manager - Recent/Upcoming Trials</title>

    <?php require('php/dist/m-HTMLhead.php'); ?>


  </head>
  <body>


    <?php require('php/dist/m-navBar.php'); ?>

    

    <div id="l-body">

			<?php require('php/dist/m-upcoming-trials.php'); ?>

      <?php require('php/dist/m-ongoing-trials.php'); ?>

      <?php require('php/dist/m-recent-trials.php'); ?>

		</div>



    <?php require('php/dist/m-HTMLfoot.php'); ?>
    

  </body>
</html>