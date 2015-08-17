<?php 

//page permission id = 2, permission name =  administer contractors
$page_permission_id = 2;

require_once("restrict.php");
require_once("../ClassesController/DBDirect.php");
require_once("../ClassesController/Utilities.php");
	
$db = new DBConnecting();
$util = new Utilities();

//get user access level
session_start();
$acc_level = "";
$location = "";
if(isset($_SESSION['levelaccess']))
{
	$acc_level = $_SESSION['levelaccess'];
	$location = $_SESSION['location'];
}


//check if user has required permissions 
$rs = mysql_query("select *from tbl_user_permission WHERE username='".$_SESSION['username']."' && permission_id='$page_permission_id'");
$has_page_permission = mysql_num_rows($rs);
if ($has_page_permission > 0)
{}
else
{
   header("location:no_permissions.php");
}
?>
<?php 
	
	if(isset($_POST['upbtn']))
	{
		$msg = $util->upload("contractor",$_POST['con_id']);
	}
	
	$con_id= $_GET['con_id'];
	if($acc_level == 2)
	{
		$qry = "SELECT * FROM tbl_contractor where id = '$con_id' && business_area='$location'";
	}
	elseif($acc_level == 3)
	{
		//hqusers with acc level = 3 should not see information about Area J4 Corporation with location id = 10
		$qry = "select * from tbl_contractor WHERE id = '$con_id' AND (business_area NOT IN (SELECT forest_location from tbl_location WHERE id = 10)) order by datereg desc"; //full sql before split in to pages
	}
	else
	{$qry = "SELECT * FROM tbl_contractor where id = '$con_id'";}
	$exqry = mysql_query($qry);
	$rs = mysql_fetch_array($exqry);
	if((mysql_num_rows($exqry)) <=0)
	{exit;}
	
	
?>
	


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Ogun State Forestry Monitoring and Control System</title>
  
  
  <script language="JavaScript">
<!--
function formpreview(form) {

form.action='_registration_preview.php';
form.submit();
}
//-->
</script> 
  
   <link rel="icon" type="image/png" href="../images/favicon.png">
  
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

<h3>Administering <?php echo $rs['name'];?></h3>
<p>
               	      <?php require_once('head_link.php'); ?>
               	    </p>
                    
                    
                    <p><br/><br/>
                    </p>
  <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
                    <table width="728" id="background-image" summary="Meeting Results">
                      <thead>

                        <tr>
                          <th width="221" align="center" scope="col">
<!--  "../images/uploads/contractor/".--></th>
                          <th width="307" align="left" scope="col"><p><img name="" src="<?php echo $_SESSION['../tcn/image'];?>" width="121" height="130" alt="" />
                          </p>
                          <?php if(isset($msg))echo $msg;?></th>
                        </tr>
                        <tr>
                          <th width="221" align="right" scope="col"><strong>Select Image:</strong></th>
                          <th align="left" scope="col"><p>
                            <input type="file" name="file" id="file"/>
                          </p>
                          <p>&nbsp; </p></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td align="center">&nbsp;</td>
                          <td align="left"><p>
                            <input type="submit" name="upbtn" id="upbtn" value="Upload" />
                            <input type="hidden" name="con_id" id="con_id" value="<?php echo $rs['id']; ?>"/>
                          </p>
                            <p>&nbsp;</p>
                          <p>&nbsp; </p></td>
                         
                        </tr>
                      </tbody>
                    </table>
                    </form>




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
