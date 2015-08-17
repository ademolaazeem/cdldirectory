<?php
		require_once("DBDirect.php");
		require_once('audit.php');
		require_once('format.php');
		
class AdminController
{
	private $db, $audit,$fm;
	
	function __construct()
	{
		$this->db = new DBConnecting();
		$this->audit = new AuditLog();
		$this->fm = new Format();
	}
	
	public function adminLogin()
	{
		$uname = $this->fm->processfield($_POST['uname']);
		$password = $this->fm->processfield($_POST['pword']);
		
		if(empty($uname) || empty($password))
		{
			
			header("location:index.php?r=".base64_encode("empty"));
		}
		
		else
		{
			//CHECK IF DETAILS FOUND IN DB
//$qry = "SELECT a.*, b.group_name group_name, b.username FROM tbl_users a, tbl_group_permission WHERE a.username = '$uname' AND a.password = '".sha1($password)."' and a.username=b.username" ;

$qry = "SELECT * FROM tbl_users WHERE username = '$uname' AND password = '".sha1($password)."'" ;			
			$res = $this->db->getNumOfRows($qry);
			$fct = $this->db->fetchData($qry);
			
			if($res > 0)
			{
	//found grant access
	//create session here
	//$_SESSION['username'] = $uname;
	//$_SESSION['group_name']=$fct['group_name'];
	$_SESSION['username'] = $uname;
	$_SESSION['adlogged'] = "true";
	$_SESSION['userfullname'] = $fct['lname']." ".$fct['fname'];
	$_SESSION['levelaccess'] = $fct['acclevel'];
	$_SESSION['location'] = $fct['location'];
	$_SESSION['email'] = $fct['email'];
				
				$this->audit->audit_log("Admin ".$_SESSION['username']." Successfully logged in");
				header("location:dashboard.php");
			}
			else
			{
				//deny access error in login details
				
				header("location:index.php?r=".base64_encode('failed')); 
			}
		}
	}
	
	public function companyStaffLogin()
	{
		$uname = $this->fm->processfield($_POST['uname']);
		$password = $this->fm->processfield($_POST['passw']);
		
		if(empty($uname) || empty($password))
		{
			//return "<div class='errortitle'>Please enter your valid login details!</div>";
			header("location:new_index.php?r=".base64_encode("empty"));
		}
		
		else
		{
			//CHECK IF DETAILS FOUND IN DB
			$qry = "SELECT * FROM tblcompanystaff WHERE email = '$uname' AND password = '".sha1($password)."'";
			
			$res = $this->db->getNumOfRows($qry);
			$fct = $this->db->fetchData($qry);
			
			if($res > 0)
			{
				//found grant access
				//create session here
				$_SESSION['username'] = $uname;
				$_SESSION['adlogged'] = "true";
				$_SESSION['userfullname'] = $fct['lname']." ".$fct['fname'];
				$_SESSION['levelaccess'] = 1 ;
				
				$this->audit->audit_log("Admin ".$_SESSION['username']." Successfully logged in");
				header("location:console_home.php");
			}
			else
			{
				//deny access error in login details
				
				header("location:new_index.php?r=".base64_encode('failed')); 
			}
		}
	}


	public function regStaff()
	{
		$username = $this->fm->processfield($_POST['uname']);
		$pword = "verde";
		$lname = $this->fm->processfield(strtoupper($_POST['lname']));
		$fname = $this->fm->processfield(strtoupper($_POST['fname']));
		$mname = $this->fm->processfield(strtoupper($_POST['mname']));
		$dob = $this->fm->processfield($_POST['dob']);
		$sex = $this->fm->processfield($_POST['sex']);
		$depart = $this->fm->processfield($_POST['dep']);
		$rank = $this->fm->processfield($_POST['rank']);
		$grade = $this->fm->processfield($_POST['grade']);
		$email = $this->fm->processfield($_POST['email']);
		$phone = $this->fm->processfield($_POST['phone']);
		$address = $this->fm->processfield($_POST['address']);
		$qualif = $this->fm->processfield($_POST['qua']);
		$access = $this->fm->processfield($_POST['access']);
		$title= $this->fm->processfield($_POST['title']);
		
		//validate
		if(empty($username)||empty($lname)||empty($fname))
		{
			return '<font color="#FF0000" size="-2">Please make sure all fields are filled!</font>';
		}
		
		//if(!empty($pword) && strcmp($pword, $cpword) !=0 )
		//{
			//return '<font color="#FF0000" size="-2">Password mismatch</font>';
		//}
		
		//check if the username has not beeen registered before
		
		$qry = "SELECT * FROM tblstaff WHERE staff_id = '$username'";
		
		$row = $this->db->getNumOfRows($qry);
		if($row >0 )
		{
			//username in use
			return '<font color="#FF0000" size="-2">Username already in use, Try another username</font>';
		}
		else
		{
			//upload passport call a method that does that and return the path
			$imagepath = "";
			
			//prepare to insert
			$insertQry = "INSERT INTO tblstaff (id,staff_id,title,fname,mname,lname,password,sex,dob,dep,rank,gralevel,qua,acclevel,email,address,imagepath,phone,datereg) 
			VALUES('','$username','$title','$fname','$mname','$lname','".sha1($pword)."', '$sex','$dob','$depart','$rank','$grade',
			'$qualif','$access','$email','$address','$imagepath','$phone','".time()."')";
			
			$res = $this->db->executeQuery($insertQry);
			
			if($res)
			{
				$this->audit->audit_log("Admin ".$_SESSION['username']." added a new staff - ".$username);
				return '<font color="#006600" size="-2">You have successfully register a staff!</font>';
			}
		}
		
	}//end reg staff
	
	
	
// method to update staff
 public function Update_Staff_By_Admin()
 {
		$user = $_POST['user'];   
	    $username = $_POST['username'];
		$title = $_POST['title'];
		$lname = $this->fm->processfield(strtoupper($_POST['lname']));
		$fname = $this->fm->processfield(strtoupper($_POST['fname']));
		$mname = $this->fm->processfield(strtoupper($_POST['mname']));
		$dob= $this->fm->processfield($_POST['dob']);
		$depart = $_POST['dep'];
		$sex = $_POST['sex'];
		$email = $this->fm->processfield($_POST['email']);
		$rank = $_POST['rank'];
		$grade =$_POST['grade'];
		$qua = $_POST['qua'];
		$homeadd= $this->fm->processfield($_POST['address']);
		$access = $_POST['access'];
		$phone = $_POST['phone'];
		$imagepath = $_POST['photo'];
		
		
		if(empty($lname)||empty($fname)||empty($rank)||empty($phone))
		{
			return '<font color="#FF0000" size="-2">Please make sure all fields are filled!</font>';
		}
		
			//update
				$upquery = "UPDATE tblstaff SET fname = '$fname',mname ='$mname',lname ='$lname',sex = '$sex',	dob = '$dob',dep = '$depart',email = '$email',rank = '$rank',gralevel='$grade', qua = '$qua',acclevel = '$access', imagepath = '$imagepath' ,address = '$homeadd',phone = '$phone' WHERE staff_id = '$user'";
				
				//return $upquery;
				$res = mysql_query($upquery) or die(mysql_error());//or die('na here');
					
				 return '<font color="#006600" size="-2">The record is updated!</font>';
			
	 }


public function Update_Staff()
{
		$user = $_POST['user'];   
		$lname = $this->fm->processfield(strtoupper($_POST['lname']));
		$fname = $this->fm->processfield(strtoupper($_POST['fname']));
		$mname = $this->fm->processfield(strtoupper($_POST['mname']));
		$depart = $_POST['dep'];
		$sex = $_POST['gender'];
		$dob = $_POST['dob'];
		$email = $_POST['email'];
		$homeadd= $_POST['ha'];
		$phone = $_POST['phone'];
		
		
		if(empty($lname)||empty($fname))
		{
			return '<font color="#FF0000" size="-2">Please make sure all fields are filled!</font>';
		}
		
			//update
				$upquery = "UPDATE tblstaff SET fname = '$fname',mname ='$mname',lname ='$lname',sex = '$sex',	dob = '$dob',dep = '$depart',email = '$email',	address = '$homeadd',phone = '$phone' WHERE staff_id = '$user'";
				
				
				//return $upquery;
				$res = mysql_query($upquery) or die(mysql_error());//or die('na here');
					
				 return '<font color="#009900" size="-2">The record is updated!</font>';
			
	 }


function Change_Password()
{

	$staff_id = $this->fm->processfield($_POST['user']);
	 $old = $this->fm->processfield($_POST['oldpass']);
  	 $new= $this->fm->processfield($_POST['newpass']);
     $confirm = $this->fm->processfield($_POST['cpass']);

        if(empty($old)||empty($new)||empty($confirm)||empty($staff_id))
		{
			return '<font color="#FF0000" size="-2">Please make sure all fields are filled!</font>';
		}
		
		if(!empty($old) && strcmp($new, $confirm) !=0 )
		{
			return '<font color="#FF0000" size="-2">Password mismatch</font>';
		}
		
		$qry = "SELECT * FROM tblstaff WHERE staff_id='$staff_id' and password = '".sha1($old)."'";
		
		//return $qry;
		
		$row = $this->db->getNumOfRows($qry);
		if($row == 0 )
		{
			//username in use
			return '<font color="#FF0000" size="-2">The Old password is incorrect or does not exist</font>';
		}
		else
		{
		
		$upquery = "UPDATE tblstaff SET password = '".sha1($new)."' WHERE staff_id = '$staff_id'";
		//return $upquery;
		$res = mysql_query($upquery) or die(mysql_error());//or die('na here');
					
		return '<font color="#009900" size="-2">Password Changed!</font>';
		}
}//end change password

function Reset_Password()
{
	// $staff_id = $_POST['staffid'];
	 $user = $_POST['username'];
  	 
        if(empty($user))
		{
			return '<font color="#FF0000" size="-2">Please, Enter the username in the box!</font>';
		}
		
				
		$qry = "SELECT * FROM tblstaff WHERE staff_id='$user'";
		
		//return $qry;
		
		$row = $this->db->getNumOfRows($qry);
		if($row == 0 )
		{
			//username in use
			return '<font color="#FF0000" size="-2">The Username does not exist</font>';
		}
		else
		{
		 $new = "verde";
		$upquery = "UPDATE tblstaff SET password = '".sha1($new)."' WHERE staff_id = '$user'";
		//return $upquery;
		$res = mysql_query($upquery) or die(mysql_error());//or die('na here');
					
		return '<font color="#FF0000" size="-2">Password Reset!</font>';
		}
}


	public function Add_news()
	{
		$title = $_POST['title'];
		$body = $_POST['editor1'];
		$date =  date("l, F d, Y h:i" ,time());

		
		//validate
		if(empty($title)||empty($body)||empty($date))
		{
			return '<font color="#FF0000" size="-2">Please make sure all fields are filled!</font>';
		}
		
		
		
			$insertQry = "INSERT INTO tblnews (title,body,date) 
			VALUES('$title','$body','$date')";
			
			$res = $this->db->executeQuery($insertQry);
			
				return '<font color="#006600" size="-2">The news was successfull added in the viewing area.</font>';
			
		
		
	}//end add news

function Edit_News()
{       $id = $_GET['id'];
        $title = $_POST['title'];
		$body = $_POST['body'];
		$date =  date("l, F d, Y h:i" ,time());

		
		//validate
		if(empty($title)||empty($body)||empty($date)||empty($id))
		{
			return '<font color="#FF0000" size="-2">Please make sure all fields are filled!</font>';
		}
		
		$updateQry = "UPDATE tblnews SET  title='$title',body='$body',date='$date' WHERE id = '$id'";
			
			$res = $this->db->executeQuery($updateQry);
			
				return '<font color="#006600" size="-2">The news was successfull updated in the viewing area.</font>';

		
}	

function  Remove_Contractor()
{
       $remove = $_GET['consid'];
	   
	   $query = "select * from tbl_contractor where id = '$remove'";
	   
	   echo $remove;
	   $result = mysql_query($query);
	   $result1 = mysql_fetch_array($result);
	  
	   
	   $fname= $result1['contractor_id'];
	   $mname= $result1['name'];
	   $lname= $result1['tin'];
		
	    $query1 = "delete from tbl_contractor where id ='$remove'"; 
		$res = mysql_query($query1);    
		
			
	    return '<font color="#FF0000" size="-1"> ' .$fname."  ".$mname."  ".$lname. '  was successfull deleted from the Consultant record </font>';
			
}

public function companyStaffReg()
	{
		
		$pword = $this->fm->processfield($_POST['password']);
		$cpword = $this->fm->processfield($_POST['cpassword']);
		$lname = $this->fm->processfield(strtoupper($_POST['lname']));
		$fname = $this->fm->processfield(strtoupper($_POST['fname']));
		$mname = $this->fm->processfield(strtoupper($_POST['mname']));
		$phone = $this->fm->processfield($_POST['phone']);
		$desig = $this->fm->processfield($_POST['desig']);
		$email = $this->fm->processfield($_POST['email']);
		
		//validate
		if(empty($desig)||empty($lname)||empty($fname)||empty($pword)||empty($phone)||empty($email))
		{
			return '<font color="#FF0000" size="-2">Please make sure all fields are filled!</font>';
		}
		
		if(!empty($pword) && strcmp($pword, $cpword) !=0 )
		{
			return '<font color="#FF0000" size="-2">Password mismatch</font>';
		}
		
		//check if the username has not beeen registered before
		
		$qry = "SELECT * FROM tblcompanystaff WHERE email = '$email'";
		
		$row = $this->db->getNumOfRows($qry);
		if($row >0 )
		{
			//username in use
			return '<font color="#FF0000" size="-2">Username already in use, Try another username</font>';
		}
		else
		{
			//upload passport call a method that does that and return the path
			$imagepath = "";
			
			//prepare to insert
			$insertQry = "INSERT INTO tblcompanystaff (id,email,fname,mname,lname,password,phone,designation,dateadded) 
			VALUES('','$email','$fname','$mname','$lname','".sha1($pword)."','$phone','$desig','".time()."')";
			
			$res = $this->db->executeQuery($insertQry);
			
			if($res)
			{
				$this->audit->audit_log("Admin ".$_SESSION['username']." added a new staff - ".$username);
				return '<font color="#ff0000" size="1">You have successfully register '.$fname." ".$mname." ".$lname.' as staff for Verde Infotech.</font>';
			}
		}
		
	}//end reg staff
	
	public function add_session()
	{
		$sees = $_POST['session'];
		$term = $_POST['term'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		
		if(empty($sees) || empty($term))
		{
			return '<font color="#FF0000" size="-2">Fill all the fields</font>';
		}
		//prepare to insert
			$insertQry = "INSERT INTO tblsession (id,sessionstatus,session,term,startdate,enddate) 
			VALUES('','1','$sees','$term','$start','$end')";
			
			$res = $this->db->executeQuery($insertQry);
			
			if($res)
			{
				$this->audit->audit_log("Admin ".$_SESSION['username']." set the session ");
				return '<font color="#006600" size="1">Session set successfully</font>';
			}
	}

} 

?>
