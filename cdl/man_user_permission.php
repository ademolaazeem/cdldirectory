<?php
//get user access level
session_start();
//page permission id = 1, permission name =  add contractors
$page_permission_id = 11;
$acc_level = "";
$location = "";
if(isset($_SESSION['levelaccess']))
{
	$acc_level = $_SESSION['levelaccess'];
	$location = $_SESSION['location'];
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
	require_once("../ClassesController/AdminManager.php");
	require_once('../ClassesController/class.pagination.php');	
	require_once('authenticate.php');
	require_once("../ClassesController/Utilities.php");
	
	$db = new DBConnecting();
	$admAcct = new Contractor();
	
	$remove = new AdminController();
	
	
	$user = $_GET['user'];
	$qry = "SELECT * FROM tbl_users WHERE username = '$user'";
	$exqry = mysql_query($qry);
	$rs = mysql_fetch_array($exqry);

	if(isset($_POST['delete']))
	{
		$msg = $admAcct->User_Permission_Delete();
	}


	//pagination
		/*** Variables ***/
		$page = 1; //default page
		$per_page = 10; //rows per page

		$full_sql = "select * from tbl_user_permission where  username = '$user' order by permission_id"; //full sql before split in to pages
		


		$display_links = 11; //number of links to be displayed - odd number
		/*** Variables ***/
		//check page number
		if(isset($_REQUEST['page']))
			$page = $_REQUEST['page'];
		
		//create object, pass the values
		$pageObj = new pagination($full_sql, $per_page, $page);
		
		//sql after getting split in to pages
		$sql = $pageObj->get_query();
		$rsd = mysql_query($sql);
		
		//starting serial number
		$sl_start = $pageObj->offset;
		
		//get the links and store it in a variable
		$page_links = $pageObj->get_links();

		//get lastpage
		$last = $pageObj->getLastPage();
		


	
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


	
	
<div id="container">
<br/>
<h3>Manage Permissions for: <span class="green"><?php echo $user;?></span></h3>
               	    <p>
               	      <?php require_once('head_man_user_account_link.php'); ?>
               	    </p>
                    <br/>

   <br/><p>&nbsp;</p>
<div class="content">
						<h4>
				        Total Permissions: <?php echo $pageObj->getTotalRow(); ?></h4>
                    <p align="center"><br /><?php if(isset($msg))echo $msg;?>  </p>
                    <table width="50%" id="background-image" summary="Meeting Results">
                      <thead>
                        <tr>
 			  <th width="15%" scope="col"><strong>#</strong></th>
                          <th width="50%"  scope="col"><strong>Permission</strong></th>
                          <th width="85"  scope="col"><strong>Delete</strong></th>
		        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <td colspan="8" align="center"><?php echo "<a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=1'>[First]</a>".$page_links."<a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=$last'>[Last]</a>"; ?></td>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php $i=0;
					while($rs = mysql_fetch_array($rsd))
					{
						 $permission_id = $rs['permission_id'];
						 $sql = mysql_query("SELECT * from tbl_permissions WHERE id = $permission_id") or die(mysql_error());
						 $row_list=mysql_fetch_assoc($sql);
						$permission_name = $row_list['name'];

				  ?>
				  <?php //echo ++$sl_start; ?>
                        <tr>
             <td ><?php echo ($i+1);?>
             </td>
         <td ><?php echo $permission_name;?></td>
   <td >
   <form id="form" name="form" method="post" action="" onSubmit="return confirm('Are you sure you want to delete this permission?')" >
   <input name="user" type="hidden" id="user" value="<?php echo $user;?>">
   <input name="permission" type="hidden" id="permission" value="<?php echo $permission_id;?>">
   <input type="submit" name="delete" id="delete" value="Delete" <?php echo $activate_btn_status; ?>/>
   </form>
   </td>
 
                        </tr>
                        <?php $i++;}?>
                      </tbody>
                      <tfoot>
                      </tfoot>
                      
                      
                    </table>
                    <div class="wrapper"></div>
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
