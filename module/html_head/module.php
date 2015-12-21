<?php

	function create_html_head() {

		//Function continues...

?>

<!-- Bootstrap -->
<link href="<?php echo WEB_ROOT . "/plugin/bootstrap/css/bootstrap.min.css"; ?>" rel="stylesheet">
<link href="<?php echo WEB_ROOT . "/css/dist/style.min.css"; ?>" rel="stylesheet">

<script src="<?php echo WEB_ROOT . "/plugin/jquery/jquery-2.1.4.min.js"; ?>"></script>

<script src="<?php echo WEB_ROOT . "/plugin/handsontable/handsontable.full.js"; ?>"></script>
<link rel="stylesheet" media="screen" href="<?php echo WEB_ROOT . "/plugin/handsontable/handsontable.full.css"; ?>">

<script src="<?php echo WEB_ROOT . "/plugin/autosize/autosize.min.js"; ?>"></script>

<script src="<?php echo WEB_ROOT . "/plugin/moment/moment.min.js"; ?>"></script>

<script src="<?php echo WEB_ROOT . "/js/dist/global_var.js"; ?>"></script>
<script src="<?php echo WEB_ROOT . "/js/dist/extension.min.js"; ?>"></script>




<!--[if lt IE 9]>
  <script type="text/javascript">
      window.location = <?php echo WEB_ROOT . "/better-browser"; ?>;
  </script>
<![endif]-->



<?php

	}

?>