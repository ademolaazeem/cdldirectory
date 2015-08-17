<?php
//get user access level
session_start();
$acc_level = "";
$location = "";
//page permission id = 1, permission name =  add contractors
$page_permission_id = 2;

if(isset($_SESSION['levelaccess']))
{
	$acc_level = $_SESSION['levelaccess'];
	$location = $_SESSION['location'];
}
if($acc_level == 1)
{}
else
{
   header("location:no_permissions.php");
}

?>
<?php 
	require_once('authenticate.php');
	$db = new DBConnecting();
	$adm = new AdminController();
	$admContr = new Contractor();
	
	

	$user = $_GET['user'];

	$qry1 = "SELECT * FROM tbl_users WHERE username = '$user'";

	//if the result set is empty then the preview button is disabled
	$preview_btn_status = "";
	if(mysql_num_rows(mysql_query($qry1))==0)
	{
		$preview_btn_status = "disabled";
	}
	$rs = $db->fetchData($qry1);

				
	/*
	if(isset($_POST['register']))
	{
		$msg = $admContr->Contractor_Registration();
	}	
	*/
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Ogun State Forestry Monitoring and Control System</title>
  
    <link rel="icon" type="image/png" href="../images/favicon.png">
     
  <link rel="stylesheet" href="../css/style.css">

  
  <script src="../jquery/1.5.1/jquery.min.js"></script>
  <script src="../js/slides.min.jquery.js"></script>
  
  
  
<script src="../jquery/1.4.1/jquery.js"></script>
<script type="text/javascript" src="../jquery/1.7.2/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../jquery/1.7.2/themes/base/jquery-ui.css">

<script language="javascript" src="../js/calendar.js"></script>

<link rel="stylesheet" type="text/css" href="../css/superfish.css" media="screen">
<link rel="stylesheet" type="text/css" href="../css/styles.css">
<link rel="stylesheet" type="text/css" href="../css/calender.css">
<link rel="stylesheet" type="text/css" href="../css/datePicker.css">

<script src="../js/jquery.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../themes/base/ui.all.css">
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="../ui/ui.core.js"></script>
<script type="text/javascript" src="../ui/ui.datepicker.js"></script>

<script type="text/javascript" src="../js/cal.js"></script>







  
  <script language="JavaScript">
<!--
function previewAccount(form) {

form.action='_new_user_permission_preview.php';

form.submit();
}
//-->
</script> 
  
  

	
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
<?php
	$user = $_GET['user'];
	$qry = "SELECT * FROM tbl_users WHERE username = '$user'";
	$exqry = mysql_query($qry);
	$rs = mysql_fetch_array($exqry);
?>
<div id="container"><br />
<br/>
<h3>Add Permission for: <span class="green"><?php echo $user;?></span></h3>
               	    <p>
               	      <?php require_once('head_man_user_account_link.php'); ?>
               	    </p>
                    <br/>

   <br/><p>&nbsp;</p>

<fieldset>
   <form id="form" name="form" method="post" action="_new_user_permission_preview.php">
   <input name="user" type="hidden" id="user" value="<?php echo $user; ?>">
 <table width="40%" border="0" cellspacing="5" cellpadding="5">
 <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
  <tr>
    <td height="7" align="left">Permissions:</td>
    <td align="left">
    <!--<select name="permission">
	<option value="">--- Select ---</option>-->
	<?php

	// Get records from database (table "name_list").
	$list = mysql_query("SELECT * FROM tbl_permissions ORDER BY id ASC");

	// Show records by while loop.
	while($row_list=mysql_fetch_assoc($list)){

	$id =  $row_list['id'];
	$name = $row_list['name'];

        echo "<input type='checkbox' name='permissions[]' value='$id' />".$name."<br />";
	/*echo "<option value='$id'";
	
	 if($id == $_POST['permission']){
	echo "selected";
	} */

	//echo ">$name</option>";

	// End while loop.
	}
	?>
	<!--</select> -->
<br />
</td>
  </tr>
 <tr>
   <td align="left">&nbsp;</td>
   <td align="left">
     
     <!--<input type="submit" name="register" id="register" value="Register" />-->
     <input name="preview_account" type="button" value="Preview Now" onClick='previewAccount(this.form)' <?php echo $preview_btn_status; ?>></td>
 </tr> 

  
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left"></td>
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
				<p class="address">ALHAJI FALILU A. SABITU
</br>HON. COMMISSIONER FOR FORESTRY
</br>Phone No:
</br>E-mail: falilu.sabitu@ogunstate.gov.ng </p>
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
