<?php 

//page permission id = 8, permission name =  view contractor account reports
$page_permission_id = 21;

require_once("restrict.php");
require_once("../ClassesController/DBDirect.php");
require_once("../ClassesController/AdminManager.php");
require_once('../ClassesController/class.paginationcount.php');
	
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
		$per_page = 10000000; //rows per page


$full_sql = "select * from tbl_directory order by fullname";

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
$fullname = $_POST["fullname"];
$page = 1; //default page
$per_page = 100000000000;  

$full_sql = "select * from tbl_directory where fullname like'%$fullname%' or email like '%$keyword%' or extension like '%$keyword%' order by fullname"; //full sql before split in to pages

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
         	You are here=> <a href="dashboard.php" title="Dashboard" target="_self">Dashoard</a> -> <a href="view_staff_directory_view.php" title="View Directory" target="_self">View Staff Directory</a><br/><br/>
            
            
            
            <h4>Total Existing Staff in the Directory: <?php echo $pageObj->getTotalRow(); ?> &nbsp;&nbsp;&nbsp;&nbsp;<a href="_new_staff_directory.php" title="Create New Staff Directory" class="green">Create New Staff Directory</a>
                           
                        
          </h4>

                    <br/>
   	<form  name="form1" method="post"  action="">
	  <div>
  <table width="350" border="0" align="left">
  <tr>
    <td height="26" align="left" valign="top">Fullname, Email or Extension:</td>
    <td><p>
      <input type="text" name="fullname" id="fullname" size="20"/>
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
</div>
</form>
    
    <p><br/>
      </p>
    <p>&nbsp;</p>
    <p><br/>
    </p>
    
    <?php
    if($pageObj->getTotalRow() > 0)
					{
					 ?>
    <table width="796" id="background-image" summary="Meeting Results">
<thead>
                        <tr>
                          <th width="119" align="center" scope="col"><strong>Fullname</strong></th>
                          <th width="130" align="center" scope="col"><strong>Department</strong></th>
                          <th width="86" align="center" scope="col"><strong>Extension</strong></th>
                          <th width="105" align="center" scope="col"><span class="td_ele"><strong>Mobile</strong></span></th>
                          <th width="34" align="center" scope="col"><strong>Email</strong></th>
                          <th width="35" align="center" scope="col"><strong>Floor</strong></th>
                          <th width="115" align="center" scope="col"><strong>Created Date</strong></th>
                          <th width="138" align="center" scope="col"><strong>Creator</strong></th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <td colspan="9" align="center"><?php echo "<a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=1'>[First]</a>".$page_links."<a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=$last'>[Last]</a>"; ?></td>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php $i=0;
					while($rs = mysql_fetch_array($rsd))
					{
				  ?>
				  <?php //echo ++$sl_start; ?>
                        <tr>
             <td align="center"><a href="man_staff_directory.php?id=<?php echo $rs['id'];?>" title="Administer <?php echo $rs['name'];?>"><?php echo $rs['fullname'];?></a>
             </td>
         <td align="center"><?php echo $rs['department'];?></td>
        <td align="center"><?php echo $rs['extension'];?></td>
         <td align="center"><?php echo $rs['mobile'];?></td>
         <td align="center"><?php echo $rs['email'];?></td>
         <td align="center"><?php echo $rs['floor'];?></td>
 <td align="center"><?php echo $rs['created_date'];?></td>
 <td align="center"><?php echo $rs['maker'];?></td>
                        </tr>
                        <?php $i++;}?>
                      </tbody>
                      <tfoot>
                      </tfoot>
                      
                      
                    </table>
            
            
             <?php
					}
					else{echo "Your search returned no results. Click the following link to continue: <a href='view_staff_directory_view.php'> View Staff Directory </a>" ;}
				    ?> 
            
            
            
            
            
            
            
            
            
                      
          
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