<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trial Manager - Search</title>

    <!-- Bootstrap -->
    <link href="plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dist/style.min.css" rel="stylesheet">

    <script src="plugin/jquery/jquery-2.1.4.min.js"></script>

    <script src="plugin/handsontable/handsontable.full.js"></script>
    <link rel="stylesheet" media="screen" href="plugin/handsontable/handsontable.full.css">


    <!--[if lt IE 9]>
      <script type="text/javascript">
          window.location = "better-browser.php";
      </script>
    <![endif]-->

  </head>
  <body>


    <?php require('php/dist/m-navBar.php'); ?>


    <div id="l-wrapper">

			<?php require('php/dist/m-search-form.php'); ?>

      <div id="error-box"></div>

      <div style="text-align:center;">
        <button id="submit" type="button" class="btn btn-xlarge btn-success">Search Trials</button>
      </div>

      <br>

      <?php require('php/dist/m-search-results.php'); ?>

		</div>


    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="plugin/bootstrap/js/bootstrap.min.js"></script>
    <script src="plugin/moment/moment.min.js"></script>
    <script src="js/dist/main.min.js"></script>
    <script src="js/dist/extension.min.js"></script>
    <script src="js/dist/p-search.min.js"></script>

  </body>
</html>