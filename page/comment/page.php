<?php
  if (isset($_GET['trialseq'])) {
    $pageType = 'trial';
    $seq = $_GET['trialseq'];
  } else if (isset($_GET['groupseq'])) {
    $pageType = 'group';
    $seq = $_GET['groupseq'];
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trial Manager - Add Comment</title>

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
        require(SERVER_ROOT . '/module/comment_add/module.php');

        create_info('readonly', $pageType, $seq);
        create_comment_add('write', $pageType);
      ?>


		  <div class="p_comment">

        <div class="c_errorBox">

        </div>

        <div class="c_submitBtn">
          <button type="button" class="btn btn-xlarge btn-success">Add Comment</button>
        </div>

      </div>

    </div>



    <?php
      require(SERVER_ROOT . '/module/html_foot/module.php');

      create_html_foot();
    ?>


    <script src="<?php echo WEB_ROOT . "/page/comment/dist/script.min.js"; ?>"></script>


  </body>
</html>