<?php
  if (isset($_GET['trialseq'])) {
    $pageType = 'trial';
    $seq = $_GET['trialseq'];
    $pageTitle = 'Trial Manager - View Trial';
    $html_updateBtn = '<button type="button" class="updateBtn btn btn-xlarge btn-success" data-toggle="tooltip" title="Update this trial.">Update Trial</button>';
    $html_deleteBtn = '<button type="button" class="deleteBtn btn btn-xlarge btn-danger" data-toggle="tooltip" title="Permanently delete this trial.">Delete Trial</button>';
  } else if (isset($_GET['groupseq'])) {
    $pageType = 'group';
    $seq = $_GET['groupseq'];
    $pageTitle = 'Trial Manager - View Group';
    $html_updateBtn = '<button type="button" class="updateBtn btn btn-xlarge btn-success" data-toggle="tooltip" title="Update this group.">Update Group</button>';
    $html_deleteBtn = '<button type="button" class="deleteBtn btn btn-xlarge btn-danger" data-toggle="tooltip" title="Permanently delete this group.">Delete Group</button>';
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trial Manager - Update Trial</title>

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
        require(SERVER_ROOT . '/module/info/module.php');
        require(SERVER_ROOT . '/module/comment_list/module.php');

        create_info('write', $pageType, $seq);
        create_comment_list('write', $pageType, $seq);


        if ($pageType === 'trial') {
          require(SERVER_ROOT . '/module/heat_data/module.php');

          create_heat_data('write', $seq);
        } else if ($pageType === 'group') {
          require(SERVER_ROOT . '/module/child_list/module.php');

          create_child_list('write', $seq);
        }
      ?>



      <div class="p_update">

        <div class="c_errorBox">

        </div>

        <div class="c_submitBtn">
          <?php 
            echo $html_updateBtn;
            echo $html_deleteBtn;
          ?>
        </div>

      </div>

		</div>



    
    <?php
      require(SERVER_ROOT . '/module/html_foot/module.php');

      create_html_foot();
    ?>

    <script src="<?php echo WEB_ROOT . "/page/update/dist/script.min.js"; ?>"></script>


  </body>
</html>