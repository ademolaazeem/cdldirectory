<?php 

//page permission id = 8, permission name =  view contractor account reports
$page_permission_id = 23;

require_once("restrict.php");
require_once("../ClassesController/DBDirect.php");
require_once("../ClassesController/AdminManager.php");
require_once('../ClassesController/class.pagination.php');
	
$db = new DBConnecting();
	
$remove = new AdminController();


//get user access level
session_start();
$acc_level = "";
//$location = "";
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
         	<h5>
					      <?php if (isset($msg)) echo $msg ;?>
					      </h5><br>

</p>
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  
  <tr>
    <td width="51%"><form  name="form1" method="post"  action="print_visitor_report.php" target="_blank"> 
 <div> 

<table width="430" border="0" align="left">
  <tr>
    <td width="118" height="26" align="left" valign="top">Visitor Name:</td>
    <td width="272"><p>
      <input type="text" name="visitor_name" id="visitor_name" size="20"/>
    
      </td>
  </tr>
  <tr>
    <td height="29" align="left" valign="top"> Sign in Start Date:</td>
    <td><?php
//get class into the page
require_once("../ClassesController/tc_calendar.php");


//instantiate class and set properties
$myCalendar = new tc_calendar("start_date", true);
$myCalendar->setIcon("../images/calender/iconCalendar.gif");
//$myCalendar->setDate(1, 1, 2012);

//output the calendar
$myCalendar->writeScript();	 
?></td>
  </tr>
  <tr>
    <td height="27" align="left" valign="top">Sign in End Date:</td>
    <td><?php
//get class into the page
require_once("../ClassesController/tc_calendar.php");
/*
	  $myCalendar = new tc_calendar("payment_date", true, false);
	  $myCalendar->setIcon("../images/calender/iconCalendar.gif");
	  $myCalendar->setDate(date("d"), date("m"), date("Y"));
	  $myCalendar->setPath("./");
	  $myCalendar->setYearInterval(1970, date("Y"));
	  $myCalendar->dateAllow("1970-01-01", date("Y-m-d"));
	  $myCalendar->setAlignment("left", "bottom");
	  $myCalendar->writeScript();
	  */ 

//instantiate class and set properties
$myCalendar = new tc_calendar("end_date", true);
$myCalendar->setIcon("../images/calender/iconCalendar.gif");
//$myCalendar->setDate(1, 1, 2012);

//output the calendar
$myCalendar->writeScript();	 
?></td>
  </tr>
  <tr>
    <td height="17" align="left" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="26" align="left" valign="top">&nbsp;</td>
    <td><input type="submit" value="Generate Reports" name="generate" id="generate"/>
      | <a href="print_visitor_report.php" target="_blank"> Generate without Criteria</a></td>
  </tr>
</table>
</div> 
</form> </td>
    
    
  </tr>
 
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