<?php header('Refresh: 20'); ?>
<object height="50" width="100" data="play/b8_discreet-song.mp3"></object>

<?php
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

//page permission id = 1, permission name =  add contractors
$page_permission_id = 18;

//$acc_level = "";
//$location = "";
if(isset($_SESSION['levelaccess']))
{
	$acc_level = $_SESSION['levelaccess'];
	//$location = $_SESSION['location'];
}/*
session_start();
if(isset($_SESSION['levelaccess']))
{
	$role_id = $_SESSION['levelaccess'];
	
}*/

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
if($role_id == '1')
{}
else
{
   header("location:no_permissions.php");
}*/
//$page_permission_id = 8;



	$signout=$_GET['signout'];
	$signout=$fm->processfield($signout);
    //$id = $_GET['id'];
	// echo 'Test sign out;'.$signout;
	 
	 if(!empty($signout))
	 {
		$msg = $admVisitor->signUserOut($signout); 	 
	 }
	 /*
	 else if(empty($signout))
	 {
	 echo "The query is empty this is not good";
	 }*/
	
	

	/*
		// Variables 
		$page = 1; //default page
		$per_page = 10000000; //rows per page


$full_sql = "select a.id id, a.visitor_name, a.address, a.purpose, a.phone_number, a.floor, a.extension, a.sign_in, a.time_in, a.tag_number, b.fullname  from tbl_cdl_visitors a, tbl_directory b where a.whom_to_see=b.id order by time_in desc";
//and a.time_out=NULL 
$display_links = 11; //number of links to be displayed - odd number

		if(isset($_REQUEST['page']))
			$page = $_REQUEST['page'];
		

	$pageObj = new pagination_count($full_sql, $per_page, $page);

		//$mycount=$pageObj->pagination_ct($full_sql_count);
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

if(isset($_POST['search']))
	{
$visitor_name = $_POST["visitor_name"];
$page = 1; //default page
$per_page = 100000000000;  

$full_sql = "select a.id id, a.visitor_name, a.address, a.purpose, a.phone_number, a.floor, a.extension, a.sign_in, a.time_in, a.tag_number, b.fullname  from tbl_cdl_visitors a, tbl_directory b where a.whom_to_see=b.id and a.time_out=null and a.visitor_name like '%$visitor_name%' order by time_in desc";

//select * from tbl_cdl_visitors where visitor_name like '%$visitor_name%' and time_out = null order by time_in desc
//"select * from tbl_directory where fullname like'%$fullname%'  order by extension, fullname"; //full sql before split in to pages

$display_links = 11; //number of links to be displayed - odd number
		if(isset($_REQUEST['page']))
		$page = $_REQUEST['page'];
		
		//create object, pass the values
		//$pageObj = new pagination($full_sql, $per_page, $page);
$pageObj = new pagination_count($full_sql, $per_page, $page);
//$mycount=$pageObj->pagination_ct($full_sql_count);
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
*/
//pagination
		/*** Variables ***/
		$page = 1; //default page
		$per_page = 20; //rows per page
		$full_sql = "select a.id id, a.visitor_name, a.address, a.purpose, a.phone_number, a.floor, a.extension, a.sign_in, a.time_in, a.tag_number, b.fullname  from tbl_cdl_visitors a, tbl_directory b where a.whom_to_see=b.id and sign_out is null order by time_in desc"; //full sql before split in to pages
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
		$full_sql = "select a.id id, a.visitor_name, a.address, a.purpose, a.phone_number, a.floor, a.extension, a.sign_in, a.time_in, a.tag_number, b.fullname  from tbl_cdl_visitors a, tbl_directory b where a.whom_to_see=b.id and sign_out is null and a.visitor_name like '%$visitor_name%' order by time_in desc"; //full sql before split in to pages

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
        
        
        You are here=> <a href="dashboard.php" title="Dashboard" target="_self">Dashoard</a> -> <a href="view_signed_in_visitors.php" title="View Signed in Visitors" target="_self">Staff Directory Report</a><br/><br/>
         	
             <?php
//get user access level
if(isset($_SESSION['levelaccess']))
{
	$acc_level = $_SESSION['levelaccess'];
}
?>
     <div id="container">       
            
  <h3>Total Signed in visitors: <?php echo $pageObj->getTotalRow(); ?>
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
    <td><input type="submit" value="Search" name="search2" id="search"/></td>
  </tr>
  <tr>
    <td height="26" align="left" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
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
            <table width="869" id="background-image" summary="Meeting Results">
<thead>
                        <tr>
                          <th width="83" align="center" scope="col"><strong>Visitor's Name</strong></th>
                          <th width="81" align="center" scope="col"><strong>Address</strong></th>
                          <th width="76" align="center" scope="col"><strong>Purpose</strong></th>
                          <th width="75" align="center" scope="col"><p class="td_ele"><strong>Phone Number</strong></p></th>
                          <th width="68" align="center" scope="col"><span class="td_ele"><strong>Whom To See</strong></span></th>
                          <th width="74" align="center" scope="col"><strong>Floor</strong></th>
                        <!--  <th width="86" align="center" scope="col"><strong>Extension</strong></th>-->
                          <th width="71" align="center" scope="col"><strong>Signed in?</strong></th>
                          <th width="60" align="center" scope="col"><strong>Time in</strong></th>
                          <th align="center" scope="col"><strong>Tag Number</strong></th>
                         
<?php 
if($_SESSION['username']!='backdesk')
{
?>                         
<th align="center" scope="col"><strong>Sign out</strong></th>
<?php 
}
?>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <td colspan="12" align="center"><?php echo "<a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=1'>[First]</a>".$page_links."<a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=$last'>[Last]</a>"; ?></td>
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
 <!--<td align="center"><?php //echo $rs['extension'];?></td>-->
 <td align="center"><?php echo $rs['sign_in'];?></td>
 <td align="center"><?php echo $rs['time_in'];?></td>
<td width="75" align="center"><?php echo $rs['tag_number'];?></td>


<?php 
if($_SESSION['username']!='backdesk')
{
?>

<td width="72" align="center">

<!--<a href="sign_out_visitor.php?id=<?php //echo $rs['id'];?>"></a>-->


<a href="view_signed_in_visitors.php?signout=<?php echo $rs['id'];?>" onClick="return confirm('This means the visitor is leaving CDL for now, Are you sure you want to sign this user out... this cannot be undone, the visitor would have to sign in again?');"><img  src="../images/signout.jpg" width="33" height="33"></a>


</td> 

 <?php 
}
 ?>     
   
        
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