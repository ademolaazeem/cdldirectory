<?php 
//error_reporting(0);
?>
<?php 

//page permission id = 1, permission name =  add contractors
$page_permission_id = 1;

include('authenticate.php');
require_once("../ClassesController/Utilities.php");
$db = new DBConnecting();
$adm = new AdminController();
$admContr = new Contractor();
	
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
	
	
	
$fullname = mysql_real_escape_string($_POST['fullname']);
$department=mysql_real_escape_string(strtoupper($_POST['department']));
$extension= mysql_real_escape_string(strtoupper($_POST['extension']));
$mobile = mysql_real_escape_string($_POST['mobile']);
$floor = mysql_real_escape_string($_POST['floor']);
$email = mysql_real_escape_string($_POST['email']);
	
$_SESSION['fullname']=$fullname;
$_SESSION['department']=$department;
$_SESSION['extension']=$extension;
$_SESSION['mobile']=$mobile;
$_SESSION['floor']=$floor;
$_SESSION['email']=$email;
		
	
	
	if(isset($_POST['save']))
	{
		$msg = $admContr->Staff_Directory_Registration();
	}	
?>







<!DOCTYPE html>
<html lang="en">
<head>
<title>CDL Staff Directory</title>
<meta charset="utf-8">

<link rel="shortcut icon" href="images/favicon.ico">

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

<script type="text/javascript" src="audio-player.js"></script> 
<script type="text/javascript">  
    AudioPlayer.setup("player.swf", {  
        width: 290
    });

    function moo() {
        AudioPlayer.embed("player", {soundFile: "b8_discreet-song.mp3", autostart: 'yes'});  
    }

    function foo() {
        AudioPlayer.embed("player", {soundFile: "sounds-767-arpeggio.mp3", autostart: 'yes'});  
    }
</script>  
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
        You are here=> <a href="dashboard.php" title="Dashboard" target="_self">Dashoard</a> -> <a href="_new_staff_directory.php" title="New Staff Directory" target="_self">New Staff Directory</a>
          <h2> New Staff Directory</h2>
          
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
    <td height="40" align="left">Staff Full Name:*</td>
    <td align="left"><input type="text" name="fullname" id="fullname" value="<?php echo $_POST['fullname'];?>"/></td>
  </tr>
 <!-- <tr>
    <td align="left">Tax Identification Number:</td>
    <td><input type="text" name="tin" id="tin" value="<?php //echo $_POST['tin'];?>"/></td>
    </tr>-->
  <tr>
    <td height="38" align="left">Department:</td>
    <td><input type="text" name="department" id="department" value="<?php echo $_POST['department'];?>"/></td>
  </tr>
  <tr>
    <td height="36" align="left">Extension:<br></td>
    <td align="left"><input type="text" name="extension" id="extension" value="<?php echo $_POST['extension'];?>"/></td>
    </tr>
  <tr>
    <td height="41" align="left">Phone Number:*</td>
    <td align="left"><input type="text" name="mobile" id="mobile" value="<?php echo $_POST['mobile'];?>"/></td>
    </tr>
  <tr>
    <td height="37" align="left">Floor</td>
    <td align="left">
    <select name="floor">
      <option value="GROUND_FLOOR">GROUND_FLOOR</option>
      <option value="1ST_FLOOR">1ST_FLOOR</option>
      <option value="2ND_FLOOR">2ND_FLOOR</option>
      <option value="3RD_FLOOR">3RD_FLOOR</option>
    </select>
    <!--<input type="text" name="floor" id="floor" value="<?php //echo $_POST['floor'];?>"/>--></td>
  </tr>
  <tr>
    <td width="22%" height="36" align="left">Email:</td>
    <td width="377" align="left"><input type="text" name="email" id="email" value="<?php echo $_POST['email'];?>"/></td>
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
   <td align="left">
     
     <!--<input type="submit" name="register" id="register" value="Register" />-->
     
<!--<input name="save" type="button" value="Save Now">-->
<input type="submit" name="save" id="save" value="Register Now" />
     
     
     </td>
 </tr> 

  
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left"></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">
    
    <!--<div id="player"></div><br />
   		 <a href="#" onClick="moo();">play file 1</a><br />
        <a href="#" onClick="foo();">play file 2</a>
    --></td>
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
</body>
</html>