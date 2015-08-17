<?php 
//error_reporting(0);
?>
<?php 

//page permission id = 1, permission name =  add contractors
$page_permission_id = 16;

include('authenticate.php');
require_once("../ClassesController/Utilities.php");
require_once("restrict.php");
require_once("../ClassesController/DBDirect.php");
require_once("../ClassesController/AdminManager.php");
require_once("../ClassesController/AdminVisitor.php");
$db = new DBConnecting();
$adm = new AdminController();
$admVisit = new CDLVisitor();
	
$util = new Utilities();

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
	
	
	
$visitor_name = mysql_real_escape_string($_POST['visitor_name']);
$address=mysql_real_escape_string(strtoupper($_POST['address']));
$purpose= mysql_real_escape_string(strtoupper($_POST['purpose']));
$whom_to_see = mysql_real_escape_string($_POST['whom_to_see']);
$floor = mysql_real_escape_string($_POST['floor']);
$phone_number = mysql_real_escape_string($_POST['phone_number']);
$sign_in = mysql_real_escape_string($_POST['sign_in']);
$tag_number = mysql_real_escape_string($_POST['tag_number']);
$extension = mysql_real_escape_string($_POST['extension']);

$_SESSION['visitor_name']=$visitor_name;
$_SESSION['address']=$address;
$_SESSION['purpose']=$purpose;
$_SESSION['whom_to_see']=$whom_to_see;
$_SESSION['floor']=$floor;
$_SESSION['phone_number']=$phone_number;
$_SESSION['sign_in']=$sign_in;
$_SESSION['tag_number']=$tag_number;
$_SESSION['extension']=$extension;
	

	
	
	if(isset($_POST['save']))
	{
		$msg = $admVisit->Visitor_Registration();
	}	
?>







<!DOCTYPE html>
<html lang="en">
<head>
<title>CDL Staff Directory</title>
<meta charset="utf-8">
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
          <h2> Sign Visitor out</h2>
          
          <fieldset>
   <form id="form" name="form" method="post" action="">
   
 <table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td colspan="2" align="center"><h3>Registration Page</h3>
    <br/>
    <strong><span class="green">
      <?php if(isset($msg))echo $msg;?>
      </span></strong>	</td>
    </tr>
  <tr>
    <td width="22%" height="6" align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    </tr>
  <tr>
    <td height="47" align="left">Sign user out?:*</td>
    <td align="left"><select  name="sign_in">
      <option selected="selected" value="Yes">Yes</option>
        <option value="No">No</option>
    </select></td>
  </tr>
 <!-- <tr>
    <td align="left">Tax Identification Number:</td>
    <td><input type="text" name="tin" id="tin" value="<?php //echo $_POST['tin'];?>"/></td>
    </tr>-->
  <tr>
    <td width="22%" rowspan="2" align="left">&nbsp;</td>
    <td><input type="submit" name="save" id="save" value="Sign-in Now" /></td>
  </tr>
  <tr>
    <td width="377" align="left"><!--<input type="submit" name="register" id="register" value="Register" />-->
      
      <!--<input name="save" type="button" value="Save Now">--></td>
  </tr>
  <?php
//for access level 2 users, they can only register contractors for their location
if($acc_level == 2)
{
?>
<input type = "hidden" name = "business_area" id = "business_area" value = "<?php echo $location; ?>" />
<?php
}
elseif ($acc_level == 3)
{//here we want to make sure that hq users do not get to see Area_J4
?>
  <?php
}

else{
?>
  <?php
}
?>
    
 <tr>
   <td align="left">&nbsp;</td>
   <td align="left"></td>
 </tr>
  
 </table>
 </form>
</fieldset>

          
          
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
<script type="text/javascript">
$("#whom_to_see").change(function() {
	$("#floor").load("getter.php?whom_to_see=" + $("#whom_to_see").val());
	$("#extension").load("exGetter.php?whom_to_see=" + $("#whom_to_see").val());
});
</script>
</body>
</html>