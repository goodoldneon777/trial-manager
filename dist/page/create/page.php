<?php
  if (!isset($_GET['type'])) {
    $pageType = 'trial';
  } else {
    $pageType = $_GET['type'];
  }

  if ($pageType === 'trial') {
    $pageTitle = 'Trial Manager - Create Trial';
    $html_submitBtn = '<button type="button" class="btn btn-xlarge btn-success" data-toggle="tooltip" title="Create this trial.">Create Trial</button>';
  } else if ($pageType === 'group') {
    $pageTitle = 'Trial Manager - Create Group';
    $html_submitBtn = '<button type="button" class="btn btn-xlarge btn-success" data-toggle="tooltip" title="Create this group.">Create Group</button>';
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $pageTitle; ?></title>

    <?php
      require(SERVER_ROOT . '/module/html_head/module.php');

      create_html_head();
    ?>

    <link rel="stylesheet" media="screen" href="<?php echo WEB_ROOT . "/page/create/dist/style.css"; ?>">

  </head>
  <body>


    <?php
      require(SERVER_ROOT . '/module/nav_bar/module.php');
    
      create_nav_bar();
    ?>


    <div class="l-body">

      <?php
        require(SERVER_ROOT . '/module/toggle_pagetype/module.php');
        require(SERVER_ROOT . '/module/info/module.php');

        create_toggle_pagetype($pageType);
        create_info('write', $pageType);

        if ($pageType === 'trial') {
          require(SERVER_ROOT . '/module/heat_data/module.php');

          create_heat_data('write', $seq);
        } else if ($pageType === 'group') {
          require(SERVER_ROOT . '/module/child_list/module.php');

          create_child_list('write', $seq);
        }
      ?>



      <div class="p_create">

        <div class="c_errorBox">

        </div>

        <div class="c_submitBtn">
          <?php echo $html_submitBtn; ?>
        </div>

      </div>

    </div>



    
    <?php
      require(SERVER_ROOT . '/module/html_foot/module.php');

      create_html_foot();
    ?>

    <script src="<?php echo WEB_ROOT . "/page/create/dist/script.min.js"; ?>"></script>


  </body>
</html>