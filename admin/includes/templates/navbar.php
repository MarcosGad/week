<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><?php echo lang('home')?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="Reservation.php"><?php echo lang('Reservation')?></a></li>
		<li><a href="ads.php"><?php echo lang('ads')?></a></li>
		<!--<li><a href="members.php">
			<?php //echo lang('Members') ?>
		</a></li>-->
		<li><a href="artical.php"><?php echo lang('artical')?></a></li>
		</ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">المسئول<span class="caret"></span></a>  
          <ul class="dropdown-menu">
            <li><a href="members.php?do=edit&userid=<?php echo $_SESSION['id']?>">تعديل البيانات</a></li>
            <li><a href="logout.php">الخروج</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>