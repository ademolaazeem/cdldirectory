<?php
//get user access level
session_start();
if(isset($_SESSION['levelaccess']))
{
	$acc_level = $_SESSION['levelaccess'];
}

/*if(($acc_level == 1 || $acc_level == 3))
{}
else
{
   header("location:no_permissions.php");
}*/
?>
<?php 
	require_once("restrict.php");
	require_once("../ClassesController/DBDirect.php");
	require_once("../ClassesController/AdminManager.php");
	require_once('../ClassesController/class.pagination.php');
	
	$db = new DBConnecting();
	$adm = new AdminController();
	
	
	$user = $_SESSION['username'];
	$qry = "SELECT * FROM tbl_users WHERE username = '$user'";
	$rs = $db->fetchData($qry);
	
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Ogun State Forestry Monitoring and Control System</title>
  
  <!--Comment here-->
  
  
  <link rel="icon" type="image/png" href="../images/favicon.png">



  <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="js/cufon-yui.js" type="text/javascript"></script>
<script src="js/cufon-replace.js" type="text/javascript"></script>
<script src="js/AvantGarde_Bk_BT_400.font.js" type="text/javascript"></script>
<script src="js/Myriad_Pro_300.font.js" type="text/javascript"></script>
<script src="js/jcarousellite.js" type="text/javascript"></script>
<script type="text/javascript">

	$(document).ready(function(){
	
	  $("a.new_window").attr("target", "_blank");
	  
	  //carousel
	  $(".carousel").jCarouselLite({
		  btnNext: ".next",
		  btnPrev: ".prev"
	  });
	});
		
</script>
<script type="text/javascript" src="../tcn/chromejs/chrome.js">

/***********************************************
* Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<!--[if lt IE 7]>
<script type="text/javascript" src="js/ie_png.js"></script>
<script type="text/javascript">
	ie_png.fix('.png, .carousel-box .next img, .carousel-box .prev img');
</script>
<link href="ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script type="text/javascript" src="../js/datetimepicker_css.js"></script>

<script language="javascript" type="text/javascript"> 
function submitregistration() {
 var form = document.clas;
     
if(form.classname.value == "")
{
	alert( "Enter Class Name" );
	//form.name.division.focus();
	return false;
}
else if(form.arm.value == "")
{
alert( "Enter Class arm" );
return false;
}
}

function confirmDelete()
{
	if(confirm("Do you want to remove this link\nProceed?")){
		if(confirm("Are you sure?")){
			return true;
		}
		else{
			return false;
		}
	}
	else
	{
		return false;
	}	
}
</script>
<style type="text/css">
<!--
@import url("longtable-style.css");
-->
</style>
  <!--End Insert-->
  
  
  
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



<div class="container">
				
				  <div class="content">
					<h3>User <?php echo $_SESSION['username'];?></h3>
               	    <p>
               	      <?php require_once('head_profile_link.php'); ?>
               	    </p>
               	    <p>&nbsp; </p>
                   <br>
<table width="100%" width id="background-image" summary="Meeting Results">
               	      <thead>
        </thead>
      <tfoot>
        <tr>
          <td height="42" colspan="4" align="center"></td>
        </tr>
      </tfoot>
      <thead>
       
<tr>
<td width="138" rowspan="15" align="center" valign="top">
  <p>
  <!--../images/uploads/contractor/"."-->
  </br><img name="" src="<?php echo $rs['../tcn/picture'];?>" width="121" height="130" alt="" /></p>
  <p>&nbsp;</p></td>
          <td width="174" height="40" align="left"><strong>Username:</strong></td>
<td width="219" align="left"><?php echo $rs['username'];?></td>
          </tr>

        <tr>
          <td height="32" align="left"><strong>Firstname:</strong></td>
          <td align="left"><?php echo $rs['fname'];?></td>
          </tr>
        <tr>
          <td height="38" align="left"><strong>Middlename:</strong></td>
          <td align="left"><?php echo $rs['mname'];?></td>
          </tr>
        <tr>
          <td height="46" align="left"><strong>Lastname:</strong></td>
          <td align="left"><?php echo $rs['lname']; ?></td>
        </tr>
        <tr>
          <td height="38" align="left"><strong>Sex:</strong></td>
          <td align="left"><?php echo $rs['sex'];?></td>
        </tr>
        <tr>
          <td height="25" align="left"><strong>Date of Birth:</strong></td>
          <td align="left"><?php echo $rs['dob'];?></td>
        </tr>
        <tr>
          <td height="31" align="left"><strong>Department:</strong></td>
          <td align="left"><?php echo $rs['dep'];?></td>
        </tr>
        <tr>
          <td height="33" align="left"><strong>Rank:</strong></td>
          <td align="left"><?php echo $rs['rank'];?></td>
        </tr>
        <tr>
          <td height="28" align="left"><strong>Qualification:</strong></td>
          <td align="left"><?php echo $rs['qua'];?></td>
        </tr>
        <tr>
          <td height="37" align="left"><strong>Access Level:</strong></td>
          <td align="left"><?php echo $rs['acclevel'];?></td>
        </tr>
        <tr>
          <td height="40" align="left"><strong>Email:</strong></td>
          <td align="left"><?php echo $rs['email'];?></td>
        </tr>
        <tr>
          <td height="35" align="left"><strong>Address:</strong></td>
          <td align="left"><?php echo $rs['address'];?></td>
        </tr>
        <tr>
          <td height="33" align="left"><strong>Phone:</strong></td>
          <td align="left"><?php echo $rs['phone'];?></td>
        </tr>
        <tr>
          <td height="57" align="left"><strong>Created Date:</strong></td>
          <td align="left"><?php echo $rs['datereg'];?></td>
        </tr>
      

      </thead>
</table>
		<br />
<div class="wrapper"></div>
				  </div>
					<div class="clear"></div>
</div>







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
