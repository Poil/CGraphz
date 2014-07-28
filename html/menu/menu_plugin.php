<?php
if (GET('module') == 'dashboard' && GET('component') == 'view') $top='100px';
else $top='50px';
?>

<nav class="navbar navbar-default navbar-fixed-top" style="top:<?php echo $top; ?>; min-height:30px; height:30px; z-index:40">
  <div class="container-fluid" id="project_plugin">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-inner">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse-plugin">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="bs-navbar-collapse-plugin">
    </div>
  </div>
</nav>

