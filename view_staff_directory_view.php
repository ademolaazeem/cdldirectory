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

$full_sql = "select * from tbl_directory where fullname like '%$fullname%' or email like '%$fullname%' or extension like '%fullname%' or department like '%fullname%' order by extension, fullname"; //full sql before split in to pages

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








<link rel="shortcut icon" href="images/favicon.ico">


<!--<link rel="icon" type="image/png" href="images/favicon.png">-->



  <script src="cdl/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="cdl/js/cufon-yui.js" type="text/javascript"></script>
<script src="cdl/js/cufon-replace.js" type="text/javascript"></script>
<script src="cdl/js/AvantGarde_Bk_BT_400.font.js" type="text/javascript"></script>
<script src="cdl/js/Myriad_Pro_300.font.js" type="text/javascript"></script>
<script src="cdl/js/jcarousellite.js" type="text/javascript"></script>
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
<script type="text/javascript" src="tcn/chromejs/chrome.js">

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
<script type="text/javascript" src="js/datetimepicker_css.js"></script>

<style type="text/css">
<!--
@import url("cdl/longtable-style.css");
-->
</style>
 <link rel="stylesheet" href="css/style.css">
<script src="jquery/1.5.1/jquery.min.js"></script>
  <script src="js/slides.min.jquery.js"></script>

<link rel="stylesheet" href="css/reset.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen">
<script type="text/javascript" src="js/jquery-1.6.min.js"></script>
<script src="js/cufon-yui.js" type="text/javascript"></script>
<script src="js/cufon-replace.js" type="text/javascript"></script>
<script src="js/Open_Sans_400.font.js" type="text/javascript"></script>
<script src="js/Open_Sans_Light_300.font.js" type="text/javascript"></script>
<script src="js/Open_Sans_Semibold_600.font.js" type="text/javascript"></script>
<script src="js/FF-cash.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="js/html5.js"></script>
<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
<![endif]-->
</head>
<body id="page3">
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

<div class="row-2">
<nav>
          <ul class="menu">
            <li><a class="active" href="index.php">Home Page</a></li>
<li><a class="active" href="view_staff_directory_view.php">View Staff Directory</a></li>
  
            <li class="last-item"><a href="cdl/index.php">Login</a></li>
          </ul>
        </nav>
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
    <td height="26" align="left" valign="top">Search Criteria:</td>
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
                    
                    
      <p><br/>
        <br/>
      </p>
      <p><br/>
      </p>
      <?php
        if($pageObj->getTotalRow() > 0)
					{
					 ?>
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
            
           <?php
					}
					else{echo "Your search returned no results. Click the following link to continue: <a href='view_staff_directory_view.php'> View Staff Directory </a>" ;}
				    ?> 
            
            
            
            
            
            
            
            
            
            
                      
          
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
</body>
</html>