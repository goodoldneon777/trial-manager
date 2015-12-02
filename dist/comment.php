<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trial Manager - Comment on a Trial</title>

    <?php require('php/dist/m-HTMLhead.php'); ?>

  </head>
  <body>


    <?php require('php/dist/m-navBar.php'); ?>


    <div id="l-body">

      <?php
        require('php/dist/m-trialInfo.php');
        create_trialInfo('readonly', $_GET['trialseq']);
      ?>

      <?php require('php/dist/m-trialComment-add.php'); ?>


      <div id="error-box"></div>


			<div style="text-align:center;">
				<button id="submit" type="button" class="btn btn-xlarge btn-success" data-toggle="tooltip" title="Upload this trial to the database. Everything can be modified later on the 'Update' page.">Submit Comment</button>
			</div>

			<br><br><br>

		</div>



    <?php require('php/dist/m-HTMLfoot.php'); ?>
    
    <script src="js/dist/p-comment.min.js"></script>

  </body>
</html>