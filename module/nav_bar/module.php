<?php
  
  function create_nav_bar() {
    //Function continues...
?>




<link rel="stylesheet" media="screen" href="<?php echo WEB_ROOT . "/module/nav_bar/dist/style.css"; ?>">


<!-- Fixed navbar -->
<nav class="m_nav_bar navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo WEB_ROOT . "/"; ?>">Trial Manager</a>
  </div>
  <div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
      <li class="recent"><a href="<?php echo WEB_ROOT . "/recent"; ?>">Recent</a></li>
      <li class="search"><a href="<?php echo WEB_ROOT . "/search"; ?>">Search</a></li>
      <li class="lookup"><a href="<?php echo WEB_ROOT . "/lookup"; ?>">Lookup</a></li>
      <li class="create"><a href="<?php echo WEB_ROOT . "/create"; ?>">Create</a></li>
    </ul>
  </div><!--/.nav-collapse -->
</nav>


<!-- Dummy element that makes sure nothing hides behind the navbar. -->
<div class="navbar"></div>



<script src="<?php echo WEB_ROOT . "/module/nav_bar/dist/script.min.js"; ?>"></script>



<script type="application/javascript">
  


</script>


<?php

  }

?>