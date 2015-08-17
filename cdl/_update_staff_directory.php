<?php 

//page permission id = 2, permission name =  administer contractors
$page_permission_id = 5;

require_once("restrict.php");
require_once("../ClassesController/DBDirect.php");
require_once("../ClassesController/AdminContractor.php");
require_once("../ClassesController/AdminManager.php");
	
$db = new DBConnecting();
$adm = new AdminController();
$upContractor = new Contractor();

//get user access level
session_start();
$acc_level = "";
$location = "";
if(isset($_SESSION['levelaccess']))
{
	$acc_level = $_SESSION['levelaccess'];
//	$location = $_SESSION['location'];
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
	
	if(isset($_POST['update']))
	{
		$msg = $upContractor->Update_Staff_Directory_By_Admin();
	}
	
		
	
	
	//$rs = $db->fetchData($qry);
	
	$id = $_GET['id'];
	/*
	if($acc_level == 2)
	{
		$qry = "SELECT * FROM tbl_contractor WHERE id = '$con_id' && business_area='$location'";
	}
	elseif($acc_level == 3)
	{
		//hqusers with acc level = 3 should not see information about Area J4 Corporation with location id = 10
		$qry = "select * from tbl_contractor WHERE id = '$con_id' AND (business_area NOT IN (SELECT forest_location from tbl_location WHERE id = 10)) order by datereg desc"; //full sql before split in to pages
	}
	else
	{
	*/	$qry = "SELECT * FROM tbl_directory WHERE id = '$id'";
	//}
	$exqry = mysql_query($qry);
	$rs = mysql_fetch_array($exqry);

	
?>















<!DOCTYPE html>
<html lang="en">
<head>
<title>CDL Staff Directory</title>
<meta charset="utf-8">

<link rel="shortcut icon" href="images/favicon.ico">









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
         <h3>Editing <?php echo $rs['fullname'];?></h3>
               	    <p>
               	      <?php require_once('head_link.php'); ?>
               	    </p>
                    <br/>

   <br/>
   &nbsp;




<fieldset>
   <form id="form" name="form" method="post" action="">
    <table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td colspan="2" align="center">
    <h3>Staff Directory Update Page </h3>
    <br/>
      <p>
        <?php if(isset($msg))echo $msg;?>
      </p></td>
    </tr>
  <tr>
    <td width="22%" height="46" align="left">Fullname:</td>
    <td align="left"><input type="text" name="fullname" id="fullname" value="<?php echo $rs['fullname'];?>"/></td>
    </tr>
 <!--
  <tr>
    <td align="left">Tax Identification Number:</td>
    <td><input type="text" name="tin" id="tin" value="<?php //echo $rs['tin'];?>"/></td>
    </tr>
    -->
      <tr>
    <td height="40" align="left">Department:</td>
    <td><input type="text" name="department" id="department" value="<?php echo $rs['department'];?>"/></td>
  </tr>
  <tr>
    <td height="37" align="left">Extension:<br></td>
    <td align="left"><input type="text" name="extension" id="extension" value="<?php echo $rs['extension'];?>"/></td>
    </tr>
  <tr>
    <td height="50" align="left">Mobile:</td>
    <td align="left"><input type="text" name="mobile" id="mobile" value="<?php echo $rs['mobile'];?>"/></td>
    </tr>
  <tr>
    <td height="36" align="left">Email:</td>
    <td align="left"><input type="text" name="email" id="email" value="<?php echo $rs['email'];?>" />     </td>
    </tr>
  <tr>
    <td width="22%" height="41" align="left">Floor:</td>
    <td width="377" align="left">
    
  <!--  <input type="text" name="floor" id="floor" value="<?php //echo $rs['floor'];?>" />-->
      <select name="floor">
      <option value="<?php echo $rs['floor'];?>"><?php echo $rs['floor'];?></option>
        <option value="GROUND_FLOOR">GROUND_FLOOR</option>
        <option value="1ST_FLOOR">1ST_FLOOR</option>
        <option value="2ND_FLOOR">2ND_FLOOR</option>
        <option value="3RD_FLOOR">3RD_FLOOR</option>
      </select></td>
  </tr>
    
 <tr>
   <td height="27" align="left">&nbsp;</td>
   <td align="left">&nbsp;</td>
 </tr> 
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">
      
      <!--<input type="submit" name="register" id="register" value="Register" />-->
      
      <input name="update" id="update" type="submit" value="Update Now">
      <input name="id" type="hidden" id="id" value="<?php echo $rs['id'];?>"></td>
  </tr> 

  
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left"></td>
  </tr>
  
 </table>
 </form>
</fieldset>

          
          
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