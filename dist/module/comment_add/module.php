<?php

	function create_comment_add($writeType, $pageType) {


		//Function continues...
?>


<link rel="stylesheet" media="screen" href="<?php echo WEB_ROOT . "/module/comment_add/dist/style.css"; ?>">


<div class="m_comment_add panel panel-primary">

	<div class="panel-heading">
    <h3 class="panel-title">
    	Add Comment
    	<span class="description"></span>
    </h3>
  </div>

	<div class="content container form-inline noPad-xs">

		<div class="col-xs-12 fullPad-sm halfPad-xs">

			<div class="comment input-group">
			  <span class="elem-title"></span>
			  <textarea rows="4" class="form-control"></textarea>
			  <span></span>
			</div>

		</div>

	</div>


</div>


<script src="<?php echo WEB_ROOT . "/module/comment_add/dist/script.min.js"; ?>"></script>







<?php

	}

?>