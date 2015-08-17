<?php 

//page permission id = 2, permission name =  administer contractors
$page_permission_id = 10;

require_once("restrict.php");
require_once("../ClassesController/DBDirect.php");
require_once("../ClassesController/AdminManager.php");
require_once('../ClassesController/class.pagination.php');
	
$db = new DBConnecting();
$adm = new AdminController();

//get user access level
session_start();
$acc_level = "";
$location = "";
if(isset($_SESSION['levelaccess']))
{
	$acc_level = $_SESSION['levelaccess'];
	//$location = $_SESSION['location'];
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
	
	$id = $_GET['id'];
	
	/*
	if($acc_level == 2)
	{
		$qry = "SELECT * FROM tbl_directory WHERE id = '$id' && business_area = '$location'";
	}
	elseif($acc_level == 3)
	{
		//hqusers with acc level = 3 should not see information about Area J4 Corporation with location id = 10
			$qry = "select * from tbl_contractor WHERE id = '$con_id' AND (business_area NOT IN (SELECT forest_location from tbl_location WHERE id = 10)) order by datereg desc"; //full sql before split in to pages
	}
	else
	{
*/		
$qry = "SELECT * FROM tbl_directory WHERE id = '$id'";

//}
	$rs = $db->fetchData($qry);
	
?>















<!DOCTYPE html>
<html lang="en">
<head>
<title>CDL Staff Directory</title>
<meta charset="utf-8">









<link rel="shortcut icon" href="images/favicon.ico">



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

<style type="text/css">
<!--
@import url("longtable-style.css");
-->
</style>
 <link rel="stylesheet" href="../css/style.css">
<script src="../jquery/1.5.1/jquery.min.js"></script>
  <script src="../js/slides.min.jquery.js"></script>














<link rel="stylesheet" href="../css/reset.css" type="text/css" media="screen">
<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="../css/layout.css" type="text/css" media="screen">
<script type="text/javascript" src="../js/jquery-1.6.min.js"></script>
<script src="../js/cufon-yui.js" type="text/javascript"></script>
<script src="../js/cufon-replace.js" type="text/javascript"></script>
<script src="../js/Open_Sans_400.font.js" type="text/javascript"></script>
<script src="../js/Open_Sans_Light_300.font.js" type="text/javascript"></script>
<script src="../js/Open_Sans_Semibold_600.font.js" type="text/javascript"></script>
<script src="../js/FF-cash.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="js/html5.js"></script>
<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
<![endif]-->
</head>
<body id="page3">
<!-- header -->
<div class="bg">
  <div class="main">

<?php 
include('header_in.php');
?>
    <!-- content -->
    <section id="content">
      <div class="padding">
        <div class="indent">
          <h3> Administer Staff Directory</h3>
          
          
               	    <p>
               	      <?php require_once('head_link.php'); ?>
   	      </p>
               	    <p>&nbsp; </p>
               	    
 <p>&nbsp; </p>
  <p>&nbsp; </p>
					            	    <table width="547" id="background-image" summary="Meeting Results">
               	      <thead>
        </thead>
      <tfoot>
        <tr>
          <td height="42" colspan="4" align="center"></td>
        </tr>
      </tfoot>
      <thead>
       
<tr>
<td width="138" rowspan="8" align="center" valign="top">
  <p>
  <!--../images/uploads/contractor/"."-->
  </br><img name="" src="<?php echo $rs['picture'];?>" width="121" height="130" alt="" /></p>
  <p>&nbsp;</p></td>
          <td width="174" height="40" align="left"><strong>Fullname:</strong></td>
<td width="219" align="left"><?php echo $rs['fullname'];?></td>
          </tr>

        <tr>
          <td height="32" align="left"><strong>Department:</strong></td>
          <td align="left"><?php echo $rs['department'];?></td>
          </tr>
       <!-- <tr>
          <td height="38" align="left"><strong> TIN:</strong></td>
          <td align="left"><?php // echo $rs['tin'];?></td>
          </tr>
          -->
          <tr>
          <td height="38" align="left"><strong> Extension:</strong></td>
          <td align="left"><?php  echo $rs['extension'];?></td>
          </tr>
        <tr>
          <td height="22" align="left"><strong> Mobile:</strong></td>
          <td align="left"><?php echo $rs['mobile']; ?></td>
        </tr>
        <tr>
          <td height="22" align="left"><strong>Floor:</strong></td>
          <td align="left"><?php echo $rs['floor']; ?></td>
        </tr>
        <tr>
          <td height="38" align="left"><strong>Email:</strong></td>
          <td align="left"><?php echo $rs['email'];?></td>
        </tr>
        <tr>
          <td height="25" align="left"><strong>Created By:</strong></td>
          <td align="left"><?php echo $rs['maker'];?></td>
        </tr>
        <tr>
          <td align="left"><strong>Created Date:</strong></td>
          <td align="left"><?php echo $rs['created_date'];?></td>
        </tr>
        </thead>
</table>
          
          
        </div>
       
      </div>
    </section>
    <!-- footer -->
    <?php 
	include('../footer.php');
	?>
  </div>
</div>
<script type="text/javascript">Cufon.now();</script>
</body>
</html>