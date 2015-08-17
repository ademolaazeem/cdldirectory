<?php
//*****************************************
//* Secure Class for the Crestview PAS
//* Coded by: Oluwatosin M. Adesanya
//* Date: 23rd July, 2009.
//**************************************
class Secure
{
	public function Secure()
	{
	}
	
	function encrypt($pwd)
	{
		$enc=md5($pwd);
		$len=strlen($enc);
		$mid=ceil($len/2);
		$substr1=substr($enc,0,$mid);
		$substr2=substr($enc,$mid,$len-1);
		$rev1=strrev($substr1);
		$rev2=strrev($substr2);
		return $rev1.$rev2;
	}
	
	function scramble($val)
	{
		return ($val*8567809);
	}
		
	function unscramble($val)
	{
		return $val/8567809;
	}
	
	function scramble2($val)
	{
		return ($val*11);
	}
		
	function unscramble2($val)
	{
		return $val/11;
	}
}

class UniqueCode
{
	var $tablename; var $fieldname;
	
	public function __construct($tablename,$fieldname)
	{
		$this->tablename=$tablename;
		$this->fieldname=$fieldname;
	}
	
	public function isCodeUnique($code)
	{
		$db=new DBConn();
		$tablename=$this->tablename;
		$fieldname=$this->fieldname;
		$qr=sprintf("select %s from %s where %s ='%s'",$fieldname, $tablename, $fieldname, $code);
		if($db->getNumOfRows($qr) > 0)
			return false;
		else
			return true;		
	}
	
	public function getCode()  //this is a recursive function to generate unique code
	{
		//generate Unique Code		
		//create the 8-digit random number
		mt_srand((double)microtime()*1000000);
		$eightdigit=mt_rand(1000,9999).mt_rand(1000,9999);
		//create the 2-letters
		$alpha=substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"),0,2);
		//make the code with the 8-digit and 2-letters		
		$code=$eightdigit.$alpha;
		
		if($this->isCodeUnique($code))
			return $code;
		else
			$this->getCode();
	}

}

?>
