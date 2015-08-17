<?php 

//page permission id = 8, permission name =  view contractor account reports
$page_permission_id = 14;

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

		
	//pagination
		/*** Variables ***/
		$page = 1; //default page
		$per_page = 1000000000; //rows per page

$full_sql = "select a.id id, a.visitor_name, a.address, a.purpose, a.phone_number, a.floor, a.extension, a.sign_in, a.time_in, a.sign_out, a.time_out, a.tag_number, b.fullname  from tbl_cdl_visitors a, tbl_directory b where a.whom_to_see=b.id order by time_in desc";
//$full_sql_count = "select sum(amount_deposited)amount from tbl_contractor_account";

		//}
		$display_links = 11; //number of links to be displayed - odd number
		/*** Variables ***/
		//check page number
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
		//New addition for Search button

if(isset($_POST['generate']))
	{
$visitor_name = $_POST["visitor_name"];
$start_date = isset($_REQUEST["start_date"]) ? $_REQUEST["start_date"] : "";
$end_date = isset($_REQUEST["end_date"]) ? $_REQUEST["end_date"] : "";


if(empty($start_date) && empty($end_date) && !empty($visitor_name))
{
$page = 1; //default page
$per_page = 100000000000;  

$full_sql = "select a.id id, a.visitor_name, a.address, a.purpose, a.phone_number, a.floor, a.extension, a.sign_in, a.time_in, a.sign_out, a.time_out, a.tag_number, b.fullname  from tbl_cdl_visitors a, tbl_directory b where a.whom_to_see=b.id and a.visitor_name like '%$visitor_name%' order by time_in desc"; //full sql before split in to pages

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
else if(!empty($start_date) && !empty($end_date))
{
	
	$page = 1; //default page
$per_page = 100000000000;  

$full_sql = "select a.id id, a.visitor_name, a.address, a.purpose, a.phone_number, a.floor, a.extension, a.sign_in, a.time_in, a.sign_out, a.time_out, a.tag_number, b.fullname  from tbl_cdl_visitors a, tbl_directory b where a.whom_to_see=b.id and (time_in between '$start_date' and '$end_date') order by time_in desc"; //full sql before split in to pages

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
else
{
		
	$page = 1; //default page
$per_page = 100000000000;  

$full_sql = "select a.id id, a.visitor_name, a.address, a.purpose, a.phone_number, a.floor, a.extension, a.sign_in, a.time_in, a.sign_out, a.time_out, a.tag_number, b.fullname  from tbl_cdl_visitors a, tbl_directory b where a.whom_to_see=b.id order by time_in desc"; //full sql before split in to pages

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
	
}//else part
    
 }		

		
?>

<!DOCTYPE html>
<html>
<head>
	<title>Print list of Visitors </title>
    
     <link rel="icon" type="image/png" href="../images/favicon.png">
     <link rel="stylesheet" type="text/css" href="../css/superfish.css" media="screen">
    <script>
	function printpage()
  {
  window.print()
  }
</script>

<style type="text/css">
@media print {

input#btnPrint {

display: none;

}
button#btnPrint1 {

display: none;

}


}

</style>
	<style>
		*
		{
			margin:0;
			padding:0;
			font-family:Arial;
			font-size:10pt;
			color:#000;
		}
		body
		{
			width:100%;
			font-family:Arial;
			font-size:10pt;
			margin:0;
			padding:0;
		}
		
		p
		{
			margin:0;
			padding:0;
		}
		
		#wrapper
		{
			width:180mm;
			margin:0 15mm;
		}
		
		.page
		{
			height:297mm;
			width:210mm;
			page-break-after:always;
		}

		table
		{
			border-left: 1px solid #ccc;
			border-top: 1px solid #ccc;
			
			border-spacing:0;
			border-collapse: collapse; 
			
		}
		
		table td 
		{
			border-right: 1px solid #ccc;
			border-bottom: 1px solid #ccc;
			padding: 2mm;
		}
		
		table.heading
		{
			height:50mm;
		}
		
		h1.heading
		{
			font-size:14pt;
			color:#000;
			font-weight:normal;
		}
		
		h2.heading
		{
			font-size:9pt;
			color:#000;
			font-weight:normal;
		}
		
		hr
		{
			color:#ccc;
			background:#ccc;
		}
		
		#invoice_body
		{
			height: 149mm;
		}
		
		#invoice_body , #invoice_total
		{	
			width:100%;
		}
		#invoice_body table , #invoice_total table
		{
			width:80%;
			border-left: 1px solid #ccc;
			border-top: 1px solid #ccc;
	
			border-spacing:0;
			border-collapse: collapse; 
			
			margin-top:5mm;
		}
		
		#invoice_body table td , #invoice_total table td
		{
			text-align:center;
			font-size:9pt;
			border-right: 1px solid #ccc;
			border-bottom: 1px solid #ccc;
			padding:2mm 0;
		}
		
		#invoice_body table td.mono  , #invoice_total table td.mono
		{
			font-family:monospace;
			text-align:right;
			padding-right:3mm;
			font-size:10pt;
		}
		
		#footer
		{	
			width:180mm;
			margin:0 15mm;
			padding-bottom:3mm;
		}
		#footer table
		{
			width:100%;
			border-left: 1px solid #ccc;
			border-top: 1px solid #ccc;
			
			background:#eee;
			
			border-spacing:0;
			border-collapse: collapse; 
		}
		#footer table td
		{
			width:25%;
			text-align:center;
			font-size:9pt;
			border-right: 1px solid #ccc;
			border-bottom: 1px solid #ccc;
		}
	</style>
</head>
<body>
    <p style="text-align:center; font-weight:bold; padding-top:5mm;">LIST OF VISITORS AND DETAILS</p>
    <br />
<table width="80%" height="119" class="heading" style="width:80%;">
    	<tr>
    		<td width="317" height="113" style="width:80mm;">
    			<?php 
				include('address.php');
				?>
                </td>
			<td width="302" align="center" valign="middle" style="padding:3mm;"><img src="../images/logo.png" width="300" height="52"></td>
		</tr>
   	</table>
		
		
	<div id="content">
		
		<div id="invoice_body">
<!--			<table width="80%">-->
            <table width="82%">
      
      
  
    
            
            
            
			<tr style="background:#eee;">
				<td width="11%" style="width:8%;"><b>Visitor Name</b></td>
				
				<td width="12%"><b>Address</b></td>
                <td width="11%"><strong>Mobile</strong></td>
                <td width="16%"><b>Time in</b></td>
				<td width="9%"><b>Time out</b></td>
				<td width="11%"><b>Whom to See</b></td>
                
				
				<td width="16%"><span style="width:8%;"><strong>Extension</strong></span></td>
				<td width="14%"><span style="width:8%;"><b><strong>Floor</strong></b></span></td>
			  </tr>
              
              
 <tbody>
                        <?php $i=0;
while($rs = mysql_fetch_array($rsd))
	
	{
				  ?>
				  <?php //echo ++$sl_start; ?>
<tr style="background:#eee;">
             <td align="center"><span style="width:8%;"><?php echo $rs['visitor_name'];?></span></td>
         
        <td align="center"><?php echo $rs['address'];?></td>
        <td align="center"><?php echo $rs['phone_number'];?></td>
        <td align="center"><?php echo $rs['time_in'];?></td>
        <td align="center"><?php echo $rs['time_out'];?></td>
        <td align="center"><?php echo $rs['fullname'];?></td>
        <td align="center"><?php echo $rs['extension']; ?></td>
         <td align="center"><?php echo $rs['floor'];?></td>
        </tr>
  <?php $i++;}?>
     </tbody>

                       
        
        
                  
            
          <tr style="background:#eee;">
  <td colspan="8" align="center"><h4>Total Visitors: <?php echo $pageObj->getTotalRow(); ?>&nbsp;</h4></td>
  </tr>
            
              
              
              
			
			</table>
            <br/>
		  <p><input type="button" id="btnPrint" value="Print Now" onclick="printpage()">
		  <!--
		    &nbsp;&nbsp;&nbsp;<button onclick="window.location.href='view_contractor_account.php'" id="btnPrint1">Go Back</button>
                  -->                 
 </p>
		  <p>&nbsp;</p>
		  <!--<p><em><strong>Please Note: That this is a receipt for the confirmation of your payment.</strong></em></p>-->
      </div>
		
</div>

	
</body>
</html>
