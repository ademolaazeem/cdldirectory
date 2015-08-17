<?php
		session_start();
		
		require_once('../ClassesController/audit.php');
		
		$audit = new AuditLog();
		
		//$audit->audit_log("Admin ".$_SESSION['userfullname']." Successfully logged out");
		
		unset($_SESSION['userfullname']);
		unset($_SESSION['username']);
		unset($_SESSION['adlogged']);
		unset($_SESSION['levelaccess']);
		unset($_SESSION['location']);
		//unset($_SESSION['image']);
		//unset($_SESSION['staimage']);
		
		header("location:../index.php?r=".base64_encode('logout'));
		
?>
