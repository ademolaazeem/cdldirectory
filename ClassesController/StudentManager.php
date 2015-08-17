<?php
		require_once("DBDirect.php");
		require_once('audit.php');
		require_once('format.php');
		
class StudentController
{
	private $db, $audit,$fm;
	
	function __construct()
	{
		$this->db = new DBConnecting();
		$this->audit = new AuditLog();
		$this->fm = new Format();
	}
	
	public function studLogin()
	{
		$uname = $this->fm->processfield($_POST['uname']);
		$password = $this->fm->processfield($_POST['pword']);
		
		if(empty($uname) || empty($password))
		{
			//return "<div class='errortitle'>Please enter your valid login details!</div>";
			header("location:index.php?r=".base64_encode("empty"));
		}
		
		else
		{
			//CHECK IF DETAILS FOUND IN DB
			$qry = "SELECT * FROM tblstudent WHERE stud_id = '$uname' AND passw = '".$password."'";
			
			$res = $this->db->getNumOfRows($qry);
			
			$fct = $this->db->fetchData($qry);
			
			if($res > 0)
			{
				//found grant access
				//create session here
				$_SESSION['studusername'] = $uname;
				$_SESSION['studlogged'] = "true";
				$_SESSION['fullname'] = $fct['lname']." ".$fct['fname'];
				
				$this->audit->audit_log("Student ".$_SESSION['studusername']." Successfully logged in");
				header("location:students/home.php");
			}
			else
			{
				//deny access error in login details
				
				header("location:index.php?r=".base64_encode('failed')); 
			}
		}
	}//end student login
	
	
	function  Update_Student()
	{   
		  $hidden = $this->fm->processfield($_POST['user']);
		  $gender = $_POST['gender'];
		  $email = $_POST['email'];
		  $dob =$_POST['dob'];
		  $soo = $_POST['state'];
		  $lga =$_POST['lga'];
		  $rel = $_POST['rel'];
		  $pob = $_POST['pob'];
		  $spe =$_POST['spe'];
		  $rp= $_POST['rp'];
		  $pp = $_POST['pp'];
		  $ha = $this->fm->processfield($_POST['ha']);
		  $phone = $_POST['phone'];
		  
		  	if(empty($ha)||empty($email)||empty($phone))
			{
				return '<font color="#FF0000" size="-2">Please make sure all fields are filled!</font>';
			}
					$query="UPDATE tblstudent SET  gender = '$gender',email ='$email',dob= '$dob',stateorigin ='$soo' ,lga = '$lga',reli= '$rel',placeofb = '$pob' ,specifi = '$spe' ,residencepref = '$rp',homadd = '$ha', phone='$phone', imgpath = '$pp' WHERE stud_id = '$hidden'";
					
					//return $query;
					$result = mysql_query($query) or die(mysql_error());
					
					if($result)
					{
						$this->audit->audit_log("Admin ".$_SESSION['username']." added a new student - ".$lname." ".$fname." ".$uname);
						return '<font color="#006600" size="-2">Your record updated successfully!</font>';
					}
	}//end
	
}

?>