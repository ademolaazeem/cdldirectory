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
	
	if(isset($_POST['upbtn']))
	{
		$msg = $util->upload("staff_directory",$_POST['id']);
	}
	
	$id= $_GET['id'];
	/*
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
	{
	*/	$qry = "SELECT * FROM tbl_directory where id = '$id'";
	
	//}
	$exqry = mysql_query($qry);
	$rs = mysql_fetch_array($exqry);
	if((mysql_num_rows($exqry)) <=0)
	{exit;}
	
	
?>
	















<!DOCTYPE html>
<html lang="en">
<head>
<title>CDL Staff Directory</title>
<meta charset="utf-8">











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

<h3>Administering <?php echo $rs['fullname'];?></h3>
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
                          <th width="307" align="left" scope="col"><p><img name="" src="<?php echo $_SESSION['image'];?>" width="121" height="130" alt="" />
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
                            <input type="hidden" name="id" id="id" value="<?php echo $rs['id']; ?>"/>
                          </p>
                            <p>&nbsp;</p>
                          <p>&nbsp; </p></td>
                         
                        </tr>
                      </tbody>
                    </table>
                    </form>

          
          
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