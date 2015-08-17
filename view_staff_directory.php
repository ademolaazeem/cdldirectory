<?php 

//page permission id = 8, permission name =  view contractor account reports
$page_permission_id = 8;

//require_once("cdl/restrict.php");
require_once("ClassesController/DBDirect.php");
require_once("ClassesController/AdminManager.php");
require_once('ClassesController/class.paginationcount.php');
	
$db = new DBConnecting();
	
$remove = new AdminController();



?>
<?php 

	
	//pagination
		/*** Variables ***/
		$page = 1; //default page
		$per_page = 10000000; //rows per page


$full_sql = "select * from tbl_directory order by extension, fullname";

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

$full_sql = "select * from tbl_directory where fullname like'%$fullname%'  order by extension, fullname"; //full sql before split in to pages

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
<link rel="stylesheet" href="css/reset.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen">
<script type="text/javascript" src="js/jquery-1.6.min.js"></script>
<script src="js/cufon-yui.js" type="text/javascript"></script>
<script src="js/cufon-replace.js" type="text/javascript"></script>
<script src="js/Open_Sans_400.font.js" type="text/javascript"></script>
<script src="js/Open_Sans_Light_300.font.js" type="text/javascript"></script>
<script src="js/Open_Sans_Semibold_600.font.js" type="text/javascript"></script>
<script type="text/javascript" src="js/tms-0.3.js"></script>
<script type="text/javascript" src="js/tms_presets.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script src="js/FF-cash.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="js/html5.js"></script>
<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
<![endif]-->
</head>
<body id="page1">
<!-- header -->
<div class="bg">
  <div class="main">
    <header>
      <div class="row-1">
        <h1> <a class="logo" href="index.php">Consolidated Discounts Limited</a> <strong class="slog">The Directory Portal for CDL Staff</strong> </h1>
       <form id="search-form" action="#" method="post" enctype="multipart/form-data">
          <fieldset>
           <div class="search-form">
              <input type="text" name="search" value="Type Keyword Here" onBlur="if(this.value=='') this.value='Type Keyword Here'" onFocus="if(this.value =='Type Keyword Here' ) this.value=''" />
              <a href="#">Search</a> </div>
          </fieldset>
        </form>
      </div>
    
 <?php
 include('header_out.php');
 ?>
      <div class="row-3">
        <div class="slider-wrapper">
          <div class="slider">
            
             </div>
        </div>
      </div>
    </header>
    <!-- content -->
    <section id="content">
      <div class="padding">
        
            <div class="indent">
                       
            
<h4>Total Existing Staff in the Directory: <?php echo $pageObj->getTotalRow(); ?></h4>

                    <br/>
   	<form  name="form1" method="post"  action="">
	  <div>
  <table width="350" border="0" align="left">
  <tr>
    <td height="26" align="left" valign="top">Fullname:</td>
    <td><p>
      <input type="text" name="fullname" id="fullname" size="20"/>
<!--      <input type="text" name="keyword" id="keyword" size="20"/>-->
      
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td><input type="submit" value="Search" name="search" id="search"/></td>
  </tr>
  </table>
</div>
</form>
                    
                    
      <br/><br/><br/>
                    <table width="796" id="background-image" summary="Meeting Results">
                      <thead>
                        <tr>
                          <th width="187" align="center" scope="col"><strong>Fullname</strong></th>
                          <th width="124" align="center" scope="col"><strong>Department</strong></th>
                          <th width="107" align="center" scope="col"><strong>Extension</strong></th>
                          <th width="123" align="center" scope="col"><span class="td_ele"><strong>Mobile</strong></span></th>
                          <th width="136" align="center" scope="col"><strong>Email</strong></th>
                          <th width="91" align="center" scope="col"><strong>Floor</strong></th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <td colspan="7" align="center"><?php echo "<a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=1'>[First]</a>".$page_links."<a href='http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?page=$last'>[Last]</a>"; ?></td>
                        </tr>
                      </tfoot>
                      <tbody>
                        <?php $i=0;
					while($rs = mysql_fetch_array($rsd))
					{
				  ?>
				  <?php //echo ++$sl_start; ?>
                        <tr>
<td align="center"><?php echo $rs['fullname'];?></a>
             </td>
         <td align="center"><?php echo $rs['department'];?></td>
        <td align="center"><?php echo $rs['extension'];?></td>
         <td align="center"><?php echo $rs['mobile'];?></td>
         <td align="center"><?php echo $rs['email'];?></td>
         <td align="center"><?php echo $rs['floor'];?></td>
 </tr>
                        <?php $i++;}?>
                      </tbody>
                      <tfoot>
                      </tfoot>
                      
                      
                    </table>
              </div>
         
      </div>
    </section>
    <!-- footer -->
    <?php
include('footer.php');
    ?>
  </div>
</div>
<script type="text/javascript">Cufon.now();</script>
<script type="text/javascript">
$(function () {
    $('.slider')._TMS({
        prevBu: '.prev',
        nextBu: '.next',
        playBu: '.play',
        duration: 800,
        easing: 'easeOutQuad',
        preset: 'simpleFade',
        pagination: false,
        slideshow: 3000,
        numStatus: false,
        pauseOnHover: true,
        banners: true,
        waitBannerAnimation: false,
        bannerShow: function (banner) {
            banner.hide().fadeIn(500)
        },
        bannerHide: function (banner) {
            banner.show().fadeOut(500)
        }
    });
})
</script>
<!--
<div align=center>This template  downloaded form <a href='http://all-free-download.com/free-website-templates/'>free website templates</a></div>
-->
</body>
</html>
