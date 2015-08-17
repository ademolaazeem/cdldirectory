<?php 

//page permission id = 8, permission name =  view contractor account reports
$page_permission_id = 17;

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

		//building queries based upon access levels
/*
		if($acc_level == 2)
		{
			$full_sql = "select * from tbl_contractor_account WHERE contractor_id in (select id from tbl_contractor where business_area = '$location') order by created_date"; //full sql before split in to pages
			
			
$full_sql_count = "select sum(amount_deposited)amount from tbl_contractor_account  WHERE contractor_id in (select id from tbl_contractor where business_area = '$location')";

		}
		elseif($acc_level == 3)
		{//hqusers with acc level = 3 should not see information about Area J4 Corporation with location id = 10
			$full_sql = "select * from tbl_contractor_account WHERE contractor_id in (select id from tbl_contractor where business_area NOT IN (SELECT forest_location from tbl_location WHERE id = 10)) order by created_date"; //full sql before split in to pages
			
			
$full_sql_count = "select sum(amount_deposited)amount from tbl_contractor_account  WHERE contractor_id in (select id from tbl_contractor where business_area NOT IN (SELECT forest_location from tbl_location WHERE id = 10))";

		}
		elseif($acc_level == 4)
		{*/
			/*we are have to check the director's location so that if its Area J4-Corporation, only those records for that area are displayed 
		          else we display all records except Area J4-Corporation*/
			/*$check_query = "SELECT *from tbl_location WHERE  forest_location = '$location' && id = 10";
			$check_result = mysql_query($check_query);
			$nos_result_check = mysql_num_rows($check_result);
			if($nos_result_check > 0)
			{ //i.e if this fellow is of Area_j4
				$full_sql = "select * from tbl_contractor_account WHERE contractor_id in (select id from tbl_contractor where business_area IN (SELECT forest_location from tbl_location WHERE id = 10)) order by created_date"; //full sql before split in to pages
			
			
				$full_sql_count = "select sum(amount_deposited)amount from tbl_contractor_account  WHERE contractor_id in (select id from tbl_contractor where business_area IN (SELECT forest_location from tbl_location WHERE id = 10))";
			}
			else
			{
$full_sql = "select * from tbl_contractor_account WHERE contractor_id in (select id from tbl_contractor where business_area NOT IN (SELECT forest_location from tbl_location WHERE id = 10)) order by created_date"; //full sql before split in to pages
			
			
$full_sql_count = "select sum(amount_deposited)amount from tbl_contractor_account  WHERE contractor_id in (select id from tbl_contractor where business_area NOT IN (SELECT forest_location from tbl_location WHERE id = 10))";
			}
		}
		else
		{
			*/
$full_sql = "select * from tbl_directory order by fullname, extension";
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
$fullname = $_POST["fullname"];
$page = 1; //default page
$per_page = 100000000000;  

$full_sql = "select * from tbl_directory where fullname like'%$fullname%'  order by fullname, extension"; //full sql before split in to pages

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
<html>
<head>
	<title>Print list of Staff </title>
    
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
    <p style="text-align:center; font-weight:bold; padding-top:5mm;">LIST OF STAFF IN THE DIRECTORY AND THEIR DIRECTORY DETAILS</p>
    <br />
<table width="80%" height="119" class="heading" style="width:80%;">
    	<tr>
    		<td width="317" height="113" style="width:80mm;">
    			<?php 
				include('address.php');
				?>
                </td>
			<td width="302" align="center" valign="middle" style="padding:3mm;"><img src="../images/logo.png" width="285" height="52"></td>
		</tr>
   	</table>
		
		
	<div id="content">
		
		<div id="invoice_body">
<!--			<table width="80%">-->
            <table width="80%">
      
      
  
    
            
            
            
			<tr style="background:#eee;">
				<td width="18%" style="width:8%;"><b>Fullname</b></td>
				
				<td width="15%"><b>Department</b></td>
				<td width="20%"><span style="width:8%;"><strong>Extension</strong></span></td>
				<td width="16%"><strong>Mobile</strong></td>
				<td width="31%"><span style="width:8%;"><b><strong>Email</strong></b></span></td>
			  </tr>
              
              
 <tbody>
                        <?php $i=0;
while($rs = mysql_fetch_array($rsd))
	
	{
				  ?>
				  <?php //echo ++$sl_start; ?>
<tr style="background:#eee;">
             <td align="center"><span style="width:8%;"><?php echo $rs['fullname'];?></span></td>
         
        <td align="center"><?php echo $rs['department'];?></td>
         <td align="center"><?php echo $rs['extension']; ?></td>
 <td align="center"><?php echo $rs['mobile'];?></td>
 
 <td align="center"><?php echo $rs['email'];?></td>
        </tr>
  <?php $i++;}?>
     </tbody>

                       
        
        
                  
            
          <tr style="background:#eee;">
  <td colspan="5" align="center"><h4>Total Existing Staff: <?php echo $pageObj->getTotalRow(); ?>&nbsp;</h4></td>
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
