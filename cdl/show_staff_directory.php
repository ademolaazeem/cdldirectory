<?php 

//page permission id = 8, permission name =  view contractor account reports
$page_permission_id = 15;

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
<?php 	
	
	$id = $_GET['id'];

	//pagination
		/*** Variables ***/
		$page = 1; //default page
		$per_page = 20; //rows per page
		$full_sql = "select * from tbl_directory order by extension"; //full sql before split in to pages		
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
		
		
		
		
		
		//New addition for Search button
if (isset($_POST['search']))
	{//header("location:search.php?stud=".$_POST['keyword']);
	 	
	 	$keyword=$_POST['keyword'];
	 	
	//pagination
		/*** Variables ***/
		$page = 1; //default page
		$per_page = 10; //rows per page
		$full_sql = "select * from tbl_directory where fullname like '%$keyword%'"; //full sql before split in to pages
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
        	You are here=> <a href="dashboard.php" title="Dashboard" target="_self">Dashoard</a> -> <a href="show_staff_directory.php" title="View Directory" target="_self">Staff Directory Report</a><br/><br/>
         	<h3>
					      <?php if (isset($msg)) echo $msg ;?>
					      <br>
				       </h3>
					
                    <br/><br/>
</p>
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  
  <tr>
    <td width="51%"><form  name="form1" method="post"  action="staff_directory_print.php" target="_blank"> 
 <div> 

<table width="400" border="0" align="left">
  <tr>
    <td height="26" align="left" valign="top">Fullname:</td>
    <td><p>
      <input type="text" name="fullname" id="keyword" size="20"/>
    
      </td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="26" align="left" valign="top">&nbsp;</td>
    <td><input type="submit" value="Generate Reports" name="generate" id="generate"/> 
      |<a href="staff_directory_print.php" target="_blank"> Generate without Criteria</a></td>
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