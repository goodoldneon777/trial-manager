<?php
  if (!isset($_GET['type'])) {
    $pageType = 'trial';
  } else {
    $pageType = $_GET['type'];
  }

  if ($pageType === 'trial') {
    $html_title = 'Trial Manager - Lookup Trial';
  } else if ($pageType === 'group') {
    $html_title = 'Trial Manager - Lookup Group';
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $html_title; ?></title>

    <?php
      require(SERVER_ROOT . '/module/html_head/module.php');

      create_html_head();
    ?>


  </head>


  <body>


    <?php
      require(SERVER_ROOT . '/module/nav_bar/module.php');
    
      create_nav_bar();
    ?>


    <div class="l-body">

      <?php
        require(SERVER_ROOT . '/module/toggle_pagetype/module.php');
        require(SERVER_ROOT . '/module/lookup/module.php');

        create_toggle_pagetype($pageType);
        create_lookup($pageType);
      ?>

      <div class="errorHolder"></div>

      <div style="text-align:center;">
        <?php //echo $html_submitBtn; ?>
      </div>

      <br>

      <?php
        // require('php/dist/m-searchResults.php');
        // create_searchResults($pageType);
      ?>

		</div>


    <?php
      require(SERVER_ROOT . '/module/html_foot/module.php');

      create_html_foot();
    ?>
    
  

  </body>
</html>