<?php
  $type = $_GET['type'];
  if ($type !== 'group') {
    $type = 'trial';
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trial Manager - Search</title>

    <?php require('php/dist/m-HTMLhead.php'); ?>

  </head>


  <body>


    <?php require('php/dist/m-navBar.php'); ?>


    <div id="l-body">

      <?php

        require('php/dist/m-trialGroupBtn.php');
        create_trialGroupBtn($type);

        require('php/dist/m-trialSearchForm.php');
      ?>

      <div class="errorHolder"></div>

      <div style="text-align:center;">
        <button id="submit" type="button" class="btn btn-xlarge btn-success">Search Trials</button>
      </div>

      <br>

      <?php require('php/dist/m-searchResults.php'); ?>

		</div>


    <?php require('php/dist/m-HTMLfoot.php'); ?>
    
    <script src="js/dist/p-search.min.js"></script>

  </body>
</html>