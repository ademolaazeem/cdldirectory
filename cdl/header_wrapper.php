	
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
    <div id="header-wrap">
		<header class="group">
			<h2><a href="../index.php" title="burstudio">Forestry Monitoring</a></h2>
			<div id="call">
				<h3>Ogun State</h3>
				<h4 class="green"><strong>Government</strong></h4>
			
            </div><!-- end call -->
            
			<nav class="group">
            
			<!--	<ul>
					<li class="home"><a href="dashboard.php" title="">Home</a></li>
					<li><a href="#" title="">About Us</a></li>
					<li><a href="#" title="">Contact Us</a></li>
					<li><a href="logout.php?a=t">Logout</a></li>
  <li><a href="profile.php?user=<?php //echo $fuName;?>" title="">Welcome <?php //echo $fuName;?></a></li>
                    <li class="last">
						<div>
							<input type="text" name="search" placeholder="search" />
							<input type="submit" name="search" value="go" class="search"/>
						</div>
					</li>
				</ul>
                
                -->
                
                <ul>
					<li class="home"><a href="dashboard.php" title="">Home</a></li>
					<!--<li><a href="#" title="">Reserves</a></li>
					<li><a href="#" title="">Prohibitions</a></li>
                    -->
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
  <li><a href="profile.php?user=<?php echo $fuName;?>" title="">Welcome <?php echo $fuName;?></a></li>
                    <li class="last">
						<div>
							<input type="text" name="search" placeholder="search" />
							<input type="submit" name="search" value="go" class="search"/>
						</div>
					</li>
				</ul>
			</nav>
            
		</header>
	 
    </div><!-- end header wrap -->
    
