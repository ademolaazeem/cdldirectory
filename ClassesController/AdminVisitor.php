<?php

		  require_once("DBDirect.php");
		  require_once('audit.php');
		  require_once('Utilities.php');
		  require_once('format.php');
	          require_once('phpmailer/class.phpmailer.php');
		  require_once('phpmailer/class.pop3.php');
		  require_once('phpmailer/class.smtp.php');
  
  class CDLVisitor 
  {
	  private $db, $audit,$util,$fm;
	  
	  function __construct()
	  {
		  $this->db = new DBConnecting();
		  $this->audit = new AuditLog();
		  $this->util = new Utilities();
		  $this->fm = new Format();
	  }

public function signUserOut($id)
{
//  $upquery = "update tbl_cdl_visitors set sign_out='Yes', time_out='".date()."' WHERE id = '$id'";

$query="update tbl_cdl_visitors set sign_out='Yes', time_out= '".date('Y-m-d H:i:s')."' where id =$id";
						  
  $res = mysql_query($query) or die(mysql_error());//or die('na here');
$this->audit->audit_log("Admin ".$_SESSION['username']." signed-Out successful with ID:  ".$id);
  
 return '<font color="#006600" size="-2">Visitor was successfuly signed out! </font>';

  
}//End Function signUserOut
	  
	public function smtpmailer($to, $from, $from_name, $subject, $body) { 
	
		global $error;
		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465; 
		$mail->Username = 'ogunforestryoperations';  
		$mail->Password = 'ogun123;';           
		$mail->SetFrom($from, $from_name);
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AddAddress($to);
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return false;
		} else {
			$error = 'Message sent!';
			return true;
		}	
	}
	
	
function  Visitor_Registration()
 {   
 /*
$fullname = $this->fm->processfield($_POST['fullname']);
 $department = $this->fm->processfield(strtoupper($_POST['department']));
  $extension= $this->fm->processfield(strtoupper($_POST['extension']));
  $mobile = $this->fm->processfield(strtoupper($_POST['mobile']));
    $floor = $this->fm->processfield(strtoupper($_POST['floor']));
    $email = $this->fm->processfield(strtoupper($_POST['email']));
	
	*/
	
	
$visitor_name = mysql_real_escape_string($_POST['visitor_name']);
$address=mysql_real_escape_string(strtoupper($_POST['address']));
$purpose= mysql_real_escape_string(strtoupper($_POST['purpose']));
$whom_to_see = mysql_real_escape_string($_POST['whom_to_see']);
$floor = mysql_real_escape_string($_POST['floor']);
$phone_number = mysql_real_escape_string($_POST['phone_number']);
$sign_in = mysql_real_escape_string($_POST['sign_in']);
$tag_number = mysql_real_escape_string($_POST['tag_number']);
$extension = mysql_real_escape_string($_POST['extension']);
	
  		  if(empty($visitor_name) || $whom_to_see=="0"|| empty($address)|| empty($purpose))
			  //if(empty($_SESSION['name']))
			  
			  {
				  return '<font color="#FF0000" size="-2">Please Provide the visitor name, Staff to see, address and Purpose of Visiting!</font>';
			  }
			   
try 
{
			  
$serial = rand(100,999).substr(str_shuffle("0123456789"),0,1);	
$minshr = "CDL";
$curDate=date('YmdHis');
$userid = $minshr.$curDate.$serial;//generate
$query="INSERT INTO tbl_cdl_visitors 
  		  (visitor_name, address, purpose, whom_to_see, phone_number, sign_in, tag_number, floor,extension,maker)
   VALUES('$visitor_name','$address', '$purpose',$whom_to_see, '$phone_number','$sign_in', '$tag_number', '$floor',$extension, '".$_SESSION['username']."')";
//, '".date('Y-m-d H:i:s')."'
  
  //return $query;
  $result = mysql_query($query) or die(mysql_error());
  if($result)
					  {
  $_SESSION['uid']=$userid;
$this->audit->audit_log($_SESSION['username']."  has successfully added a new visitor - ".$visitor_name);
  
  return '<strong><font color="#3300FF" size="-2">Visitor '.$visitor_name.'</font></strong><font color="#006600" size="-2"> was successfully registered</font>';
					  }
			  
			//	  }
				
				  
				  /*081220122156
				  */
			  }//try
			  catch(Exception $exc)
			  {
				  echo ($exc->getMessage() . "<br>");
			  }
	  
	  }
	  
	  
public function Update_Staff_Directory_By_Admin()
   {
	   
  $id = mysql_real_escape_string($_POST['id']);
  $fullname = mysql_real_escape_string($_POST['fullname']);
  $department = mysql_real_escape_string(strtoupper($_POST['department']));
  $extension= mysql_real_escape_string(strtoupper($_POST['extension']));
  $mobile = mysql_real_escape_string($_POST['mobile']);
  $email = mysql_real_escape_string($_POST['email']);
  $floor = mysql_real_escape_string($_POST['floor']);
  
//  $picture = mysql_real_escape_string($_POST['pp']);
		  
		  if(empty($fullname)||empty($extension))
		  {
			  return '<font color="#FF0000" size="-2">Please make sure fullname and extension fields are Completed!</font>';
		  }
  //update
  $upquery = "UPDATE tbl_directory SET fullname = '$fullname',department ='$department',extension ='$extension',mobile = '$mobile', 	email = '$email',floor = '$floor', modified_date = '".date('Y-m-d H:i:s')."',maker = '".$_SESSION['username']."' WHERE id = '$id'";
 //return $upquery;
$res = mysql_query($upquery) or die(mysql_error());//or die('na here');
					  
  return '<font color="#006600" size="-2">The record is updated!</font>';
			  
	   }//End Update_Admin_Update
  
  
public function Update_Contractor_Account_By_Admin()
   {
	   
  $contractor_id = mysql_real_escape_string($_POST['contractor_id']);
  $current_balance = mysql_real_escape_string($_POST['current_balance']);
  
  $last_amount_deposited = mysql_real_escape_string($_POST['last_amount_deposited']);
 $last_teller_number = mysql_real_escape_string(strtoupper($_POST['last_teller_number']));
  $last_bank_name= mysql_real_escape_string(strtoupper($_POST['last_bank_name']));
  $last_account_number = mysql_real_escape_string($_POST['last_account_number']);
  $last_payment_date = mysql_real_escape_string($_POST['last_payment_date']);
  
  
  
  $h_amount_deposited = mysql_real_escape_string($_POST['h_amount_deposited']);
  $h_teller_number = mysql_real_escape_string(strtoupper($_POST['h_teller_number']));
  $h_bank_name= mysql_real_escape_string(strtoupper($_POST['h_bank_name']));
  $h_account_number = mysql_real_escape_string($_POST['h_account_number']);
  $h_payment_date = mysql_real_escape_string($_POST['h_payment_date']);
  $h_created_date = mysql_real_escape_string($_POST['h_created_date']);
  $h_maker_id = mysql_real_escape_string($_POST['h_maker_id']);
  
  $before_save= $current_balance-$h_amount_deposited;
  $after_save=$before_save+$last_amount_deposited;
  
		  
		  if(empty($last_teller_number)||empty($last_bank_name)||empty($last_account_number))
		  {
			  return '<font color="#FF0000" size="-2">Please make sure Teller Number, Bank Name and Account Number fields are Completed!</font>';
		  }
  //update
  $upquery1 = "UPDATE tbl_contractor_account SET amount_deposited = '$after_save',teller_number ='$last_teller_number',bank_name ='$last_bank_name',account_number = '$last_account_number',	payment_date = '$last_payment_date',created_date = '".date('Y-m-d H:i:s')."',maker_id = '".$_SESSION['username']."' WHERE contractor_id = '$contractor_id'";
				  
				  //return $upquery;
  $res1 = mysql_query($upquery1) or die(mysql_error());//or die('na here');
  
  
  
  $query="INSERT INTO tbl_contractor_account_history 
  (id, amount_deposited, teller_number, bank_name,account_number, created_date, payment_date, maker_id, contractor_id)
  
  VALUES('','$last_amount_deposited','$last_teller_number', '$last_bank_name','$last_account_number', '".date('Y-m-d H:i:s')."', '$last_payment_date', '".$_SESSION['username']."', '$contractor_id')";
  
  
  //return $query;
  $result = mysql_query($query) or die(mysql_error());
  if($result && $res1)
					  {
 // $_SESSION['uid']=$userid;
$this->audit->audit_log("Admin ".$_SESSION['username']." Updated contractor account information of contractor - with Contractor Number:".$contractor_id);

//For Audit
 $query2="INSERT INTO tbl_contractor_account_audit 
  (id, amount_deposited, teller_number, bank_name,account_number, created_date, payment_date, new_amount_deposited, new_teller_number, new_bank_name,new_account_number, new_created_date, new_payment_date, editor_id, maker_id, contractor_id)
  
  VALUES('','$h_amount_deposited','$h_teller_number', '$h_bank_name','$h_account_number', '$h_created_date', '$h_payment_date', '$last_amount_deposited', '$last_teller_number', '$last_bank_name', '$last_account_number', '".date('Y-m-d H:i:s')."', '$last_payment_date', '".$_SESSION['username']."', '$h_maker_id', '$contractor_id')";
  
   $result2 = mysql_query($query2) or die(mysql_error());
  //End for Audit
  
  return '<strong><font color="#3300FF" size="-2">Contractor with Number '.$contractor_id.' account </font></strong><font color="#006600" size="-2"> had an account entry successfully updated. </font>';
					
					
					
					
	//	return '<font color="#006600" size="-2">The record is updated!</font>';			
					
					
					
					  }
					  
					  
					  
					  
					  
					  
  
			  
	   }//End Update_Admin_Update
  
  
	  
	  
	  
	
  
  
 
  function  Contractor_Account()
	  {   
	  
  $amount_deposited = $this->fm->processfield($_POST['amount_deposited']);
  $teller_number = $this->fm->processfield(strtoupper($_POST['teller_number']));
  $bank_name= $this->fm->processfield(strtoupper($_POST['bank_name']));
  $account_number = $this->fm->processfield(strtoupper($_POST['account_number']));
  $day = $this->fm->processfield($_POST['day']);
  $month = $this->fm->processfield($_POST['month']);
  $year = $this->fm->processfield($_POST['year']);
  $payment_date= $year."-".$month."-".$day;
  $contractor_id = $this->fm->processfield($_POST['contractor_id']);
  $payment_date = $this->fm->processfield($_POST['payment_date']);
  
				
  if(empty($amount_deposited)||empty($teller_number)||empty($bank_name)||empty($account_number))
			  //if(empty($_SESSION['name']))
			  
			  {
				  return '<font color="#FF0000" size="-2">Please Provide all Information in the fields! </font>';
			  }
			  
  $new_amount=$amount_deposited+$current_balance;
			   
				  try {
			  //today 081220122156
			  
			  
			  $sql = mysql_query("SELECT * from tbl_contractor_account WHERE teller_number = '$teller_number'") or die(mysql_error());
				  $tell_no_rows = mysql_num_rows($sql);
				  
  if ($tell_no_rows == 0) 
  {
			  
  $sql = mysql_query("SELECT * from tbl_contractor_account WHERE contractor_id = '$contractor_id'") or die(mysql_error());
				  $no_rows = mysql_num_rows($sql);
				  
			  
  if ($no_rows == 0) 
  {
					   
	  //update
  $upquery="INSERT INTO tbl_contractor_account 
  (id, amount_deposited, teller_number, bank_name,account_number, created_date, payment_date, maker_id, contractor_id)
  
  VALUES('','".$_SESSION['new_amount']."','$teller_number', '$bank_name','$account_number', '".date('Y-m-d')."', '".$payment_date."', '".$_SESSION['username']."', '$contractor_id')";
  
				  
				  //return $upquery;
  //$res = mysql_query($upquery) or die(mysql_error());//or die('na here');
					  
  //return '<font color="#006600" size="-2">The record is updated!</font>';
					   
  $query="INSERT INTO tbl_contractor_account_history 
  (id, amount_deposited, teller_number, bank_name,account_number, created_date, payment_date, maker_id, contractor_id)
  
  VALUES('','$amount_deposited','$teller_number', '$bank_name','$account_number', '".date('Y-m-d')."', '".$payment_date."', '".$_SESSION['username']."', '$contractor_id')";
					  
  
  //return $query;
  $res = mysql_query($upquery) or die(mysql_error());
  $result = mysql_query($query) or die(mysql_error());
  if($res && $result)
					  {
  //$_SESSION['uid']=$userid;
  $this->audit->audit_log("Admin ".$_SESSION['username']." added a new contractor account for - ".$contractor_id);
  
  return '<strong><font color="#3300FF" size="-2">The new account for Contractor with Number '.$contractor_id.' Payment Date: '.$payment_date1.' </font></strong><font color="#006600" size="-2"> was successfully Saved.</font>';
					  }
			  
				  }
				  elseif ($no_rows > 0) 
				  {
					  
  $upquery = "UPDATE tbl_contractor_account SET amount_deposited = '".$_SESSION['new_amount']."',teller_number ='$teller_number',bank_name ='$bank_name',account_number = '$account_number',	created_date = '".date('Y-m-d')."',payment_date = '".$payment_date."', maker_id='".$_SESSION['username']."' WHERE contractor_id = '$contractor_id'";
  
  
  
  
  $query="INSERT INTO tbl_contractor_account_history 
  (id, amount_deposited, teller_number, bank_name,account_number, created_date, payment_date, maker_id, contractor_id)
  
  VALUES('','$amount_deposited','$teller_number', '$bank_name','$account_number', '".date('Y-m-d')."', '".$payment_date."', '".$_SESSION['username']."', '$contractor_id')";
					  
  
  //return $query;
  $res = mysql_query($upquery) or die(mysql_error());
  $result = mysql_query($query) or die(mysql_error());
  if($res && $result)
					  {
  //$_SESSION['uid']=$userid;
  $this->audit->audit_log("Admin ".$_SESSION['username']." updated and added a contractor account for - ".$contractor_id);
  
  return '<strong><font color="#3300FF" size="-2">The account for Contractor with Number '.$contractor_id.' </font></strong><font color="#006600" size="-2"> was successfully Saved.</font>';
					  }//end if res and result
					  
				  }//end else if no_rows
 		  
					  
										  
					  
					  
  //return '<font color="#FF0000" size="-2">Contractor information already saved, Register another Contractor</font>';
				  } else
	{
return '<font color="#FF0000" size="-2">Please provide another set of data, you have already saved this information! </font>';
    }//end tell_no_rows
			
				  
				  /*081220122156
				  */
			  }//try
			  catch(Exception $exc)
			  {
				  echo ($exc->getMessage() . "<br>");
			  }
	  
	  }
	  
function  Contractor_Transaction()
	  {   
	  
  $current_balance = $this->fm->processfield($_POST['current_balance']);
  $tree_type = $this->fm->processfield($_POST['tree_type']);
  $quantity = $this->fm->processfield($_POST['quantity']);
  $reserved_location= $this->fm->processfield($_POST['reserved_location']);
  $attended_by = $this->fm->processfield($_POST['attended_by']);
  $day = $this->fm->processfield($_POST['day']);
  $month = $this->fm->processfield($_POST['month']);
  $year = $this->fm->processfield($_POST['year']);
  $payment_date= $year."-".$month."-".$day;
  $contractor_id = $this->fm->processfield($_POST['contractor_id']);
  $date = $this->fm->processfield($_POST['date']);
  
				
  if(empty($tree_type)||empty($quantity)||empty($reserved_location)||empty($date))
//if(empty($_SESSION['name']))
			  
{
	return '<font color="#FF0000" size="-2">Please Provide all Information in the fields! </font>';
}
else
{			  
  //check for account balance as against tree tariff * quantity

	 $sql = mysql_query("SELECT * from tbl_tree WHERE id = $tree_type") or die(mysql_error());
	 $row_list=mysql_fetch_assoc($sql);
	 $tariff =  $row_list['tariff'];
         $tree_name = $row_list['name'];
	 $cuts_per_day = $row_list['allowable_cuts_per_day'];
	 $transaction_cost = $quantity * $tariff;

	
	if($current_balance < $transaction_cost)
	{
		return '<font color="#FF0000" size="-2">The current balance is N'.$current_balance.' while the transaction cost is N'.$transaction_cost.'! </font>';
	}

//check if allowable cuts per day have been exceeded
	 $sql = mysql_query("SELECT * from tbl_contractor_transaction WHERE contractor_id = '$contractor_id' && date = '$date'") or die(mysql_error());
	 $previous_cuts = mysql_num_rows($sql);
	 $cuts_today = $previous_cuts + $quantity;
	//return $cuts_today.$cuts_per_day;
	if($cuts_today > $cuts_per_day)
	{
		return '<font color="#FF0000" size="-2">The contractor has already cut '. $previous_cuts .' of this tree type today.<br /> With '. $quantity .' more cuts, the contractor has exceeded the daily maximum cuts ('. $cuts_per_day.') for trees of type '.$tree_name.'! </font>';
	}
}
   
				  try {
			  
		   
	  //update
  $query="INSERT INTO tbl_contractor_transaction_request
  (tree_type, quantity, transaction_cost,reserved_location,attended_by, date,contractor_id,sender_email) VALUES($tree_type,'$quantity','$transaction_cost', '$reserved_location', '".$_SESSION['username']."', '".$date."','$contractor_id', '".$_SESSION['email']."')";
  
	/*			  
  $query2="INSERT INTO tbl_contractor_transaction_history
  (tree_type, quantity, reserved_location,attended_by, date,contractor_id,sender_email) VALUES($tree_type,'$quantity', '$reserved_location', '".$_SESSION['username']."', '".$date."','$contractor_id', '".$_SESSION['email']."')";

//update contractor account balance
$new_balance = $current_balance - $transaction_cost;
  $query3="UPDATE tbl_contractor_account set amount_deposited = $new_balance where contractor_id='$contractor_id'";	*/  
  
  //return $query;
  $res1 = mysql_query($query) or die(mysql_error());

 // $res2 = mysql_query($query2) or die(mysql_error());


  //$res3 = mysql_query($query3) or die(mysql_error());
  //if($res1 && $res2 && $res3)
  if($res1)
					  {				  	  
						  

//send an email to directors concerning new transaction requests
//transaction requests for Area_J4 are sent to Area_J4 directors only while other requests are sent to all directors except Area_J4 directors
//Area J4 location id = 10  
//get email of directors
$check_query = "SELECT *from tbl_location WHERE  forest_location = '$reserved_location' && id = 10";
$check_result = mysql_query($check_query);
$nos_result_check = mysql_num_rows($check_result);
			
if($nos_result_check > 0)
{ //i.e if this request is for Area_j4
	$list = mysql_query("SELECT * FROM tbl_users WHERE acclevel = 4 && (location IN (SELECT forest_location from tbl_location WHERE id = 10))");			
}
else
{
	$list = mysql_query("SELECT * FROM tbl_users WHERE acclevel = 4 && (location NOT IN (SELECT forest_location from tbl_location WHERE id = 10))");
}			


// Show records by while loop.
while($row_list=mysql_fetch_assoc($list))
{
	$email = $row_list['email'];


	//$to  = "diamonddemola@yahoo.co.uk,"."afolabimic@gmail.com,"."ayo.olubori@gmail.com"; 
	$to  = $email; 
    
    	$subject = "New Transaction Request Sent by: ".$_SESSION['username']; 
     
    
    	$message = '<html> 
	<head> 
	<title>Ogun State Forestry Monitoring and Control System</title> 
	</head> 

	<body style="font-family:verdana, arial; font-size: .8em;"> 
	You\'re receiving this email because you are the one authorized to Approve the contractor Transaction
	<br/><br/> 
	If you are not in authority to approve the transaction, you can simply delete this email. No further action is required.
	<br/><br/> 
	To approve the transaction kindly click on the link below:<br>
	<a title="Confirm Comment"
	href="http://www.ogunforestryoperations.com.ng/fsy/">http://www.ogunforestryoperations.com.ng/fsy/</a> 
	<br/><br/> 
	The transaction has the following information:<br/>

	Tree Type: '.$tree_type.'<br/>
	Quantity: '.$quantity.'<br/>
	Location of the Reserve:'.$reserved_location.'<br />
	Request Sent by: '.$_SESSION['username'].'<br />
	Contractor ID: '.$contractor_id.'<br/>
	New Balance: '.$new_balance.'<br/>
	Transaction Cost: '.$transaction_cost.'<br/>

	Kindly ATTEND to the request as early as possible! Thank you!<br/><br/> 
	<br/>
	Best Regards<br/>
	Forestry Monitoring and Control Team!<br/><br/>

	</body> 
	</html>'; 

	//send email
		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465; 
		$mail->Username = 'ogunforestryoperations';  
		$mail->Password = 'ogun123;';           
		$mail->SetFrom("ogunforestryoperations@gmail.com","Ogun Forestry Monitoring and Control System");
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AddAddress($to);
		
		$mail->MsgHTML($message);
		//$mail->AddAttachment("images/image1.gif");      
		//$mail->AddAttachment("images/image2.gif"); 
		
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return false;
		} else {
			//$error = 'Message sent!';
			//return true;
		}

        //smtpmailer($to, 'ogunforestryoperations@gmail.com', 'Ogun Forestry Monitoring & Control System', $subject, $message);



        /*
	$headers  = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
	     
	   
	$headers .= "From: Ogun State Forestry Monitoring and Control System <no-reply@ogunforestryoperations.com.ng>\r\n"; 
	     
	   
	mail($to, $subject, $message, $headers); 
	*/

	// End while loop for sending emails
	} 	  
		  
		

  //$_SESSION['uid']=$userid;
  $this->audit->audit_log("Admin ".$_SESSION['username']." sent a new transaction request for - ".$contractor_id);
  
  return '<strong><font color="#3300FF" size="-2">The new transaction request for Contractor with Number '.$contractor_id.' Transaction Date: '.$date.' </font></strong><font color="#006600" size="-2"> was successfully Sent.</font>';

					  }
 		  		  
				  /*081220122156
				  */
			  }//try
			  catch(Exception $exc)
			  {
				  echo ($exc->getMessage() . "<br>");
			  }
	  
	  }  //end function contractor transaction

function  Contractor_Transaction_Activate()
	  {   
	  //return "yes";
  $transaction_id = $this->fm->processfield($_POST['transaction_id']);

 //selection transaction details from the database
 $sql = "select * from tbl_contractor_transaction_request where id = '$transaction_id'"; 
 $result = mysql_query($sql);

 $nos_sql_results = mysql_num_rows($result);
 if($nos_sql_results > 0)
 {	
	$rs=mysql_fetch_assoc($result);
	$tree_type = $rs['tree_type'];
	$quantity = $rs['quantity'];
	$transaction_cost = $rs['transaction_cost'];
	$reserved_location = $rs['reserved_location'];
	$attended_by = $rs['attended_by'];
	$authorized_by = $rs['authorized_by'];
	$date = $rs['date'];
	$maker_id = $rs['maker_id'];
        $contractor_id = $rs['contractor_id'];
	$sender_email = $rs['sender_email'];
	$approval_status = $rs['approval_status'];
	$remarks = $rs['remarks'];

	 $check_sql = mysql_query("SELECT * from tbl_tree WHERE id = $tree_type") or die(mysql_error());
	 $row_list=mysql_fetch_assoc($check_sql);
	 $tariff =  $row_list['tariff'];
         $tree_name = $row_list['name'];
	 $cuts_per_day = $row_list['allowable_cuts_per_day'];
	 $transaction_cost = $quantity * $tariff;

	 $check_sql2 = mysql_query("SELECT * from tbl_contractor_account WHERE contractor_id = '$contractor_id'") or die(mysql_error());
	 $row_list2=mysql_fetch_assoc($check_sql2);
         $current_balance = $row_list2['amount_deposited'];

	//check for account balance as against tree tariff * quantity
	if($current_balance < $transaction_cost)
	{
		return '<font color="#FF0000" size="-2">Your current balance is N'.$current_balance.' while the transaction cost is N'.$transaction_cost.'! </font>';
	}

	//check if allowable cuts per day have been exceeded
	 $sql = mysql_query("SELECT * from tbl_contractor_transaction WHERE contractor_id = '$contractor_id' && date = '$date'") or die(mysql_error());
	 $previous_cuts = mysql_num_rows($sql);
	 $cuts_today = $previous_cuts + $quantity;
	//return $cuts_today.$cuts_per_day;
	if($cuts_today > $cuts_per_day)
	{
		return '<font color="#FF0000" size="-2">You have already cut '. $previous_cuts .' of this tree type today.<br /> With '. $quantity .' more cuts, you have exceeded the daily maximum cuts ('. $cuts_per_day.') for trees of type '.$tree_name.'! </font>';
	}

	try {
			  
		   
	  	  //update
		  $query="INSERT INTO tbl_contractor_transaction
		  (id, tree_type, quantity, transaction_cost, reserved_location,attended_by,authorized_by, date, maker_id,contractor_id,sender_email,approval_status,remarks) VALUES($transaction_id,$tree_type,'$quantity','$transaction_cost', '$reserved_location', '$attended_by', '$authorized_by','$date', '$maker_id','$contractor_id','$sender_email','$approval_status','$remarks')";
		  
						  
		  $query2="INSERT INTO tbl_contractor_transaction_history
		  (id, tree_type, quantity,transaction_cost, reserved_location,attended_by,authorized_by, date, maker_id,contractor_id,sender_email,approval_status,remarks) VALUES($transaction_id,$tree_type,'$quantity','$transaction_cost', '$reserved_location', '$attended_by', '$authorized_by','$date', '$maker_id','$contractor_id','$sender_email','$approval_status','$remarks')";

		//update contractor account balance
		$new_balance = $current_balance - $transaction_cost;
		  $query3="UPDATE tbl_contractor_account set amount_deposited = $new_balance where contractor_id='$contractor_id'";	
		  
		  //return $query;
		  $res1 = mysql_query($query) or die(mysql_error());

		  $res2 = mysql_query($query2) or die(mysql_error());


		  $res3 = mysql_query($query3) or die(mysql_error());
		  if($res1 && $res2 && $res3)
		  {				  	  
						  

		  	 //delete from transaction requests
			$del_query = "DELETE FROM tbl_contractor_transaction_request WHERE id = '$transaction_id'";
			$del_result = mysql_query($del_query);
		

			  //$_SESSION['uid']=$userid;
			  $this->audit->audit_log("Admin ".$_SESSION['username']." added a new transaction for - ".$contractor_id);
			  
			  return '<strong><font color="#3300FF" size="-2">The new transaction for Contractor with Number '.$contractor_id.' Transaction Date: '.$date.' </font></strong><font color="#006600" size="-2"> was successfully Saved.</font>';

		  }
 		  		  
	  }//try
	  catch(Exception $exc)
	  {
		  echo ($exc->getMessage() . "<br>");
	  }
 }
 else
 {
	return '<font color="#FF0000" size="-2">Transaction not found! </font>';
 }


}  //end function contractor transaction activate

function  Contractor_Transaction_Status()
	  {   
	  
  $approval_status = $this->fm->processfield($_POST['approval_status']);
  $remarks = $this->fm->processfield($_POST['remarks']);
  $contractor_id = $this->fm->processfield($_POST['contractor_id']);
  $transaction_id = $this->fm->processfield($_POST['transaction_id']);
  
				
  if(empty($approval_status))
{
	return '<font color="#FF0000" size="-2">Please select the STATUS of the transaction! </font>';
}

				  try {
			  
			   
  $query="UPDATE tbl_contractor_transaction_request set approval_status ='$approval_status',remarks='$remarks', authorized_by = '".$_SESSION['username']."' where id='$transaction_id'";	  
  $res = mysql_query($query) or die(mysql_error());

/*
  $query2="UPDATE tbl_contractor_transaction_history set approval_status ='$approval_status',remarks='$remarks', authorized_by = '".$_SESSION['username']."' where id='$transaction_id'";	  
  $res2 = mysql_query($query2) or die(mysql_error());
*/
  if($res)
			  {
//send an email to user who created the new transaction request
  
//get email of user
$list = mysql_query("SELECT * FROM tbl_contractor_transaction_request WHERE id = '$transaction_id'");

// Show records by while loop.
while($row_list=mysql_fetch_assoc($list))
{
	$email = $row_list['sender_email'];


	//$to  = "diamonddemola@yahoo.co.uk,"."afolabimic@gmail.com,"."ayo.olubori@gmail.com"; 
	$to  = $email;
    
    	$subject = "Transaction Request Treated"; 
     
    
    	$message = '<html> 
	<head> 
	<title>Ogun State Forestry Monitoring and Control System</title> 
	</head> 

	<body style="font-family:verdana, arial; font-size: .8em;"> 
	You\'re receiving this email because the transaction request you created has been treated.
	<br/><br/> 
	If you are not in authority to send transaction requests, you can simply delete this email. No further action is required.
	<br/><br/> 
	To view the details of this transaction request kindly click on the link below:<br>
	<a title="Confirm Comment"
	href="http://www.ogunforestryoperations.com.ng/fsy/">http://www.ogunforestryoperations.com.ng/fsy/</a> 
	<br/><br/> 
	The transaction has the following information:<br/>

	Contractor ID: '.$contractor_id.'<br/>
	Approval Status: '.$approval_status.'<br/>
	Remarks: '.$remarks.'<br/>

	<br/>
	Best Regards<br/>
	Forestry Monitoring and Control Team!<br/><br/>

	</body> 
	</html>'; 

	//send email
		$mail = new PHPMailer();  // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true;  // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465; 
		$mail->Username = 'ogunforestryoperations';  
		$mail->Password = 'ogun123;';           
		$mail->SetFrom("ogunforestryoperations@gmail.com","Ogun Forestry Monitoring and Control System");
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AddAddress($to);
		$mail->MsgHTML($message);
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return false;
		} else {
			//$error = 'Message sent!';
			//return true;
		}
       // smtpmailer($to, 'ogunforestryoperations@gmail.com', 'Ogun Forestry Monitoring & Control System', $subject, $message);

/* 
	$headers  = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
	     
	   
	$headers .= "From: Ogun State Forestry Monitoring and Control System <no-reply@ogunforestryoperations.com.ng>\r\n"; 
	     
	   
	mail($to, $subject, $message, $headers); 
*/

	// End while loop for sending emails
	}

  //$_SESSION['uid']=$userid;
  $this->audit->audit_log("Admin ".$_SESSION['username']." updated the transaction request status for Contractor - ".$contractor_id);
  
  return '<strong><font color="#3300FF" size="-2">The transactions status for the Contractor with Number '.$contractor_id.' </font></strong><font color="#006600" size="-2"> was successfully Updated.</font>';
					  }
 		  		  
				  /*081220122156
				  */
			  }//try
			  catch(Exception $exc)
			  {
				  echo ($exc->getMessage() . "<br>");
			  }
	  
	  }  //end function contractor transaction status	  


function  User_Account_Registration()
	  {   
	  
  $title = $this->fm->processfield($_POST['title']);
  $fname = $this->fm->processfield($_POST['fname']);
  $mname= $this->fm->processfield($_POST['mname']);
  $lname = $this->fm->processfield($_POST['lname']);
  $sex = $_POST['sex'];
  $dob = $_POST['dob'];
  $location = $_POST['location'];
  $username = $this->fm->processfield($_POST['user']);
  $password =$_POST['password'];
  $re_password = $_POST['re_password'];
  $dep = $this->fm->processfield($_POST['dep']);
  $rank =$_POST['rank'];
  $qua = $_POST['qua'];
  $acclevel = $this->fm->processfield($_POST['acclevel']);
  $email = $this->fm->processfield($_POST['email']);
  $address = $this->fm->processfield($_POST['address']);
  $phone = $this->fm->processfield($_POST['phone']);
			
 $username_sql = mysql_query("SELECT * from tbl_users WHERE username = '$username'") or die(mysql_error());
 $nos_username = mysql_num_rows($username_sql);

 $email_sql = mysql_query("SELECT * from tbl_users WHERE email = '$email'") or die(mysql_error());
 $nos_email = mysql_num_rows($email_sql);
	
 if(empty($title)||empty($fname)||empty($mname)||empty($lname)||empty($sex)||empty($dob)||empty($location)||empty($username)||empty($password)||empty($re_password)||empty($dep)||empty($rank)||empty($qua)||empty($acclevel)||empty($email)||empty($address)||empty($phone))
			  {
				  return '<font color="#FF0000" size="-2">All fields are required!</font>';
			  }
			  elseif($password != $re_password)
			  {
                                 return '<font color="#FF0000" size="-2">The entered passwords do not match!</font>';
			  }
			  elseif($nos_username > 0)
			  {
                                 return '<font color="#FF0000" size="-2">The entered username is already in use!</font>';
			  }
			  elseif($nos_email > 0)
			  {
                                 return '<font color="#FF0000" size="-2">The entered email is already in use!</font>';
			  }
			  else
			  { 
			   
				  try {
			    
		  
		  
		  
		  
		  
				  
  $query="INSERT INTO tbl_users 
  (title,fname, mname,lname,sex, dob, location, username, password, dep, rank, qua, acclevel, email, address, phone,datereg)
  
  VALUES('$title','$fname','$mname','$lname', '$sex','$dob','$location', '$username', '".sha1($password)."', '$dep','$rank', '$qua', '$acclevel', '$email', '$address', '$phone','".date('Y-m-d')."')";
					  
  
  //return $query;
  $result = mysql_query($query) or die(mysql_error());
  if($result)
  {
  //$_SESSION['uid']=$userid;
				
  
  return '<strong><font color="#3300FF" size="-2">User account with username: '.$username.' </font></strong><font color="#006600" size="-2"> was successfully registered <em>To upload user picture and to print, go to Administer User Section</em></font>';
}
			  
			  }//try
			  catch(Exception $exc)
			  {
				  echo ($exc->getMessage() . "<br>");
			  }
	  
	} //end else that inserts db record
} //end function account registration

public function Update_User_Account_By_Admin()
   {
	   
  $title = $this->fm->processfield($_POST['title']);
  $fname = $this->fm->processfield($_POST['fname']);
  $mname= $this->fm->processfield($_POST['mname']);
  $lname = $this->fm->processfield($_POST['lname']);
  $sex = $_POST['sex'];
  $dob = $_POST['dob'];
  $location = $_POST['location'];
  $username = $this->fm->processfield($_POST['username']);
  $new_password =$_POST['new_password'];
  $re_new_password = $_POST['re_new_password'];
  $dep = $this->fm->processfield($_POST['dep']);
  $rank =$_POST['rank'];
  $qua = $_POST['qua'];
  $acclevel = $this->fm->processfield($_POST['acclevel']);
  $email = $this->fm->processfield($_POST['email']);
  $address = $this->fm->processfield($_POST['address']);
  $phone = $this->fm->processfield($_POST['phone']);
		
  $db = new DBConnecting();
  $qry = "SELECT * FROM tbl_users WHERE username = '$username'";
  $rs = $db->fetchData($qry);
  
  $old_password = $rs['password'];
  
 
  
  $selemail = "SELECT * FROM tbl_users WHERE username <> '$username' && email = '$email'";
  $selqry12= mysql_query($selemail);
  $chosen_email_exists = mysql_num_rows($selqry12);
			
			//$anotheremail = $result['email'];//for update
			
			
  //we need to check if the access level has changed so that all permissions can be deleted
  $sel_access = "SELECT * FROM tbl_users WHERE username = '$username'";
  $rs_access = $db->fetchData($sel_access);
  $old_access = $rs_access['acclevel'];
  
 
if(empty($new_password) && empty($re_new_password))  //password _not to_be changed
{
	 if(empty($title)||empty($fname)||empty($mname)||empty($lname)||empty($sex)||empty($dob)||empty($username)||empty($dep)||empty($rank)||empty($qua)||empty($acclevel)||empty($email)||empty($address)||empty($phone))
	{
		return '<font color="#FF0000" size="-2">All fields are required except LOCATION and the PASSWORD fields which you fill only if you intend to change the password.</font>';
	}	
	elseif($chosen_email_exists)
	{
       return '<font color="#FF0000" size="-2">Duplicate email. This email address has been taken by another user!</font>';
	}
	else
	{
		  //update
		  $upquery = "UPDATE tbl_users SET title = '$title',fname = '$fname',mname ='$mname',lname ='$lname',sex = '$sex',dob  = '$dob',location = '$location',password = '".sha1($new_password)."',dep = '$dep',rank = '$rank',qua='$qua', acclevel = '$acclevel',email = '$email',address='$address',phone='$phone' WHERE username = '$username'";
						  
						  //return $upquery;
		  $res = mysql_query($upquery) or die(mysql_error());//or die('na here');

		if($old_access != $acclevel) //reset permissions if the access level is changed
	  	{
		$delquery = mysql_query("DELETE FROM tbl_user_permission WHERE username = '$username'");}
							  
		  return '<font color="#006600" size="-2">The record was updated successfully!</font>';
	}
}
else
{
	 if(empty($title)||empty($fname)||empty($mname)||empty($lname)||empty($sex)||empty($dob)||empty($username)||empty($new_password)||empty($re_new_password)||empty($dep)||empty($rank)||empty($qua)||empty($acclevel)||empty($email)||empty($address)||empty($phone))
	{
		return '<font color="#FF0000" size="-2">All fields are required except LOCATION and the PASSWORD fields which you fill only if you intend to change the password.</font>';
	}
	elseif(($new_password != $re_new_password))
	{
	       return '<font color="#FF0000" size="-2">The new passwords entered dont match!</font>';
	}  
	elseif($chosen_email_exists)
	{
	       return '<font color="#FF0000" size="-2">Duplicate email. This email address has been taken by another user!</font>';
	} 
	else
	{
	  //update
	  $upquery = "UPDATE tbl_users SET title = '$title',fname = '$fname',mname ='$mname',lname ='$lname',sex = '$sex',dob  = '$dob',location = '$location',password = '".sha1($new_password)."',dep = '$dep',rank = '$rank',qua='$qua', acclevel = '$acclevel',email = '$email',address='$address',phone='$phone' WHERE username = '$username'";
					  
					  //return $upquery;
	  $res = mysql_query($upquery) or die(mysql_error());//or die('na here');
						  
	  //delete all access permissions if the role has changed

	  if($old_access != $acclevel)
	  {
		$delquery = mysql_query("DELETE FROM tbl_user_permission WHERE username = '$username'");}

	  return '<font color="#006600" size="-2">The record was updated successfully!</font>';
		
	}
}  
	   }//End Function update user account by admin


public function Update_User_Password()
{
	   
  $username = $this->fm->processfield($_POST['username']);
  $password =$_POST['password'];
  $new_password =$_POST['new_password'];
  $re_new_password = $_POST['re_new_password'];
		
  $db = new DBConnecting();
  $qry = "SELECT * FROM tbl_users WHERE username = '$username'";
  $rs = $db->fetchData($qry);
  
  $old_password = $rs['password'];

 if(empty($username)||empty($password)||empty($new_password)||empty($re_new_password))
{
	return '<font color="#FF0000" size="-2">All fields are required!</font>';
}
elseif(sha1($password) != $old_password)
{
       return '<font color="#FF0000" size="-2">The current password entered is incorrect!</font>';
} 
elseif($new_password != $re_new_password)
{
       return '<font color="#FF0000" size="-2">The new passwords entered dont match!</font>';
}  
else
{
  //update
  $upquery = "UPDATE tbl_users SET password = '".sha1($new_password)."' WHERE username = '$username'";
				  
				  //return $upquery;
  $res = mysql_query($upquery) or die(mysql_error());//or die('na here');
					  
  return '<font color="#006600" size="-2">The password was updated successfully!</font>';
		
}
	  
	   }//End Function update user account by admin
	  
  
  
function  User_Permission_Addition()
{   
	  
	$user = $this->fm->processfield($_POST['user']);
  	$permission = $_POST['permissions'];
	
	$nos_selected = count($permission);	
	if($nos_selected <= 0)
	{return '<font color="#FF0000" size="-2">You selected no permissions!</font>';}

	for($i=0; $i < $nos_selected; $i++)
	{
	
 	$check_sql = mysql_query("SELECT * from tbl_user_permission WHERE username = '$user' && permission_id = '".$permission[$i]."'") or die(mysql_error());
 	$nos_results = mysql_num_rows($check_sql);

	if($nos_results > 0)
	{//do nothing 
		return 'yes';
	}
	else
	{//insert the new permission

	 
		try 
		{
				    				  
			  $query="INSERT INTO tbl_user_permission
			  (username,permission_id)

			  
			  VALUES('$user','".$permission[$i]."')";
								  
			  
			  //return $query;
			  $result = mysql_query($query) or die(mysql_error());

		 }//try
		 catch(Exception $exc)
	 	{
			echo ($exc->getMessage() . "<br>");
		}
	}
	}//end for loop that inserts permissions
	return '<strong><font color="#3300FF" size="-2">The user permissions</font></strong><font color="#006600" size="-2"> were successfully saved.</font>';
} //end function user_permission_add
  
function  User_Permission_Delete()
{   
	  
	$user = $this->fm->processfield($_POST['user']);
  	$permission = $this->fm->processfield($_POST['permission']);
			
 	try 
	{
			    				  
		$delete_sql = mysql_query("DELETE from tbl_user_permission WHERE username = '$user' && permission_id = '$permission'") or die(mysql_error());
 	
		  if($delete_sql)
		  {
		  //$_SESSION['uid']=$userid;
				
		   return '<strong><font color="#3300FF" size="-2">The user permission</font></strong><font color="#006600" size="-2"> was deleted successfully!</font>';
		}
	 }//try
	 catch(Exception $exc)
 	{
		echo ($exc->getMessage() . "<br>");
	}
	 
} //end function user_permission_delete  
  
  
  
  }
  
  
  //Start Account
  
  ?>
