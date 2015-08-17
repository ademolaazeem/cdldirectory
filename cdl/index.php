<?php 
    error_reporting(0);
	require_once("../ClassesController/DBDirect.php");
	require_once("../ClassesController/AdminManager.php");
	require_once("../ClassesController/StudentManager.php");
	
	$db = new DBConnecting();
	$adm = new AdminController();
	$std = new StudentController();
	
	if(isset($_POST['btnlogin']))
	{
		//userType
		$userType = $_POST['userType'];
		if ($userType=='Staff')
			$msg = $std->studLogin();
		else
			$msg = $adm->adminLogin();
	}
	
	if(isset($_GET['r']) && base64_decode($_GET['r'])=="failed")
	{ 
		$msg = "<div class=\"errortitle\">Invalid Username or Password</div>";
	}
	if(isset($_GET['r']) && base64_decode($_GET['r'])=="empty")
	{ 
		$msg = "<div class=\"errortitle\">Please enter your login details</div>";
	}
	if(isset($_GET['r']) && base64_decode($_GET['r'])=="logout")
	{ 
		$msg = "<div class=\"errortitle\">You have successfully logged out.</div>"; 
	}
	if(isset($_GET['r']) && base64_decode($_GET['r'])=="uas")
	{ 
		$msg = "<div class=\"errortitle\">Unauthorized access, Please log in</div>";
	}
 	if(isset($_GET['r']) && base64_decode($_GET['r'])=="inactiveuser")
	{ 
		$msg = "<div class=\"errortitle\">Your account has not been activated.</div>";
	}
		  
		  
	/*
	$schQry = "select * from tblschooldata";
$schData = $db->fetchData($schQry);
$sch = $schData['shortform'];*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<head>
<meta name="author" content="Consolidated Discounts Liimited">
<meta name="keywords" content="Consolidated Discounts Liimited - Staff Directory Portal Login">
<meta name="description" content="Consolidated Discounts Liimited">
<title>Consolidated Discounts Liimited - Staff Directory Portal Login</title>
<link rel="shortcut icon" href="images/favicon.ico">
	
	<title>Login Page</title>
	
<!--	<link rel="shortcut icon" href="..images/favicon.ico">-->
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

	<form id="login-form" name="form2" method="post" action="" autocomplete="off">
		<fieldset>
		<br /><br />
			<legend>Log in</legend>
<div align = center><font color = "red" size="-1"><b><?php echo $msg; ?></b></font></div>
	<!--
			<label for="login">User Type</label>
		  <select name="userType" id="userType">
		    <option value="Staff" selected="selected">Staff</option>
		    <option value="Admin">Admin</option>
		  </select>
	-->
	 <input type = "hidden" name="userType" value="Admin" />
	
          <label for="login">Username</label>
			<input type="text" id="login" name="uname" size="30" class="mO"/>	
		  <div class="clear"></div>
			
			<label for="password">Password</label>
			<input name="pword" type="password" class="mO" id="password" size="40">
<table width="350" border="0" align="right">
  <!--<tr>
    <td width="294" align="right">			<font size="-2"><?php echo $msg; ?></font></td>
    <td width="46">&nbsp;</td>
  </tr>-->
</table>

            <div class="clear"></div>
			
		  <label for="remember_me" style="padding: 0;">Remember me?</label>
			<input type="checkbox" id="remember_me" style="position: relative; top: 3px; margin: 0; " name="remember_me"/>
			<div class="clear"></div>
			
			<br />
			
			<input type="submit" style="margin: -20px 0 0 287px;" class="button" name="btnlogin" value="Log in"/>	
		</fieldset>
	</form>

</body>

</html>
