<?php 
session_start();

require_once("restrict.php");
require_once("../ClassesController/DBDirect.php");
require_once("../ClassesController/AdminManager.php");
require_once('../ClassesController/class.pagination.php');
//require_once('../ClassesController/class.paginationcount.php');
require_once("../ClassesController/AdminVisitor.php");
require_once('../ClassesController/format.php');
	
$db = new DBConnecting();
$admVisitor = new CDLVisitor();
$fm = new Format ();

$page_permission_id = 19;
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
//page permission id = 8, permission name =  view contractor account reports
/*
session_start();
if(isset($_SESSION['levelaccess']))
{
	$role_id = $_SESSION['levelaccess'];
	
}

if($role_id == '1' )
{}
else
{
   header("location:no_permissions.php");
}
*/


//pagination
		/*** Variables ***/
		$page = 1; //default page
		$per_page = 20; //rows per page
		$full_sql = "select a.id id, a.visitor_name, a.address, a.purpose, a.phone_number, a.floor, a.extension, a.sign_in, a.time_in, a.sign_out, a.time_out, a.tag_number, b.fullname  from tbl_cdl_visitors a, tbl_directory b where a.whom_to_see=b.id and sign_out is not null order by time_in desc"; //full sql before split in to pages
		$display_links = 11; //number of links to be displayed - odd number
		// Variables 
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
	 	
	 	$visitor_name=$_POST['visitor_name'];
	 	
	//pagination
		/*** Variables ***/
		$page = 1; //default page
		$per_page = 10; //rows per page
		$full_sql = "select a.id id, a.visitor_name, a.address, a.purpose, a.phone_number, a.floor, a.extension, a.sign_in, a.time_in,  a.sign_out, a.time_out, a.tag_number, b.fullname  from tbl_cdl_visitors a, tbl_directory b where a.whom_to_see=b.id and sign_out is not null and a.visitor_name like '%$visitor_name%' order by time_in desc"; //full sql before split in to pages

//select a.id id, a.visitor_name, a.address, a.purpose, a.phone_number, a.floor, a.extension, a.sign_in, a.time_in, a.tag_number, b.fullname  from tbl_cdl_visitors a, tbl_directory b where a.whom_to_see=b.id and a.visitor_name like '%$visitor_name%' and sign_out is not null order by time_in desc"
		
		
		
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
<!--<meta charset="utf-8">

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

</script>-->
<!--[if lt IE 7]>
<script type="text/javascript" src="js/ie_png.js"></script>
<script type="text/javascript">
	ie_png.fix('.png, .carousel-box .next img, .carousel-box .prev img');
</script>
<link href="ie6.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--<script type="text/javascript" src="../js/datetimepicker_css.js"></script>

<style type="text/css">-->
<!--
@import url("longtable-style.css");
-->
<!--
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
-->
<!--[if lt IE 9]>
<script type="text/javascript" src="js/html5.js"></script>
<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
<![endif]-->




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
         	
             <?php
//get user access level
if(isset($_SESSION['levelaccess']))
{
	$acc_level = $_SESSION['levelaccess'];
}
?>
     <div id="container">       
            
  <h3>Total Signed out visitors: <?php echo $pageObj->getTotalRow(); ?>
      &nbsp;&nbsp;&nbsp; <?php if(isset($msg))echo "<font color='#006600' size='-2'>".$msg."</font>";?>
  </h3>

<p>&nbsp;</p>
            <br/>
   	<form  name="form1" method="post"  action="">

  <table width="350" border="0" align="left">
  <tr>
    <td height="26" align="left" valign="top">Visitor's Name:</td>
    <td><p>
      <input type="text" name="visitor_name" id="visitor_name" size="20"/>
<!--      <input type="text" name="keyword" id="keyword" size="20"/>-->
      
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="26" align="left" valign="top">&nbsp;</td>
    <td><input type="submit" value="Search" name="search" id="search"/></td>
  </tr>
  </table>

</form>
                    <p><br/>
                      <?php
					
                    if($pageObj->getTotalRow() > 0)
					{
	?>
                    </p>
                    <p>&nbsp;</p>
            <p>&nbsp; </p>
            <table width="907" align="center" id="background-image" summary="Meeting Results">
<thead>
                        <tr>
                          <th width="81" align="center" scope="col"><strong>Visitor's Name</strong></th>
                          <th width="77" align="center" scope="col"><strong>Address</strong></th>
                          <th width="76" align="center" scope="col"><strong>Purpose</strong></th>
                          <th width="75" align="center" scope="col"><p class="td_ele"><strong>Phone Number</strong></p></th>
                          <th width="66" align="center" scope="col"><span class="td_ele"><strong>Whom To See</strong></span></th>
                          <th width="55" align="center" scope="col"><strong>Floor</strong></th>
                          <th width="86" align="center" scope="col"><strong>Extension</strong></th>
                          <th width="131" align="center" scope="col"><strong>Time in</strong></th>
                          <th align="center" scope="col"><strong>Sign out</strong></th>
                          <th align="center" scope="col"><strong>Time out</strong></th>
                          <th width="41" align="center" scope="col"><strong>Time Spent</strong>
                

                          
                          
                          
                         <!-- </th>
                          <th width="42" align="center" scope="col"><strong>Tag Number</strong></th>-->
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <td colspan="13" align="center"><?php echo "<a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=1'>[First]</a>".$page_links."<a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=$last'>[Last]</a>"; ?></td>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php $i=0;
					while($rs = mysql_fetch_array($rsd))
					{
				  ?>
				  <?php //echo ++$sl_start; ?>
                        <tr>
             <td align="center"><?php echo $rs['visitor_name'];?>
             </td>
         <td align="center"><?php echo $rs['address'];?></td>
        <td align="center"><?php echo $rs['purpose'];?></td>
 <td align="center"><?php echo $rs['phone_number'];?></td> <td align="center"><?php echo $rs['fullname'];?></td>
 <td align="center"><?php echo $rs['floor'];?></td>
 <td align="center"><?php echo $rs['extension'];?></td>
 <td align="center"><?php echo $rs['time_in'];?></td>
 <td width="54" align="center"><?php echo $rs['sign_out'];?></td>
<td width="73" align="center"><?php echo $rs['time_out'];?></td>
<td align="center">
  
  <!--<a href="sign_out_visitor.php?id=<?php //echo $rs['id'];?>"></a>-->
  
  <?php   
    $dateDiff    =strtotime($rs['time_out']) - strtotime($rs['time_in']) ;   
    $fullDays    = floor($dateDiff/(60*60*24));   
    $fullHours   = floor(($dateDiff-($fullDays*60*60*24))/(60*60));   
    $fullMinutes = floor(($dateDiff-($fullDays*60*60*24)-($fullHours*60*60))/60);  
	//echo  $fullDays.":".$fullHours.":".$fullMinutes; 
    echo "$fullDays days, $fullHours hours and $fullMinutes minutes.";   
?>          
  
  </td>
<!--<td align="center"><?php //echo $rs['tag_number'];?></td>-->
                        </tr>
                        <?php $i++;}?>
                      </tbody>
                      <tfoot>
                      </tfoot>
                      
                      
                  </table>
            
            
            
       <?php
		}
		else{echo "Your search returned no results.";}
				    ?>
      
            
            
            
            
            
       </div>     
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