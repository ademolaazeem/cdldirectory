<?php
		require_once("DBDirect.php");
		require_once('audit.php');
		require_once('format.php');
		require_once('Utilities.php');
		
class MessageController
{
	private $db, $audit,$fm,$util;
	
	function __construct()
	{
		$this->db = new DBConnecting();
		$this->audit = new AuditLog();
		$this->fm = new Format();
		$this->util = new Utilities();
	}
	
	//send messages
	public function sendMessage()
	{
		$receiver = $this->fm->processfield($_POST['recipient']);
		$title = $this->fm->processfield($_POST['title']);
		//$msg = $this->fm->processfield($_POST['editor1']);
		$msg = $_POST['editor1'];
		$sendAll = $this->fm->processfield($_POST['checkall']);
		
		if(empty($receiver) && $sendAll!=1)
		{
			return '<font color="#FF0000" size="-2">Select the recipient</font>';
		}
		
		if(!empty($receiver) && $sendAll!=1)
		{
			if(empty($title))
			{
				return '<font color="#FF0000" size="-2">Please enter the message title</font>';
			}
			if(empty($msg))
			{
				return '<font color="#FF0000" size="-2">Please enter the message</font>';
			}
			//1 recipient
			$result = $this->sendSingle($receiver,$title,$msg);
			return $result;
		}
		if(empty($receiver)&&$sendAll==1)
		{
			if(empty($title))
			{
				return '<font color="#FF0000" size="-2">Please enter the message title</font>';
			}
			if(empty($msg))
			{
				return '<font color="#FF0000" size="-2">Please enter the message</font>';
			}
			//all staff
			$result = $this->sendToAll($title,$msg);
			return $result;
		}
		if(!empty($receiver) && $sendAll==1)
		{
			return '<font color="#FF0000" size="-2">Select either the single recipient or Send to all staff and not both</font>';
		}
	}
	
	public function sendSingle($recipient,$title,$body)
	{
		$qry="INSERT INTO tbl_messages(message_id,receiver,sender,name,subject,body,date_sent,readsa) 
		VALUE('','$recipient','".$_SESSION['username']."','".$this->util->getStaffName($_SESSION['username'])."','$title','$body','".time()."','0')";
		
		if($this->db->executeQuery($qry))
		{
			return '<font color="#006600" size="1">Your message was sent to <strong>'.$this->util->getStaffName($recipient).'</strong></font>';
		}
		else return '<font color="#FF0000" size="-2">An unknown error occured, please resend your message</font>';
		
	}
	
	public function sendToAll($title,$body)
	{
		
	}

} 

?>