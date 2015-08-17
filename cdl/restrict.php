<?php
//******************************
//* Page Restriction Code 
//* By Oluwatosin M. Adesanya
//* 24th July, 2009.
//******************************

//this restriction page is suitable for restriction which involves roles
//therefore a role variable must be specified on any page in which this file
//is included BEFORE the include line.
//an example
	error_reporting(0);

if(!isset($_SESSION)){
	session_start();
}	
//page restriction code begins here
if(!(isset($_SESSION['adlogged']) && $_SESSION['adlogged']=="true")){
	header("location:index.php?r=".base64_encode('uas'));
} //elseif(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=="true") {
	//next check the role or permission
	//$drole=explode(",",$role);
//	//set a flag
//	$ispermitted=false;
//	for($i=0;$i<count($drole);$i++)
//	{
//		if($_SESSION['role']==$drole[$i])
//			$ispermitted=true;
//	}
//	if($ispermitted==false)
//		header("location:acdend.php");
//}
//page restriction code ends here ?>
