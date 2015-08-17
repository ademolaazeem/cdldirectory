<?php session_start();
	$fuName = "";
	if(isset($_SESSION['username']))
	{
		$fuName= $_SESSION['username'];
	}
	else
	{
		header("location:no_permissions.php");
	}

	?>
    <header>
      <div class="row-1">
        <h1> <a class="logo" href="index.php">Consolidated Discounts Limited</a> <strong class="slog">The Directory Portal Utility</strong></h1>
        <form id="search-form" action="#" method="post" enctype="multipart/form-data">
          <fieldset>
            <div class="search-form">
              <input type="text" name="search" value="Type Keyword Here" onBlur="if(this.value=='') this.value='Type Keyword Here'" onFocus="if(this.value =='Type Keyword Here' ) this.value=''" />
              <a href="#">Search</a> </div>
          </fieldset>
        </form>
      </div>

<div class="row-2">
        <nav>
          <ul class="menu">
            <li><a class="active" href="dashboard.php">Home Page</a></li>
           <li>
                    <?php
                    if($fuName)
                    {
                    echo ' <a href="logout.php?a=t">Logout</a>';
                    }
                    else
                    {
                    echo '<a href="index.php" title="">Login</a>';
                    }
                    ?>
           </li>
            <li>
       <!--      Welcome <?php //echo $fuName;?></li>
       profile.php?user=<?php //echo $fuName;?>-->
  <a href="#" title="">Welcome <?php echo $fuName;?></a></li>
          </ul>
</nav>
      </div>
    </header>