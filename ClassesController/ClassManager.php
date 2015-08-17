<?php
		require_once("DBDirect.php");
		require_once('audit.php');
		require_once('Utilities.php');
		require_once('format.php');

class ManageClasses
{
	private $db, $audit,$util,$fm;
	
	function __construct()
	{
		$this->db = new DBConnecting();
		$this->audit = new AuditLog();
		$this->util = new Utilities();
		$this->fm = new Format();
	} 
	
public function Register_Class() 
{
	$classname = $this->fm->processfield(strtoupper($_POST['classname']));
  	$arm = $this->fm->processfield(strtoupper($_POST['arm']));
  	$des = $this->fm->processfield($_POST['des']);
  	$staff = $_POST['staff'];
       
		try {
			$sql = mysql_query("SELECT * from tblclass WHERE classname ='$classname' AND arm = '$arm' ") or die(mysql_error());
        	$no_rows = mysql_num_rows($sql);
		
			if ($no_rows == 0) 
			{
				$query="INSERT INTO tblclass (id,classname,arm,des,staffincharge,dateadded) VALUES ('','$classname','$arm','$des','$staff','".time()."');";
        		$result = mysql_query($query) or die(mysql_error());
        		
				$this->audit->audit_log("Admin ".$_SESSION['username']." added a new class - ".$classname." ".$arm);
				return '<font color="#006600" size="-2">You have successfully added a class!</font>';
			}
			else
			{
				return '<font color="#FF0000" size="-2">Sorry this Class has been added before !</font>';
			}
		}//try
		catch(Exception $exc)
		{
			echo ($exc->getMessage() . "<br>");
		}

}

// method to update Class
  public function Update_Class()
	 {
		 $classname = $this->fm->processfield(strtoupper($_POST['classname']));
  	     $arm = $this->fm->processfield(strtoupper($_POST['arm']));
         $des = $this->fm->processfield($_POST['des']);
  	     $staff = $_POST['staff'];
		 $classid = $_POST['classid'];
			 
		   
			try 
			{
				//update
				$upquery = "UPDATE tblclass SET id = '$classid',classname = '$classname' ,arm = '$arm' ,des = '$des' ,staffincharge = '$staff' ,dateadded = '".time()."' WHERE id = '$classid' " ;
				$res = mysql_query($upquery) or die(mysql_error());//or die('na here');
				
				$this->audit->audit_log("Admin ".$_SESSION['username']." added a new class - ".$classname." ".$arm);
				
				return '<font color="#006600" size="-2">You have successfully updated a class!</font>';
			
					
				}//try
			catch(Exception $exc)
			{
				echo ($exc->getMessage() . "<br>");
			} 
	 }



public function Delete_Class($classid)
	 {
			 
		   
			try 
			{
				//update
				$delquery = "DELETE from tbclass where  ClassId = '$classid'";				
				 $res = mysql_query($delquery) or die(mysql_error());//or die('na here');
					
					return $res;
			}//try
			catch(Exception $exc)
			{
				echo ($exc->getMessage() . "<br>");
			} 
	 }
	 
	 
public function removeSubjectFromTeacher($staffid,$remid,$class,$subject)
{
		
	$qry="DELETE FROM tblstaff_subject WHERE id=$remid and staffid='$staffid'";
	//return $qry;
	$this->db->executeQuery($qry);
		
	$this->audit->audit_log("Admin ".$_SESSION['username']." removed - ".$this->util->getStaffName($staffid)." from teaching ".$class." "." ".$subject);
	return '<font color="#006600" size="-2">Operation was successful</font>';
	//return "yea";
}
//----------------Method to assign subject to a teacher---------
public function assignSubjectToTeacher() 
{
	$subject = $_POST['subject'];
	$class = $_POST['class'];
  	$arm = $_POST['arm'];
  	$staffid = $_POST['staffid'];
	
	//getCurrentSession
	$cursession = $this->util->getCurrentSession();
	$sepsess = split("_", $cursession);
	
	$onsession = $sepsess[0];
	$onterm = $sepsess[1];
	
	if(empty($subject)||empty($class)||empty($arm))
	{
		return '<font color="#FF0000" size="-2">Please fill all the fields</font>';
	}
       
		try {
			$sql = mysql_query("SELECT * FROM tblstaff_subject WHERE class ='$class' AND subject = '$subject' AND arm = '$arm'") or die(mysql_error());
        	$no_rows = mysql_num_rows($sql);
		
			if ($no_rows == 0) 
			{
				$query="INSERT INTO tblstaff_subject (id,staffid,class,arm,subject,session,term,dateadded) VALUES ('','$staffid','$class','$arm','$subject','$onsession','$onterm','".time()."')";
        		$result = mysql_query($query) or die(mysql_error());
        		
				$this->audit->audit_log("Admin ".$_SESSION['username']." assigned - ".$staffid." to teach ".$class." ".$arm." ".$subject);
				return '<font color="#006600" size="-2">Subject Assigned successfully!</font>';
			}
			else
			{
				return '<font color="#FF0000" size="-2">Sorry this subject has been assigned before !</font>';
			}
		}//try
		catch(Exception $exc)
		{
			echo ($exc->getMessage() . "<br>");
		}

}

public function assignMultiSubjectToTeacher() 
{
	$subject = $_POST['subject'];
	$staffid = $_POST['staffid'];
	//capture classes from checkbox
	$arrayClass = $_POST['list'];
	//return $staffid;
	//getCurrentSession
	$cursession = $this->util->getCurrentSession();
	$sepsess = split("_", $cursession);
	
	$onsession = $sepsess[0];
	$onterm = $sepsess[1];
	
	if(empty($subject))
	{
		return '<font color="#FF0000" size="-2">Please select a subject</font>';
	}
	if(count($arrayClass) == 0)
	{
		return '<font color="#FF0000" size="-2">Please select at least 1 class</font>';
	}
	
	$num = 0;
	foreach($arrayClass as $class)
	{
		$num++;
		//split $class into class and arm
		$arrCl = split(" ",$class);
		$classn = $arrCl[0];
		$arm = $arrCl[1];
		
			$sql = mysql_query("SELECT * FROM tblstaff_subject WHERE class ='$classn' AND subject = '$subject' AND arm = '$arm'") or die(mysql_error());
        	$no_rows = mysql_num_rows($sql);
		
			if ($no_rows == 0) 
			{
				$query="INSERT INTO tblstaff_subject (id,staffid,class,arm,subject,session,term,dateadded) VALUES ('','$staffid','$classn','$arm','$subject','$onsession','$onterm','".time()."')";
				
				//return $staffid;
        		$result = mysql_query($query) or die(mysql_error());
        		
			}
			else
			{
				continue;
			}
		
	}
	
    $this->audit->audit_log("Admin ".$_SESSION['username']." assigned - ".$staffid." to teach ".$classn." ".$arm." ".$subject);
	return '<font color="#006600" size="-2">'.$num.' Classes was Assigned successfully!</font>';

}


//----------------Method to assign subject to a teacher---------
public function assignSubjectToStudent() 
{
	$subject = $_POST['subject'];
  	$studid = $_POST['studid'];
	$name=$this->util->getStudentName($studid);
	//getstudent current class and arm
	$getQry = "SELECT * FROM tblstudent WHERE stud_id = '$studid'";
	$getStd = $this->db->fetchData($getQry);
	$class = $getStd['class'];
	$arm = $getStd['arm'];
	
	//getCurrentSession
	$cursession = $this->util->getCurrentSession();
	$sepsess = split("_", $cursession);
	
	$onsession = $sepsess[0];
	$onterm = $sepsess[1];
	
	if(empty($subject))
	{
		return '<font color="#FF0000" size="-2">Please select a subject</font>';
	}
     
	 else
	 { 
	    
		try {
			$sql = mysql_query("SELECT * FROM tblstudsubject WHERE stud_id = '$studid' AND subject = '$subject' AND session='$onsession'") or die(mysql_error());
        	$no_rows = mysql_num_rows($sql);
		
			if ($no_rows == 0) 
			{
				$query="INSERT INTO tblstudsubject (id,name,stud_id,subject,session,term,class,arm,dateadded) VALUES ('','$name','$studid','$subject','$onsession','$onterm','$class','$arm','".time()."')";
        		$result = mysql_query($query) or die(mysql_error());
        		
				$this->audit->audit_log("Admin ".$_SESSION['username']." assigned - ".$subject." to ".$class." ".$arm." for ".$studid);
				return '<font color="#006600" size="-2">Subject Registered successfully!</font>';
			}
			else
			{
				return '<font color="#FF0000" size="-2">Sorry this subject has been registered for this session!</font>';
			}
		}//try
		catch(Exception $exc)
		{
			echo ($exc->getMessage() . "<br>");
		}
	 }
	 
	 
	 
	 
	 
}

// -------------Method for adding Book--------------------------

public function addBook()
{
	//getCurrentSession
	$cursession = $this->util->getCurrentSession();
	$sepsess = split("_", $cursession);
	
	$onsession = $sepsess[0];
	$onterm = $sepsess[1];
	
	$bookname = $this->fm->processfield(strtoupper($_POST['bookname']));
    $classname = $this->fm->processfield(strtoupper($_POST['classname']));
    $term = $this->fm->processfield(strtoupper($_POST['term']));
  	$detail = $this->fm->processfield(strtoupper($_POST['detail']));
	$subject = $this->fm->processfield(strtoupper($_POST['subject']));
	
	if(empty($bookname)||empty($classname)||empty($subject))
	{
		return '<font color="#FF0000" size="-2">Please fill all the fields!</font>';
	}
  	
	try {
                $query="INSERT INTO tblbooks(id,class,session,term,details,bookname,subject,dateadded) 
				VALUES ('','$classname','$onsession','$onterm','$detail','$bookname','$subject','".time()."')";
				
				$result = mysql_query($query) or die(mysql_error());
				return '<font color="#006600" size="-2">Book Added successfully</font>';
			
		}//try
		catch(Exception $exc)
		{
			echo ($exc->getMessage() . "<br>");
		}

}



// -------------Method for adding Holiday--------------------------

public function addHoliday()
{
    $holiday = $this->fm->processfield(strtoupper($_POST['holiday']));
  	$startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
	$publish = $_POST['publish'];
	
	if(empty($holiday)||empty($startdate)||empty($enddate))
	{
		return '<font color="#FF0000" size="-2">Please fill all the fields!</font>';
	}
  	
	try {
			
	 $query="INSERT INTO tblholidays(id,name,startdate,enddate,dateadded) VALUES ('','$holiday','$startdate','$enddate','".time()."')";
       
	$result = mysql_query($query) or die(mysql_error());
        		
				
				return '<font color="#006600" size="-2">Holiday Added successfully</font>';
			
		}//try
		catch(Exception $exc)
		{
			echo ($exc->getMessage() . "<br>");
		}

	
	
	
}
// -------------Method for adding Tutorial--------------------------
public function addTutorial()
{
    $title = $this->fm->processfield(strtoupper($_POST['title']));
  	$subject = $_POST['subject'];
    $class = $_POST['classname'];
  	$arm = strtoupper($_POST['arm']);
  	$desptn = $this->fm->processfield($_POST['desptn']);
    $upload = $this->fm->processfield($_POST['upload']);
	
	if(empty($title)||empty($class)||empty($desptn))
	{
		return '<font color="#FF0000" size="-2">Please fill all the fields!</font>';
	}
	
	
	try {
			
	 $query="INSERT INTO tbltutorial(id,title,subject,class,arm,upload,description,dateadded) VALUES ('','$title','$subject','$class','$arm','$upload','$desptn','".time()."')";
	 
        		$result = mysql_query($query) or die(mysql_error());
        		
				
				return '<font color="#006600" size="-2">Tutorial Added successfully</font>';
			
		}//try
		catch(Exception $exc)
		{
			echo ($exc->getMessage() . "<br>");
		}

	
	
	
} 
 
// -------------Method for adding Subject-------------------------- 
 public function addSubject()
{
    $short= strtoupper($_POST['short']);
  	$subject = strtoupper($_POST['sub']);
  
   try {
			$sql = mysql_query("SELECT * from tblsubject WHERE  shortform  ='$short'  OR subject = '$subject' ") or die(mysql_error());
        	$no_rows = mysql_num_rows($sql);
		
			if ($no_rows == 0) 
			{
				$query="INSERT INTO tblsubject (shortform,subject) VALUES ('$short','$subject')";
        		$result = mysql_query($query) or die(mysql_error());
        		
				return '<font color="#006600" size="-2">You have successfully added a class!</font>';
			}
			else
			{
				return '<font color="#FF0000" size="-2">Sorry this Class has been added before !</font>';
			}
		}//try
		catch(Exception $exc)
		{
			echo ($exc->getMessage() . "<br>");
		}

	
	
} 

//assign multiple subject to a class

public function assignMultipleSubjectToClass() 
{
	$classname = $_POST['class'];
	$arm = $_POST['arm'];
	$arraySubject = $_POST['list'];
	
	
	//getCurrentSession
	$cursession = $this->util->getCurrentSession();
	$sepsess = split("_", $cursession);
	
	$onsession = $sepsess[0];
	$onterm = $sepsess[1];
	
	if(count($arraySubject) == 0)
	{
		return '<font color="#FF0000" size="-2">Please select at least 1 subject</font>';
	}
	
	//select all students in a class//
	$stQry="SELECT * from tblstudent WHERE class='$classname' and arm='$arm'";
	//return $stQry;
	$rrr = mysql_query($stQry);
	
	while($stddata = mysql_fetch_array($rrr))
	{
		$student = $stddata['stud_id'];
		$name = $this->util->getStudentName($student);
		
				foreach($arraySubject as $subject)
				{
					$ggg = "SELECT * FROM tblstudsubject WHERE session ='$onsession' AND subject = '$subject' AND stud_id='".$student."'";
						
						//return $ggg;
						$sql = mysql_query($ggg) or die(mysql_error());
						$no_rows = mysql_num_rows($sql);
					
						if ($no_rows == 0) 
						{
							$query="INSERT INTO tblstudsubject (id,name,stud_id,subject,session,term,class,arm,dateadded) VALUES ('','$name','$student','$subject','$onsession','$onterm','$classname','$arm','".time()."')";
							
							//return $query;
							$result = mysql_query($query) or die(mysql_error());
							
						}
						else
						{
							continue;
						}
				}//end for each
	
	}//end while loop
				$this->audit->audit_log("Admin ".$_SESSION['username']." assigned - subjects to ".$classn." ".$arm);
				return '<font color="#006600" size="-2">Subjects registered successfully!</font>';
}


//assign multiple subject to a student
public function assignSubjectToMultiStudent() 
{
	$subject = $_POST['subject'];
	$classname = $_POST['classname'];
	$arrayStudent = $_POST['list'];
	
	//return $arrayStudent[1];
	//split $classname into class and arm
		$arrCl = split("_",$classname);
		$classn = $arrCl[0];
		$arm = $arrCl[1];
	
	//getCurrentSession
	$cursession = $this->util->getCurrentSession();
	$sepsess = split("_", $cursession);
	
	$onsession = $sepsess[0];
	$onterm = $sepsess[1];
	
	if(empty($subject))
	{
		return '<font color="#FF0000" size="-2">Please select a subject</font>';
	}
	if(count($arrayStudent) == 0)
	{
		return '<font color="#FF0000" size="-2">Please select at least 1 student</font>';
	}
	
	$num = 0;
	foreach($arrayStudent as $student)
	{
		$num++;
		$ggg = "SELECT * FROM tblstudsubject WHERE session ='$onsession' AND subject = '$subject' AND stud_id='".$student."'";
			
			$name=$this->util->getStudentName($student);
			//return $ggg;
			$sql = mysql_query($ggg) or die(mysql_error());
        	$no_rows = mysql_num_rows($sql);
		
			if ($no_rows == 0) 
			{
				$query="INSERT INTO tblstudsubject (id,name,stud_id,subject,session,term,class,arm,dateadded) VALUES ('','$name','$student','$subject','$onsession','$onterm','$classn','$arm','".time()."')";
        		
				//return $query;
				$result = mysql_query($query) or die(mysql_error());
        		
			}
			else
			{
				continue;
			}
	}//end for each
	
	
				$this->audit->audit_log("Admin ".$_SESSION['username']." assigned - ".$subject." to ".$classn." ".$arm);
				return '<font color="#006600" size="-2">'.$subject.' was registered successfully!</font>';
}

//---------------------------assign multiple subject to a student

public function assignMultiSubjectToStudent() 
{
	$student = $_POST['studid'];
	$classn = $_POST['class'];
	$arm = $_POST['arm'];
	$name = $this->util->getStudentName($student);
	$arraySubject = $_POST['list'];
	
	//getCurrentSession
	$cursession = $this->util->getCurrentSession();
	$sepsess = split("_", $cursession);
	
	$onsession = $sepsess[0];
	$onterm = $sepsess[1];
	
	
	if(count($arraySubject) == 0)
	{
		return '<font color="#FF0000" size="-2">Please select at least 1 subject</font>';
	}
	
	$num = 0;
	foreach($arraySubject as $subject)
	{
		
		$ggg = "SELECT * FROM tblstudsubject WHERE subject = '$subject' AND session = '$onsession' AND stud_id='".$student."'";
			
			//return $ggg;
			$sql = mysql_query($ggg) or die(mysql_error());
        	$no_rows = mysql_num_rows($sql);
		//return $no_rows;
			if ($no_rows == 0) 
			{
				$query="INSERT INTO tblstudsubject (id,name,stud_id,subject,session,term,class,arm,dateadded) VALUES ('','$name','$student','$subject','$onsession','$onterm','$classn','$arm','".time()."')";
        		
				//return $query;
				$result = mysql_query($query) or die(mysql_error());
        		$num++;
			}
			else
			{
				continue;
			}
	}//end for each
	
	
				$this->audit->audit_log("Admin ".$_SESSION['username']." registered subjects for ".$student." ".$classn." ".$arm);
				//return '<font color="#006600" size="-2">'.$num.' subject(s) registered successfully!</font>';
				
				header('location:studentsubject.php?stud_id='.$student);
}

//-----------------MOVE STUDENT TO ANOTHER CLASS------------------//
//assign multiple subject to a student
public function moveMultipleStudentToAnotherClass() 
{
	$class = $_POST['class'];
	$arm = $_POST['arm'];
	$arrayStudent = $_POST['list'];
	
	//getCurrentSession
	$cursession = $this->util->getCurrentSession();
	$sepsess = split("_", $cursession);
	
	$onsession = $sepsess[0];
	$onterm = $sepsess[1];
	
	if(empty($class) || empty($arm))
	{
		return '<font color="#FF0000" size="-2">Please select the new class your moving the student(s) to</font>';
	}
	if(count($arrayStudent) == 0)
	{
		return '<font color="#FF0000" size="-2">Please select at least 1 student to move</font>';
	}
	
	$num = 0;
	foreach($arrayStudent as $student)
	{
		$num++;
		//update the student class in tblstudent
		$ggg = "UPDATE tblstudent SET class='$class',arm='$arm' WHERE stud_id='".$student."'";
		$sql = mysql_query($ggg) or die(mysql_error());
	
		//UPDATE NEW CLASS IN tblstudsubject
		$chk = "SELECT * FROM tblstudsubject WHERE session='$onsession' AND stud_id='".$student."'";
		$sql2 = mysql_query($chk) or die(mysql_error());
       	$no_rows = mysql_num_rows($sql2);
			if($no_rows > 0) 
			{
				$query="UPDATE tblstudsubject SET class='$class',arm='$arm' WHERE session='$onsession' AND stud_id='".$student."'";
				$result = mysql_query($query) or die(mysql_error());
			}
			else continue;
			
			
		//update tblreportcard
		$chkscore = "SELECT * FROM tblreportcard WHERE session='$onsession' AND stud_id='".$student."'";
		$sql3 = mysql_query($chkscore) or die(mysql_error());
        $no_rows2 = mysql_num_rows($sql3);
			if($no_rows2 > 0) 
			{
				$query2="UPDATE tblreportcard SET class='$class',arm='$arm' WHERE session='$onsession' AND stud_id='".$student."'";
				$result2 = mysql_query($query2) or die(mysql_error());
			}
			else continue;
			
	}//end for each
	
	
				$this->audit->audit_log("Admin ".$_SESSION['username']." moved students from ".$_POST['oldclass']." to class ".$class." ".$arm);
				return '<font color="#006600" size="-2">'.$num.' student(s) was moved successfully from '.$_POST['oldclass'].' to '.$class." ".$arm.'</font>';
}


public function removeSubject() 
{
	$subject = $_POST['subject'];
	$classname = $_POST['classname'];
	$arrayStudent = $_POST['list'];
	
	//return $arrayStudent[1];
	//split $classname into class and arm
		$arrCl = split("_",$classname);
		$classn = $arrCl[0];
		$arm = $arrCl[1];
	
	//getCurrentSession
	$cursession = $this->util->getCurrentSession();
	$sepsess = split("_", $cursession);
	
	$onsession = $sepsess[0];
	$onterm = $sepsess[1];
	
	if(empty($subject))
	{
		return '<font color="#FF0000" size="-2">Please select a subject</font>';
	}
	if(count($arrayStudent) == 0)
	{
		return '<font color="#FF0000" size="-2">Please select at least 1 student</font>';
	}
	
	$num = 0;
	foreach($arrayStudent as $student)
	{
		$num++;
		$ggg = "SELECT * FROM tblstudsubject WHERE session ='$onsession' AND subject = '$subject' AND stud_id='".$student."'";
			
			//return $ggg;
			 $sql = mysql_query($ggg) or die(mysql_error());
			 
			 $proid = mysql_fetch_array($sql);
			 
			 $getid = $proid['id'] ;
			
			 // delete from tblstudsubject			 
			 $query="DELETE FROM tblstudsubject WHERE id = '$getid'";
			 $result = mysql_query($query) or die(mysql_error());
			
        		
		  $delfromrepc = "SELECT * FROM tblreportcard WHERE session ='$onsession' AND subject = '$subject' AND stud_id='".$student."'";
		  $sql1 = mysql_query($delfromrepc) or die(mysql_error());	
		  
		   
		  while($proid1 = mysql_fetch_array($sql1)){
		  $getid1 = $proid1['id'] ;	
		  $query1="DELETE FROM tblreportcard WHERE id = '$getid1'";
		 // return $query1;
          $result1 = mysql_query($query1) or die(mysql_error());
		   }
		//	
	}//end for each
	
	
				$this->audit->audit_log("Admin ".$_SESSION['username']." deleted - ".$subject." from ".$classn." ".$arm);
				return '<font color="#006600" size="-2">'.$subject.' was deleted successfully!</font>';
}

//---------------------------delete method------------------------------------------


//promote to next class
public function promoteToNextClass() 
{
	$class = $_POST['class'];
	$arm = $_POST['arm'];
	$arrayStudent = $_POST['list'];
	
	//getCurrentSession
	$cursession = $this->util->getCurrentSession();
	$sepsess = split("_", $cursession);
	
	$onsession = $sepsess[0];
	$onterm = $sepsess[1];
	
	if(empty($class) || empty($arm))
	{
		return '<font color="#FF0000" size="-2">Please select the new class your moving the student(s) to</font>';
	}
	if(count($arrayStudent) == 0)
	{
		return '<font color="#FF0000" size="-2">Please select at least 1 student to move</font>';
	}
	
	$num = 0;
	foreach($arrayStudent as $student)
	{
		$num++;
		//update the student class in tblstudent
		$ggg = "UPDATE tblstudent SET class='$class',arm='$arm' WHERE stud_id='".$student."'";
		$sql = mysql_query($ggg) or die(mysql_error());
	
	}//end for each
	
	
				$this->audit->audit_log("Admin ".$_SESSION['username']." promoted students from ".$_POST['oldclass']." to class ".$class." ".$arm);
				return '<font color="#006600" size="-2">'.$num.' student(s) was promoted from '.$_POST['oldclass'].' to '.$class." ".$arm.'</font>';
}//end promote


// -------------Method for adding Assignment--------------------------
public function addAssignment()
{
    $subject = $this->fm->processfield($_POST['subject']);
  	$class =  $this->fm->processfield($_POST['classname']);
    $arm =  $this->fm->processfield($_POST['arm']);
	$title =  $this->fm->processfield(strtoupper($_POST['title']));
	$comment =  $this->fm->processfield(strtoupper($_POST['comment']));
	$duedate =  $this->fm->processfield($_POST['duedate']);
	$time =  $this->fm->processfield(strtoupper($_POST['time']));
	$mark =  $this->fm->processfield(strtoupper($_POST['mark']));
	$publish =  $this->fm->processfield($_POST['publish']);
	
	if(empty($subject)||empty($class)||empty($duedate)||empty($time)||empty($title))
	{
		return '<font color="#FF0000" size="-2">Please fill all the fields!</font>';
	}
	
	try {
                $query="INSERT INTO tblassignment(id,title,subject,classname,arm,comment,due_date,time,mark,upload,publish,dateadded) VALUES ('','$title','$subject','$class','$arm','$comment','$duedate','$time','$mark','$upload','$publish','".time()."')";
        		$result = mysql_query($query) or die(mysql_error());
        		
				
				return '<font color="#006600" size="-2">Assignment Added successfully</font>';
			
		}//try
		catch(Exception $exc)
		{
			echo ($exc->getMessage() . "<br>");
		}

	
	
	
}

}//end of class
?>