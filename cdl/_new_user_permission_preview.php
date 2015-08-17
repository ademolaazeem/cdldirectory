<?php
//get user access level
session_start();
//page permission id = 1, permission name =  add contractors
$page_permission_id = 3;
if(isset($_SESSION['levelaccess']))
{
	$acc_level = $_SESSION['levelaccess'];
}

if($acc_level == 1)
{}
else
{
   header("location:no_permissions.php");
}
?>
<?php 
	include('authenticate.php');
require_once("../ClassesController/Utilities.php");
	$db = new DBConnecting();
	$adm = new AdminController();
	$admAcct = new Contractor();
	
	$util = new Utilities();
	
	
	
	$user = mysql_real_escape_string($_POST['user']);
	$permission = mysql_real_escape_string($_POST['permission']);
	
$_SESSION['user']=$user;
$_SESSION['permission']=$permission;
	
	
	if(isset($_POST['save']))
	{
		$msg = $admAcct->User_Permission_Addition();
	}	
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



<link rel="stylesheet" type="text/css" href="../css/superfish.css" media="screen">



</head>

<body>

  <?php 
	include('header_wrapper.php');
	?>
<?php
	$qry = "SELECT * FROM tbl_users WHERE username = '$user'";
	$exqry = mysql_query($qry);
	$rs = mysql_fetch_array($exqry);
?>
<div id="container">
<br/>
<h3>Preview New Permission for: <span class="green"><?php echo $user;?></span></h3>
               	    <p>
               	      <?php require_once('head_man_user_account_link.php'); ?>
               	    </p>
                    <br/>

   <br/><p>&nbsp;</p>

<fieldset>
   <form id="form" name="form" method="post" action="">
   
 <table width="40%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td colspan="2" align="center">
      <p>
        <?php if(isset($msg))echo $msg;?>
      </p></td>
    </tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
  <tr align="left">
    <td height="34" align="right"><strong>Permissions: &nbsp;</strong></td>
    <td align="left">
<?php	

$sel_permission = $_POST['permissions'];
$nos_selected = count($sel_permission);
 
for($i=0; $i < $nos_selected; $i++)
{
    $sql = mysql_query("SELECT * from tbl_permissions WHERE id =". $sel_permission[$i]."") or die(mysql_error());
	 $row_list=mysql_fetch_assoc($sql);
         $permission_id = $row_list['id'];
         $permission_name = $row_list['name'];
    echo $permission_name."<br />";
    echo "<input type='checkbox' name='permissions[]' value='$permission_id' checked style='display:none;'  />";

}
?>
</td>
  </tr>
 <tr>
   <td height="18" align="left">&nbsp;</td>
   <td align="left">
     
     <!--<input type="submit" name="register" id="register" value="Register" />--></td>
 </tr> 

  <input name="user" type="hidden" id="type" value="<?php echo $user;?>">
  <tr>
    <td align="right"><A HREF="_new_user_permission.php" onClick="history.back();return false;">Go Back | </A></td>
    <td align="left"><input type="submit" name="save" id="save" value="Save Now" /></td>
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
				
                
             <?php 
	include('commisioner_details.php');
	?>    
                
                
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
