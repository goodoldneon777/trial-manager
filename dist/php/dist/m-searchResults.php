<?php
  
  function create_searchResults($type) {
  // if (!isset($_GET['type'])) {
  //   $type = 'trial';
  // } else {
  //   $type = $_GET['type'];
  // }

    if ($type === 'trial') {
      $html_class = '"m-searchResults panel panel-primary"';
    } else if ($type === 'group') {
      $html_class = '"m-searchResults panel panel-info"';
    }

    //Function continues...
?>


<div class=<?php echo $html_class; ?> >
	<div class="panel-heading">
    <h3 class="panel-title">
    	Search Results
    	<span class="description"></span>
    </h3>
  </div>

  <div class="contents">
  	<div style="text-align:center; padding:10px;">Search using the form above.</div>
  </div>

</div>



<?php

  }

?>









