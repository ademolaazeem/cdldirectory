<?php
		require_once("DBDirect.php");
		require_once('audit.php');

class Utilities 
{
	private $db, $audit,$util;
	
	function __construct()
	{
		$this->db = new DBConnecting();
		$this->audit = new AuditLog();
	}
	
	public function addStafflinks()
	{
		$label = $_POST['link'];
		$url = $_POST['url'];
		$image = $_POST['path'];
		$access = $_POST['access'];
		
		$qry = "INSERT INTO admin_menu (id,image,label,link_url,accesslevel) VALUES('','$image','$label','$url','$access')";
		
		if($this->db->executeQuery($qry))
		{
			$this->audit->audit_log("Admin ".$_SESSION['username']." added a new staff link - ".$label);
			return '<font color="#006600" size="-2">You have successfully added a link!</font>';
		}
		else
		{
			return '<font color="#FF0000" size="-2">Operation not successful, Please try again</font>';
		}
		
	}
	
	public function updateStafflinks()
	{
		$label = $_POST['link'];
		$url = $_POST['url'];
		$image = $_POST['path'];
		$access = $_POST['access'];
		$linkid = $_POST['linkid'];
		
		$qry = "UPDATE admin_menu SET image ='$image',label='$label',link_url='$url',accesslevel='$access' WHERE id = $linkid";
		
		if($this->db->executeQuery($qry))
		{
			$this->audit->audit_log("Admin ".$_SESSION['username']." updated staff link - ".$label);
			return '<font color="#006600" size="-2">Link update was successful</font>';
		}
		else
		{
			return '<font color="#FF0000" size="-2">Operation not successful, Please try again</font>';
		}
	}
	
	public function addStudlinks()
	{
		$label = $_POST['link'];
		$url = $_POST['url'];
		$image = $_POST['path'];
		
		$qry = "INSERT INTO admin_menu (id,label,link_url,image) VALUES('','$label','$url','$image')";
		
		if($this->db->executeQuery($qry))
		{
			$this->audit->audit_log("Admin ".$_SESSION['username']." added a new student link - ".$label);
			return '<font color="#006600" size="-2">You have successfully added a link!</font>';
		}
		else
		{
			return '<font color="#FF0000" size="-2">Operation not successful, Please try again</font>';
		}
	}
	
	public function updateStudlinks()
	{
		$label = $_POST['link'];
		$url = $_POST['url'];
		$image = $_POST['path'];
		
		$linkid = $_POST['linkid'];
		
		$qry = "UPDATE stud_menu SET image ='$image',label='$label',link_url='$url' WHERE id = $linkid";
		
		if($this->db->executeQuery($qry))
		{
			$this->audit->audit_log("Admin ".$_SESSION['username']." updated student link - ".$label);
			return '<font color="#006600" size="-2">Link update was successful</font>';
		}
		else
		{
			return '<font color="#FF0000" size="-2">Operation not successful, Please try again</font>';
		}	
	}
	
	public function addSubjects()
	{
		$subject = $_POST['subject'];
		$shortfrm = $_POST['shortfrm'];
		
		$qry = "INSERT INTO tblsubject (id,shortform,subject) VALUES('','$shortfrm','$subject')";
		
		if($this->db->executeQuery($qry))
		{
			$this->audit->audit_log("Admin ".$_SESSION['username']." added a new subject - ".$subject);
			return '<font color="#006600" size="-2">You have successfully added a subject!</font>';
		}
		else
		{
			return '<font color="#FF0000" size="-2">Operation not successful, Please try again</font>';
		}
	}
	
	public function updateSubjects()
	{
		$subject = $_POST['subject'];
		$shortfrm = $_POST['shortfrm'];
		
		$subid = $_POST['subid'];
		
		$qry = "UPDATE tblsubject SET subject ='$subject',shortform='$shortfrm' WHERE id = $subid";
		
		if($this->db->executeQuery($qry))
		{
			$this->audit->audit_log("Admin ".$_SESSION['username']." updated subject - ".$subject);
			return '<font color="#006600" size="-2">Subject update was successful</font>';
		}
		else
		{
			return '<font color="#FF0000" size="-2">Operation not successful, Please try again</font>';
		}	
	}
	
	
	
	
	public function addTotalFee()
	{
	$category = mysql_real_escape_string($_POST['category']);
	$studenttype = mysql_real_escape_string($_POST['studenttype']);
	$session = mysql_real_escape_string($_POST['session']);
	$term = mysql_real_escape_string($_POST['term']);	
	$amount = mysql_real_escape_string($_POST['amount']);
	
	if($category=="" || empty($studenttype)|| $session=="" || $term=="" || empty($amount))
	{
		return '<font color="#FF0000" size="-2">Please make sure all fields are completed, Empty not allowed.</font>';
	}
	else
	{
		$qry = "INSERT INTO tbl_totalfee (id,student_category,student_type,term, session, amount) VALUES('','$category','$studenttype','$session','$term', '$amount')";
		
		if($this->db->executeQuery($qry))
		{
			$this->audit->audit_log("Admin ".$_SESSION['username']." added a new Total Fee - N".$amount);
			return '<font color="#006600" size="-2">New Total Fee has been successfully added!</font>';
		}
		else
		{
			return '<font color="#FF0000" size="-2">Operation not successful, Please try again</font>';
		}
	}//end else
	}//end Method
	public function updateTotalFee()
	{
	$category = mysql_real_escape_string($_POST['category']);
	$studenttype = mysql_real_escape_string($_POST['studenttype']);
	$session = mysql_real_escape_string($_POST['session']);
	$term = mysql_real_escape_string($_POST['term']);	
	$amount = mysql_real_escape_string($_POST['amount']);
		
	$subid = $_POST['subid'];
		
		$qry = "UPDATE tbl_totalfee SET student_category ='$category',student_type='$studenttype', term='$term', session='$session', amount='$amount' WHERE id = $subid";
		
		if($this->db->executeQuery($qry))
		{
			$this->audit->audit_log("Admin ".$_SESSION['username']." updated Total School Fee  - N".$amount);
			return '<font color="#006600" size="-2">Total School Fee update was successful</font>';
		}
		else
		{
			return '<font color="#FF0000" size="-2">Operation not successful, Please try again</font>';
		}	
	}
	
	
	
	
	
	
	
	
	
	
	
	public function getCurrentSession()
	{
		$qry = "SELECT * FROM tblsession WHERE sessionstatus = 1";
		$rs = $this->db->fetchData($qry);
		
		$onsession = $rs['session'];
		$onterm = $rs['term'];
		
		return $onsession."_".$onterm;
	}
	
	public function setSchoolName()
	{
		$school = $_POST['schoolname'];
		$shortfrm = $_POST['shortfrm'];
		$addr = $_POST['address'];
		
		$qry = "INSERT INTO tblschooldata (id,schoolname,shortform,address) VALUES('','$school','$shortfrm','$addr')";
		
		if($this->db->executeQuery($qry))
		{
			$this->audit->audit_log("Admin ".$_SESSION['username']." setup the school data");
			return '<font color="#006600" size="-2">Operation was successfully!</font>';
		}
		else
		{
			return '<font color="#FF0000" size="-2">Operation not successful, Please try again</font>';
		}
	}
	
	public function getSchoolShort()
	{
		$schQry = "select * from tblschooldata";
		$schData = $this->db->fetchData($schQry);
		return $sch = $schData['shortform'];
	}
	
	public function getStaffName($id)
	{
		$qry = "SELECT * FROM tbl_directory WHERE id = '$id'";
		$rs = $this->db->fetchData($qry);
		
		return $rs['fullname']." ID:".$rs['id'];
	}
	
	public function getStudentClass($studid)
	{
		$qry = "SELECT * FROM tblstudent WHERE stud_id = '$studid'";
		$rs = $this->db->fetchData($qry);
		
		return $rs['class'];
	}
	
	public function getStudentName($studid)
	{
		$qry = "SELECT * FROM tblstudent WHERE stud_id = '$studid'";
		$rs = $this->db->fetchData($qry);
		
		return $rs['lname']." ".$rs['fname']." ".$rs['mname'];
	}
	
	
	

	
	
	
	
	
	////UPLOAD PIX
	
public function upload($path,$ownerid)
{
	
	if(empty($_FILES["file"]["name"]))
	{
		return '<font color="#FF0000" size="-2">Select file to be uploaded</font>';
	}
	if($_FILES["file"]["size"] > 900000)
	{
		return '<font color="#FF0000" size="-2">The passport is more than the allowed upload size of 900kb</font>';
	}
	
//$filename = $this->getStaffName($ownerid)."_".$_FILES["file"]["name"];
$filename = "Staff_".$ownerid."_".$_FILES["file"]["name"];
	
	if ((($_FILES["file"]["type"] == "image/png")||($_FILES["file"]["type"] == "image/jpeg")
	||($_FILES["file"]["type"] == "image/jpg")||($_FILES["file"]["type"] == "image/gif")||($_FILES["file"]["type"] == "image/pjpeg")))
	{
				
$target_path = "../images/uploads/".$path."/".$filename;
$realpath = "../images/uploads/".$path."/".$filename;
					//check if the user has a pix before remove it and replace
					
if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_path))
						{
							
$pcqy ="";
if($path=="staff_directory")
{
						
$pcqy = "SELECT * FROM tbl_directory WHERE id='$ownerid'";
$pxdata = $this->db->fetchData($pcqy);
$imagename="../".$pxdata['picture'];
								
		if(!empty($imagename)) unlink($imagename);
								
mysql_query("UPDATE tbl_directory SET picture='$realpath' WHERE id='$ownerid'");
$_SESSION['image']=$realpath;		
$this->audit->audit_log($_SESSION['username']." successfully uploaded picture of a staff with id ".$this->getStaffName($ownerid));
return '<font color="#006600" size="-2">Picture uploaded successfully!</font>';
								
							}
							else
							{	
								//$_SESSION['image']=$realpath;
$pcqy = "SELECT * FROM tblstudent WHERE stud_id='$ownerid'";
$pxdata = $this->db->fetchData($pcqy);
$imagename="../".$pxdata['imgpath'];
								
if(!empty($pxdata['imgpath'])&& file_exists($imagename)) {unlink($imagename);}
mysql_query("UPDATE tblstudent SET imgpath='$realpath' WHERE stud_id='$ownerid'");
$this->audit->audit_log("Admin ".$_SESSION['username']." uploaded picture ".$filename." for student ".$this->getStudentName($ownerid));
								
$this->audit->audit_log($this->getStudentName($ownerid)." uploaded a picture ".$filename);
									return '<font color="#006600" size="-2">Picture uploaded successfully!</font>';
								
							}
						}
						else return '<font color="#FF0000" size="-2">File Upload failed, please try again!</font>';
      	
		}//end if checking file type
		else
		{
			return '<font color="#FF0000" size="-2">Invalid File selected!</font>';
		}
}//end upload
	
	

//----------------------------UPLOAD FILES------------
function uploadFiles($path,$fileup,$type,$size,$temp)//folder to upload to and table to update in db
{
	//create $path, if it does not exist
	
	if($size > 900000)
	{
		return "The file is more than the allowed upload size of 900kb";
	}
	
	//application/pdf, application/msword
	//<900kb application/vnd.openxmlformats-officedocument.wordprocessingml.document
	if ((($type == "application/pdf")||($type == "application/msword") ||($type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")) && ($size < 900000))
	{
		if(move_uploaded_file($temp, "../".$path."/".$fileup))
		{
			return 1;
		}
		else return "Try again the file was not uploaded";
	}
	else return "This type of file is not allowed, select on PDF or MSWORD";

}//end upload
	
	
}
?>