<?php
	require_once('DBDirect.php');

//class definitions
class AuditLog
{

	private $db;
	function __construct()
	{
		$this->db = new DBConnecting();
	}

	function audit_log($operation)
	{
		//".time()."
		$cmpname = php_uname('n');
		$adminid = $_SESSION['userfullname']; 
		$ip = $this ->getRealIpAddr();
		$host = $_SERVER['HTTP_HOST'];
		$referer = $_SERVER['HTTP_REFERER'];
		$sql = "INSERT INTO tbl_audit_log (comp_name, user_id, datelog, ip_addr, operation, host, referer) VALUES ('$cmpname', '$adminid','".date('Y-m-d H:i:s')."', '$ip', '$operation', '$host', '$referer')"; 
		$query = mysql_query($sql) or die(mysql_error());
	}
	
	function getRealIpAddr()
	{
		   if (!empty($_SERVER['HTTP_CLIENT_IP'])) //check ip from share internet
		   {  
				$ip = $_SERVER['HTTP_CLIENT_IP']; 
		  }  
		  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
		  //to check ip is pass from proxy 
		  {  
		  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
		  } 
		  else
		  {
		  $ip = $_SERVER['REMOTE_ADDR'];
		  }
		  return $ip;
	   }
}
?>