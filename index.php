<?php
  if (!isset($_GET['type'])) {
    $type = 'trial';
  } else {
    $type = $_GET['type'];
  }

  if ($type === 'trial') {
    $html_title = '<title>Trial Manager - Upcoming/Recent Trials</title>';
  } else if ($type === 'group') {
    $html_title = '<title>Trial Manager - Upcoming/Recent Groups</title>';
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <?php echo $html_title; ?>

    <?php require('php/dist/m-HTMLhead.php'); ?>


  </head>
  <body>


    <?php require('php/dist/m-navBar.php'); ?>

    

    <div id="l-body">

      <?php
        require('php/dist/m-trialGroupBtn.php');
        create_trialGroupBtn($type);


        if ($type === 'trial') {
          require('php/dist/m-upcoming-trials.php');
          require('php/dist/m-ongoing-trials.php');
          require('php/dist/m-recent-trials.php');

        } else if ($type === 'group') {
          require('php/dist/m-upcoming-groups.php');
          require('php/dist/m-ongoing-groups.php');
          require('php/dist/m-recent-groups.php');

        }

      ?>


		</div>



    <?php require('php/dist/m-HTMLfoot.php'); ?>
    

  </body>
</html>