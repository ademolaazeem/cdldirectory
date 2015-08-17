<?php
//get user access level
session_start();
//page permission id = 1, permission name =  add contractors
$page_permission_id = 6;
if(isset($_SESSION['levelaccess']))
{
	$acc_level = $_SESSION['levelaccess'];
}

if($acc_level == 1 )
{}
else
{
   header("location:no_permissions.php");
}
?>
<?php 
	require_once("restrict.php");
	require_once("../ClassesController/DBDirect.php");
	require_once("../ClassesController/AdminContractor.php");
	require_once("../ClassesController/AdminManager.php");
	
	$db = new DBConnecting();
	$adm = new AdminController();
	$upContractor = new Contractor();
	
	if(isset($_POST['update']))
	{
		$msg = $upContractor->Update_User_Account_By_Admin();
	}
	
		
	
	
	//$rs = $db->fetchData($qry);
	
	$user = $_GET['user'];
	$qry = "SELECT * FROM tbl_users WHERE username = '$user'";
	$exqry = mysql_query($qry);
	$rs = mysql_fetch_array($exqry);

	
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Ogun State Forestry Monitoring and Control System</title>
   <link rel="icon" type="image/png" href="../images/favicon.png">
  
  <script language="JavaScript">
<!--
function formpreview(form) {

form.action='_registration_preview.php';
form.submit();
}
//-->
</script> 
  
  
  
  <link rel="stylesheet" href="../css/style.css">

  
  <script src="../jquery/1.5.1/jquery.min.js"></script>
  <script src="../js/slides.min.jquery.js"></script>
	
	<!--[if IE]>
    
    form.target='_blank';
    
    
    
	<script type="text/javascript">
	(function(){
	var html5elmeents = "address|article|aside|audio|canvas|command|datalist|details|dialog|figure|figcaption|footer|header|hgroup|keygen|mark|meter|menu|nav|progress|ruby|section|time|video".split('|');
	for(var i = 0; i < html5elmeents.length; i++){
	document.createElement(html5elmeents[i]);
	}
	}
	)();
	</script>
	<![endif]-->
</head>

<body>

  <?php 
	include('header_wrapper.php');
	?>

<!--
	<div id="header-wrap">
		<header class="group">
			<h2><a href="../index.php" title="burstudio">Forestry Monitoring</a></h2>
			<div id="call">
				<h3>Ogun State</h3>
				<h4 class="green"><strong>Government</strong></h4>
			</div>
			<nav class="group">
				<ul>
					<li class="home"><a href="#" title="">Home</a></li>
					<li><a href="#" title="">About Us</a></li>
					<li><a href="#" title="">Contact Us</a></li>
					<li><a href="#" title="">Logout</a></li>
					<li class="last">
						<div>
							<input type="text" name="search" placeholder="search" />
							<input type="submit" name="search" value="go" class="search"/>
						</div>
					</li>
				</ul>
			</nav>
		</header>
	</div>
    -->
    <!-- end header wrap -->
	
	
<div id="container">
<br/>
<h3>Editing <?php echo $rs['username'];?></h3>
               	    <p>
               	      <?php require_once('head_man_user_account_link.php'); ?>
               	    </p>
                    <br/>

   <br/>
   &nbsp;




<fieldset>
   <form id="form" name="form" method="post" action="">
    <table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td colspan="2" align="center"><h3>User Account Update  <strong><span class="green">Page</span></strong></h3>
      <p>
        <?php if(isset($msg))echo $msg;?>
      </p></td>
    </tr>
 <tr>
    <td width="22%" height="18" align="left">Title:</td>
    <td align="left"> 
<select name="title" id="title">
        <option value="" <?php  if ($rs['title'] == ""){echo "selected";}?>>--Select Title--</option>
       <option value="Mr" <?php if ($rs['title'] == "Mr"){echo "selected";}?>>Mr</option>
      <option value="Mrs" <?php if ($rs['title'] == "Mrs"){echo "selected";}?>>Mrs</option>
      <option value="Miss" <?php if ($rs['title'] == "Miss"){echo "selected";}?>>Miss</option>     
	  
      </select>
</td>
    </tr>
  <tr>
    <td align="left">Firstname:</td>
    <td><input type="text" name="fname" id="fname" value="<?php echo $rs['fname'] ;?>"/></td>
    </tr>
  <tr>
    <td align="left">Middlename:<br></td>
    <td align="left"><input type="text" name="mname" id="mname" value="<?php echo $rs['mname'];?>"/></td>
    </tr>
  <tr>
    <td align="left">Lastname:</td>
    <td align="left"><input type="text" name="lname" id="lname" value="<?php echo $rs['lname'];?>"/></td>
    </tr>
  <tr>
    <td width="22%" height="18" align="left">Sex:</td>
    <td align="left"> 
<select name="sex" id="sex">
        <option value="" <?php if ($rs['sex'] == ""){echo "selected";}?>>--Select Sex--</option>
       <option value="Male" <?php if ($rs['sex'] == "Male"){echo "selected";}?>>Male</option>
      <option value="Female" <?php if ($rs['sex'] == "Female"){echo "selected";}?>>Female</option>
      </select>
</td>
    </tr>
  <tr>
    <td align="left">Date of Birth:</td>
   <td align="left"><label for="day"></label>
      <?php
//get class into the page
require_once("../ClassesController/tc_calendar.php");

//get the date from the db
$dob =  $rs['dob'];

//put date pieces into an array
$dob_arr= explode("-",$dob);

//instantiate class and set properties
$myCalendar = new tc_calendar("dob", true);
$myCalendar->setDateFormat("d/m/Y");
$myCalendar->setIcon("../images/calender/iconCalendar.gif");
if($dob == "")
{$myCalendar->setDate(date('d'),date('m'),date('Y'));}
else
{$myCalendar->setDate($dob_arr[2],$dob_arr[1],$dob_arr[0]);}

//output the calendar
$myCalendar->writeScript();	 
?>

      </td>
    </tr>
  <tr>
    <td align="left">Location:</td>
    <td align="left">
    <select name="location">
	<option value="">--- Select ---</option>
	<?php

	// Get records from database (table "name_list").
	$list = mysql_query("SELECT * FROM tbl_location ORDER BY forest_name ASC");

	// Show records by while loop.
	while($row_list=mysql_fetch_assoc($list)){
	$location = $row_list['forest_location'];

	echo "<option value='$location'";

	 if($location == $rs['location']){
	echo "selected";
	} 

	echo ">$location</option>";

	// End while loop.
	}
	?>
	</select> 
    </td>
    </tr>
  <tr>
    <td align="left">New Password:</td>
    <td align="left"><input type="password" name="new_password" id="new_password" value=""/></td>
    </tr>
  <tr>
  <tr>
    <td align="left">Re-Type New Password:</td>
    <td align="left"><input type="password" name="re_new_password" id="re_new_password" value=""/></td>
    </tr>
  <tr>
  <tr>
    <td align="left">Department:</td>
    <td align="left"><input type="text" name="dep" id="dep" value="<?php echo $rs['dep'];?>"/></td>
    </tr>
  <tr>
  <tr>
    <td align="left">Rank:</td>
    <td align="left"><input type="text" name="rank" id="rank" value="<?php echo $rs['rank'];?>"/>
      </td>
    </tr>
  <tr>  
 <tr>
    <td align="left">Qualification:</td>
    <td align="left"><input type="text" name="qua" id="qua" value="<?php echo $rs['qua'];?>"/>
      </td>
    </tr>
  <tr>
    <td align="left">Role:</td>
    <td align="left">
    <select name="acclevel">
	<option value="">--- Select ---</option>
	<?php

	// Get records from database (table "name_list").
	$list = mysql_query("SELECT * FROM tbl_roles ORDER BY name ASC");

	// Show records by while loop.
	while($row_list=mysql_fetch_assoc($list)){
	$id =  $row_list['id'];
	$name = $row_list['name'];

	echo "<option value='$id'";

	 if($id == $rs['acclevel']){
	echo "selected";
	} 

	echo ">$name</option>";

	// End while loop.
	}
	?>
	</select> 
    </td>
    </tr>
   <tr>
    <td align="left">Email:</td>
    <td align="left"><input type="text" name="email" id="email" value="<?php echo $rs['email'];?>"/></td>
    </tr>
       
 <tr>
    <td align="left">Address:</td>
    <td align="left"><textarea name="address" id="address" cols="35" rows="3"><?php echo $rs['address'];?></textarea></td>
    </tr>
  <tr>
    <td height="50" align="left">Phone:</td>
    <td align="left"><input type="text" name="phone" id="phone" value="<?php echo $rs['phone'];?>"/></td>
  </tr> 
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr> 
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">
      
      <!--<input type="submit" name="register" id="register" value="Register" />-->
      
      <input name="update" id="update" type="submit" value="Update Now">
      <input name="username" type="hidden" id="username" value="<?php echo $rs['username'];?>"></td>
  </tr> 
  
 </table>
 </form>
</fieldset>




</div><!--End Container -->
    
    
    
    
    
    <div id="widget-wrap" class="group">
		<div id="widget">
			<div id="links" class="group">
				<h4 class="white">Other <strong>Links</strong></h4>
				<ul>
		<li><a href="http://ogunstate.gov.ng/" target="_blank">Ogun State Official Website</a></li>
<li><a href="http://ogunstate.gov.ng/index.php/forestry" target="_blank">Ministry of Forestry Page</a></li>
<!--<li><a href="#">www.labzip.com</a></li>-->
					
				</ul>
			</div>
			
			<div id="blog">
			  <h4 class="footer-header white">Latest From The <strong>Ogun state</strong></h4>
				<img src="../images/blog.png" alt="blog" />
				<p class="title">Click below to know have more first hand information about Ogun state</p>
				<p class="date">
				<?php print date("j M Y, g.i a", time());
?></p>
				<p><a href="http://feeds.feedburner.com/OgunStateNews" target="_blank" class="readmore">read more</a></p>
			</div><!-- end blog -->
			
			<div id="location">
			  <h4 class="footer-header white">Our <strong>Location</strong></h4>
				<img src="../images/map.png" alt="map" />
				<?php include('commisioner_details.php'); ?>
			</div><!-- end location -->
		</div><!-- end widget -->
	</div> <!--! end widget-wrap -->
	
    <?php 
	include('footer.php');
	?>
    <!--
	<footer class="group">
		<div id="footer-left">
			<p>Copyright <a href="#" class="green">www.verdeinfotech.com</a> </br>
			Developed by <a href="../www.verdeinfotech.com" class="green">Verde Information Technologies</a></p>
		</div>
			
		<div id="footer-right">
			<ul>
				
				<li><a href="#">About Us</a></li>
				<li><a href="#">Contact Us</a></li>
				<li><a href="#">Logout</a></li>
			</ul>
		</div>
				
		<a href="#header-wrap"><img src="../images/back-top.png" alt="back-top" class="back-top" /></a>		
	</footer>
    -->
	
	
<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				generateNextPrev: true,	
			});
		});
</script>




<!--Start script
http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js
-->
	<script type="text/javascript" src="../jquery/1.5.2/jquery.min.js"></script>
		<script type="text/javascript" src="../js/jquery.transform-0.9.3.min_.js"></script>
		<script type="text/javascript" src="../js/jquery.mousewheel.js"></script>
		<script type="text/javascript" src="../js/jquery.RotateImageMenu.js"></script>
<!-- End Script -->
</body>
</html>
