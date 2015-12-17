<?php
  
  function create_nav_bar() {
    // $url = $_SERVER['PHP_SELF'];
    // $page = substr($url, strrpos($url, '/') + 1);


    //Function continues...
?>




<!-- Fixed navbar -->
<nav class="m_nav_bar navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Trial Manager</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="recent"><a href="index.php">Recent</a></li>
        <li class="search"><a href="search.php">Search</a></li>
        <li class="create"><a href="create.php">Create</a></li>
        <li class="myTrials"><a href="#">My Trials</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>


<!-- Dummy element that makes sure nothing hides behind the navbar. -->
<div class="navbar"></div>



<script type="application/javascript">
  var url = window.location.href;
  var page = url.substr(url.lastIndexOf('/') + 1);
  page = page.substr(0, page.lastIndexOf('.php') + 4);

  switch (page) {
    case '':
      $('.m_nav_bar .recent').addClass('active');
      break;
    case 'index.php':
      $('.m_nav_bar .recent').addClass('active');
      break;
    case 'search.php':
      $('.m_nav_bar .search').addClass('active');
      break;
    case 'create.php':
      $('.m_nav_bar .create').addClass('active');
      break;
    default:
      break;
  }


</script>


<?php

  }

?>