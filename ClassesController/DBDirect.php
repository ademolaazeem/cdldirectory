<?php	
	session_start();
class DBConnecting 
{

	private $db;
	private $conn;
	
    function  __construct() 
	{	
		//establishing connection in the construction
		//database info, or u can ur db conn file
		$hostname_login = "localhost"; //host
		$database_login = "cdl_directory"; 
		$username_login = "cdl_dir_user";
		$password_login = "cdl_dir_password"; 
		
		$this->conn = mysql_connect($hostname_login, $username_login, $password_login) or trigger_error(mysql_error(),E_USER_ERROR);
		$this->db = mysql_select_db($database_login, $this->conn);
		
		
    }
	
	function getConnection()
	{
		return $this->conn;
	}
	
	public function executeQuery($qry)
	{
		$res=mysql_query($qry) or die(mysql_error());
		return $res;
	}
		
	public function fetchData($qry)
	{
		$res=mysql_query($qry) or die(mysql_error());
		$rs=mysql_fetch_assoc($res);
		return $rs;
	}
		
	function getNumOfRows($qry)
	{
		$res=mysql_query($qry) or die(mysql_error());
		$num=mysql_num_rows($res);
		return $num;
	}
	
	function checkIfExists($table,$field,$value)
	{
		$res = mysql_query("SELECT * FROM $table WHERE $field = '$value'") or die(mysql_error());
		if(mysql_num_rows($res)>0)
			return true;
		else
			return false;	
	}

}//end class DBConnecting

?>