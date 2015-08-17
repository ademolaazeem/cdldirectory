<?php
		require_once("DBDirect.php");
		require_once('audit.php');
		require_once('Utilities.php');

class ResultManager
{
	private $db, $audit,$util;
	
	function __construct()
	{
		$this->db = new DBConnecting();
		$this->audit = new AuditLog();
		$this->util = new Utilities();
	} 


///=========================-------------------temporary code for addScorePerSubject------------------------=============================

public function tempaddScorePerSubject($onsession)
	{
		$class = $_POST['class'];
		$subject = base64_decode($_POST['subject']);
		
		//capture each student's id from checkbox
		$arrayStudid = $_POST['list'];
		
		$onterm = "FIRST";
		$onterm2 = "SECOND";
		
		//split $class into class and arm
		$arrCl = split("_",$class);
		$classn = $arrCl[0];
		$arm = $arrCl[1];
		
		if(count($arrayStudid) == 0)
		{
			return '<font color="#FF0000" size="-2">Please select at least 1 student</font>';
		}
			
			$num = 0;
			foreach($arrayStudid as $stud)
			{
				$term1 = $_POST[$stud."1"];
				$term2 = $_POST[$stud."2"];
				
				$name=$this->util->getStudentName($stud);
				
				$num++;
				
					$sql = mysql_query("SELECT * FROM tblreportcard WHERE stud_id='$stud' AND class ='$classn' AND subject = '$subject' AND arm = '$arm' AND term='$onterm' AND session='$onsession'") or die(mysql_error());
					$no_rows = mysql_num_rows($sql);
				
				//if no such record insert else update
				if ($no_rows == 0) 
				{
					$query="INSERT INTO tblreportcard(id,name,stud_id,subject,session,term,class,arm,total,daterecord)
						VALUES('', '$name','$stud', '$subject', '$onsession', '$onterm', '$classn', '$arm', '$term1', '".time()."')";
						
						//return $query;
						$result = mysql_query($query) or die(mysql_error());
						
				}
				else
				{
					$query="UPDATE tblreportcard SET total='$term1',daterecord='".time()."' WHERE stud_id='$stud' AND class ='$classn' AND subject = '$subject' AND arm = '$arm' AND term='$onterm' AND session='$onsession'";
						
						//return $query;
						$result = mysql_query($query) or die(mysql_error());
				}
				
				
				//FOR SECOND TERM
				
				$sql2 = mysql_query("SELECT * FROM tblreportcard WHERE stud_id='$stud' AND class ='$classn' AND subject = '$subject' AND arm = '$arm' AND term='$onterm2' AND session='$onsession'") or die(mysql_error());
					$no_rows2 = mysql_num_rows($sql2);
				
				//if no such record insert else update
				if ($no_rows2 == 0) 
				{
					$query2="INSERT INTO tblreportcard(id,name,stud_id,subject,session,term,class,arm,total,daterecord)
						VALUES('','$name', '$stud', '$subject', '$onsession', '$onterm2', '$classn', '$arm','$term2', '".time()."')";
						
						//return $query;
						$result2 = mysql_query($query2) or die(mysql_error());
						
				}
				else
				{
					$query2="UPDATE tblreportcard SET total='$term2',daterecord='".time()."' WHERE stud_id='$stud' AND class ='$classn' AND subject = '$subject' AND arm = '$arm' AND term='$onterm2' AND session='$onsession'";
						
						//return $query;
						$result2 = mysql_query($query2) or die(mysql_error());
				}
				
				
			}//end for each
			
			$this->audit->audit_log("Admin ".$_SESSION['username']." updated ".$subject." result for class ".$classn." ".$arm);
			return '<font color="#006600" size="-2">'.$subject.' result was updated successfully! for class '.$classn.' '.$arm.'</font>';
				
				
	 }//end addMultiscore temporary
			
	

public function tempaddScoreForMultiSubject()
		
		{
		$class = $_POST['class'];
		$arm = $_POST['arm'];
		$stud = $_POST['studid'];
		
		$name = $this->util->getStudentName($stud);
		
		//capture each student's id from checkbox
		$arraySubject = $_POST['list'];
		//return $staffid;
		//getCurrentSession
		//$cursession = $this->util->getCurrentSession();
		//$sepsess = split("_", $cursession);
		
		$onsession = "2011/2012";
		$onterm = "FIRST";
		
		if(count($arraySubject) == 0)
		{
			return '<font color="#FF0000" size="-2">Please select at least 1 subject</font>';
		}
			
			$num = 0;
			foreach($arraySubject as $subj)
			{
				//SPLIT SUBJECT
				$subSplit = split("_",$subj);
				$subject = $subSplit[0];
				$ID = $subSplit[1];
				
				
				$formorder1 = $_POST[$ID."_1"];
				$formorder2 = $_POST[$ID."_2"];
				$exam = $_POST[$ID."_3"];
				$total = $formorder1 + $formorder2 + $exam;
				
				$num++;
				
					$sql = mysql_query("SELECT * FROM tblreportcard WHERE stud_id='$stud' AND class ='$class' AND subject = '$subject' AND arm = '$arm' AND term='$onterm' AND session='$onsession'") or die(mysql_error());
					$no_rows = mysql_num_rows($sql);
				
				//if no such record insert else update
				if ($no_rows == 0) 
				{
					$query="INSERT INTO tblreportcard(id,name,stud_id,subject,session,term,class,arm,formorder1,formorder2,exam,total,daterecord)
						VALUES('','$name', '$stud', '$subject', '$onsession', '$onterm', '$class', '$arm', '$formorder1', '$formorder2', '$exam', '$total', '".time()."')";
						
						//return $query;
						
						$result = mysql_query($query) or die(mysql_error());
						
				}
				else
				{
					$query="UPDATE tblreportcard SET formorder1='$formorder1', formorder2='$formorder2',exam='$exam',total='$total',daterecord='".time()."' WHERE stud_id='$stud' AND class ='$class' AND subject = '$subject' AND arm = '$arm' AND term='$onterm' AND session='$onsession'";
						
					//return $query;	
						$result = mysql_query($query) or die(mysql_error());
				}
				
			}//end for each
			
			$this->audit->audit_log("Admin ".$_SESSION['username']." updated ".$stud." result for class ".$class." ".$arm);
			return '<font color="#006600" size="-2">Result was updated successfully!</font>';
				
				
	 }//end addMultiscore
	 
	 //-------------------
	 
	
	public function addScorePerSubject()
	{
		$class = $_POST['class'];
		$subject = $_POST['subject'];
		
		//capture each student's id from checkbox
		$arrayStudid = $_POST['list'];
		//return $staffid;
		//getCurrentSession
		$cursession = $this->util->getCurrentSession();
		$sepsess = split("_", $cursession);
		
		$onsession = $sepsess[0];
		$onterm = $sepsess[1];
		
		//split $class into class and arm
		$arrCl = split("_",$class);
		$classn = $arrCl[0];
		$arm = $arrCl[1];
		
		if(count($arrayStudid) == 0)
		{
			return '<font color="#FF0000" size="-2">Please select at least 1 student</font>';
		}
			
			$num = 0;
			foreach($arrayStudid as $stud)
			{
				$formorder1 = $_POST[$stud."1"];
				$formorder2 = $_POST[$stud."2"];
				$exam = $_POST[$stud."3"];
				$total = $formorder1 + $formorder2 + $exam;
				
				$num++;
				
				$name = $this->util->getStudentName($stud);
				
					$sql = mysql_query("SELECT * FROM tblreportcard WHERE stud_id='$stud' AND class ='$classn' AND subject = '$subject' AND arm = '$arm' AND term='$onterm' AND session='$onsession'") or die(mysql_error());
					$no_rows = mysql_num_rows($sql);
				
				//if no such record insert else update
				if ($no_rows == 0) 
				{
					$query="INSERT INTO tblreportcard(id,name,stud_id,subject,session,term,class,arm,formorder1,formorder2,exam,total,daterecord)
						VALUES('','$name', '$stud', '$subject', '$onsession', '$onterm', '$classn', '$arm', '$formorder1', '$formorder2', '$exam', '$total', '".time()."')";
						
						//return $query;
						$result = mysql_query($query) or die(mysql_error());
						
				}
				else
				{
					$query="UPDATE tblreportcard SET formorder1='$formorder1', formorder2='$formorder2',exam='$exam',total='$total',daterecord='".time()."' WHERE stud_id='$stud' AND class ='$classn' AND subject = '$subject' AND arm = '$arm' AND term='$onterm' AND session='$onsession'";
						
						//return $query;
						$result = mysql_query($query) or die(mysql_error());
				}
				
			}//end for each
			
			$this->audit->audit_log("Admin ".$_SESSION['username']." updated ".$subject." result for class ".$classn." ".$arm);
			return '<font color="#006600" size="-2">'.$subject.' result was updated successfully! for class '.$classn.' '.$arm.'</font>';
				
				
	 }//end addMultiscore
			
	//----------=======Adding score for all the subjects registered by a student=====================================
public function addScoreForMultiSubject()
		
		{
		$class = $_POST['class'];
		$arm = $_POST['arm'];
		$stud = $_POST['studid'];
		
		$name=$this->util->getStudentName($stud);
		
		//capture each student's id from checkbox
		$arraySubject = $_POST['list'];
		//return $staffid;
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
			foreach($arraySubject as $subj)
			{
				//SPLIT SUBJECT
				$subSplit = split("_",$subj);
				$subject = $subSplit[0];
				$ID = $subSplit[1];
				
				
				$formorder1 = $_POST[$ID."_1"];
				$formorder2 = $_POST[$ID."_2"];
				$exam = $_POST[$ID."_3"];
				$total = $formorder1 + $formorder2 + $exam;
				
				$num++;
				
					$sql = mysql_query("SELECT * FROM tblreportcard WHERE stud_id='$stud' AND class ='$class' AND subject = '$subject' AND arm = '$arm' AND term='$onterm' AND session='$onsession'") or die(mysql_error());
					$no_rows = mysql_num_rows($sql);
				
				//if no such record insert else update
				if ($no_rows == 0) 
				{
					$query="INSERT INTO tblreportcard(id,name,stud_id,subject,session,term,class,arm,formorder1,formorder2,exam,total,daterecord)
						VALUES('','$name', '$stud', '$subject', '$onsession', '$onterm', '$class', '$arm', '$formorder1', '$formorder2', '$exam', '$total', '".time()."')";
						
						//return $query;
						
						$result = mysql_query($query) or die(mysql_error());
						
				}
				else
				{
					$query="UPDATE tblreportcard SET formorder1='$formorder1', formorder2='$formorder2',exam='$exam',total='$total',daterecord='".time()."' WHERE stud_id='$stud' AND class ='$class' AND subject = '$subject' AND arm = '$arm' AND term='$onterm' AND session='$onsession'";
						
					//return $query;	
						$result = mysql_query($query) or die(mysql_error());
				}
				
			}//end for each
			
			$this->audit->audit_log("Admin ".$_SESSION['username']." updated ".$stud." result for class ".$class." ".$arm);
			return '<font color="#006600" size="-2">Result was updated successfully!</font>';
				
				
	 }//end addMultiscore
	 
	 //-------------------
	 
	
	public function deleteMultiSubject()
	{
		
		$class = $_POST['class'];
		$arm = $_POST['arm'];
		$stud = $_POST['studid'];
		
		$arraySubject = $_POST['list'];
		//return $staffid;
		//getCurrentSession
		$cursession = $this->util->getCurrentSession();
		$sepsess = split("_", $cursession);
		
		$onsession = $sepsess[0];
		$onterm = $sepsess[1];
		
		if(count($arraySubject) == 0)
		{
			return '<font color="#FF0000" size="-2">Please select at least 1 subject to Remove </font>';
		}
			
			$num = 0;
			foreach($arraySubject as $subj)
			{
				//SPLIT SUBJECT
				$subSplit = split("_",$subj);
				$subject = $subSplit[0];
				
			
		
		
		
	  $delfromstudsub =	"delete from tblstudsubject where stud_id = '$stud' and subject ='$subject' and session ='$onsession'";
	  $delstudsub =mysql_query($delfromstudsub);
	  
	  
	  $selfromreport = "select * from tblreportcard where stud_id = '$stud' and subject = '$subject' and session ='$onsession'";
	  $delquery1 =mysql_query($selfromreport);
	   
	  $n = mysql_num_rows($delquery1);
	  
	 // return  $n;
	 // $resultdel = mysql_fetch_array($delquery1);
	  
	  while($arrid = mysql_fetch_array($delquery1)){
	 
	  $delvalue =  $arrid['id'];
	  
	  $delfromreport =	"delete from tblreportcard where id = '$delvalue'";
	  
	  $delrep =mysql_query($delfromreport);
	  }
	  
	  $msg = '<font color="#006600" size="-2">You have successfully deleted  a subject </font>';
		
		
	}
}
	public function getAllScores($studid,$onsession,$onterm,$class,$arm,$subject)
	 {
		
		
		 $qry="SELECT * FROM tblreportcard WHERE stud_id='$studid' and subject = '$subject' AND term='$onterm' AND session='$onsession'";
		 
		 $res=$this->db->fetchData($qry);
		 
		 return $res['formorder1']."_".$res['formorder2']."_".$res['exam'];
	 }
	 
	 
	 
	 public function tempGetAllScores1($studid,$onsession,$onterm,$class,$arm,$subject)
	 {
		 $qry="SELECT * FROM tblreportcard WHERE stud_id='$studid' and subject = '$subject' and session='$onsession' and term='$onterm' and class='$class'";

		 $res=$this->db->fetchData($qry);
		 
		 return $res['total'];
	 }
	 
	 public function tempGetAllScores2($studid,$onsession,$onterm,$class,$arm,$subject)
	 {
		 $qry="SELECT * FROM tblreportcard WHERE stud_id='$studid' and subject = '$subject' and session='$onsession' and term='$onterm' and class='$class'";
		 
		 $res=$this->db->fetchData($qry);
		 
		 return $res['total'];
	 }
	 
	 
	 
	//----------=======Adding comment by house master===================================== 
	 
public function housemastercomment()
	{
		
		
		
		//capture each student's  id from checkbox
		$arrayComment = $_POST['list'];
		
		//getCurrentSession
		$cursession = $this->util->getCurrentSession();
		$sepsess = split("_", $cursession);
		
		$onsession = $sepsess[0];
		$onterm = $sepsess[1];
		
		$date = date("l, F d, Y h:i" ,time());
		
		if(count($arrayComment) == 0)
		{
			return '<font color="#FF0000" size="-2">Please select at least 1 student</font>';
		}
			
			$num = 0;
			foreach($arrayComment as $stud)
			{
				//SPLIT SUBJECT
				//$subSplit = split("_",$comment);
				//$comment1 = $subSplit[0];
				//$comm= $subSplit[1];
				
				$class = $_POST[$stud."class"];
		          $arm = $_POST[$stud."arm"];
				$comment1 = $_POST[$stud."_1"];
				$comment2 = $_POST[$stud."_2"];
				
					
							$num++;
				
					$sql = mysql_query("select * from tblcomment WHERE stud_id='$stud' AND class ='$class' AND arm = '$arm' AND term='$onterm' AND session='$onsession'") or die(mysql_error());
					
										
					$no_rows = mysql_num_rows($sql);
				
								//if no such record insert else update
				if ($no_rows == 0) 
				{
					
					$query="INSERT INTO tblcomment(hm1,hm2,class,arm,session,term,stud_id,dateadded) VALUES ('$comment1', '$comment2','$class','$arm','$onsession','$onterm','$stud',$date)";
						//return $query;
						
						$result = mysql_query($query) or die(mysql_error());
						
				}
				else
				{
					$query="UPDATE tblcomment SET hm1='$comment1', hm2='$comment2', dateadded= '$date' WHERE stud_id='$stud' AND class ='$class' AND arm = '$arm' AND term='$onterm' AND session='$onsession'";
						
					//return $query;	
						$result = mysql_query($query) or die(mysql_error());
				}
				
			}//end for each
			
			//$this->audit->audit_log("Admin ".$_SESSION['username']." updated ".$stud." result for class ".$class." ".$arm);
			return '<font color="#006600" size="-2">Comment was added successfully!</font>';
				
				
	 }//end hmaster comment
	 
	 
	 function principalcomment()
{
	$stud = $_POST['stud'];
	$class = $_POST['class'];
	$arm = $_POST['arm'];
	$session = $_POST['session'];
	$term = $_POST['term'];
	
	$ppl1 = $_POST['ppl1']; 
	$ppl2 = $_POST['ppl2'];
	$date =  date("l, F d, Y h:i" ,time());
	
	$qry1 = "SELECT * FROM tblcomment WHERE stud_id = '$stud' AND session = '$session' AND term ='$term'AND class='$class' AND arm = '$arm'";
	
	$savecom1 = mysql_query($qry1) or die(mysql_error()); //na here
	
	$result = mysql_fetch_array($savecom1);
	$olddate= $result['dateadded'];
	$row_num = mysql_num_rows($savecom1);
	
	if ($row_num == 0)
	{
	$qry = "INSERT INTO tblcomment (ppl1,ppl2,term,class,arm,stud_id,dateadded) VALUES ('$ppl1','$ppl2','$session','$term','$class','$arm','$stud','$date')";
	$savecom = mysql_query($qry) or die(mysql_error()); //na here

   return '<font color="#006600" size="-1">Comment added successfully.</font>';
	}
    else
	{
		$qry2 = "update tblcomment set ppl1 = '$ppl1',ppl2 = '$ppl2',session = '$session',term ='$term',class = '$class',arm = '$arm',stud_id = '$stud',dateadded = '$date' where stud_id = '$stud'";
		$savecom = mysql_query($qry2) or die(mysql_error()); //na here
		return '<font color="#006600" size="-1">The result was Commented on,  ' .$olddate.  'now updated</font>';
    }
}
           

	//------------------------================end of principal's comment===============-------------------------- 
	
	//------------------------================beginning of  comment teacher's===============-------------------------- 
	 
function teachercomment()
{
	$stud = $_POST['stud'];
	$class = $_POST['class'];
	$arm = $_POST['arm'];
	$session = $_POST['session'];
	$term = $_POST['term'];
	
	$neat = $_POST['neat'];
	$pun = $_POST['pun'];
	$obed = $_POST['obed'];
	$rwithstud= $_POST['rwithstud'];
	$relia = $_POST['relia'];
	$attent = $_POST['attent'];
	$init = $_POST['init'];
	$scon = $_POST['scon'];
	$sor = $_POST['sor'];
	$soc = $_POST['soc'];
	
	$ft1 = $_POST['ft1'];
	$ft2 = $_POST['ft2'];
	
	$date =  date("l, F d, Y h:i" ,time());
	
	//echo $neat;
	$qry1 = "SELECT * FROM tblcomment WHERE stud_id = '$stud' AND session = '$session' AND term ='$term' AND class='$class' AND arm = '$arm'";
	
	$savecom1 = mysql_query($qry1) or die(mysql_error()); //na here
	
	
	$result = mysql_fetch_array($savecom1);
	$olddate= $result['dateadded'];
	$row_num = mysql_num_rows($savecom1);
	
	if($row_num == 0)
	{
		$qry = "INSERT INTO tblcomment (id,neat,pun,obed,rwithstud,relia,attent,init,scon,sor,soc,ft1,ft2,session,term,class,arm,stud_id,dateadded) VALUES('','$neat', '$pun','$obed','$rwithstud','$relia','$attent','$init','$scon','$sor','$soc','$ft1','$ft2','$session','$term','$class','$arm','$stud','$date')";
	
	
	$savecom = mysql_query($qry) or die(mysql_error()); //na here

   return '<font color="#006600" size="-1">Comment is added successfully.</font>';
	}
    else
	{
		$qry2 = "UPDATE tblcomment SET neat='$neat',pun='$pun',obed='$obed',rwithstud='$rwithstud',relia ='$relia',scon ='$scon',sor = '$soc',soc ='$soc',ft1 = '$ft1',ft2 = '$ft2',session = '$session',term ='$term',class = '$class',arm = '$arm',stud_id = '$stud',dateadded = '$date' where stud_id = '$stud'";
		
		$savecom = mysql_query($qry2) or die(mysql_error()); //na here
		return '<font color="#006600" size="-1">The result was Commented on,  ' .$olddate.  '   now updated</font>';
    }
}
//------------------------================end of teacher's comment===============-------------------------- 
	 
	 
	 //emergency result update    
	
	public function emergencyScoreUpdate()
	{
		$stud = addslashes($_POST['username']);
		$name = strtoupper($_POST['name']);
		$classname = $_POST['classname'];
		$arm = $_POST['arm'];
		
		if(empty($stud))
		{
			return '<font color="#FF0000" size="-2">Please enter student\'s username</font>';
		}
		if(empty($name))
		{
			return '<font color="#FF0000" size="-2">Please enter student\'s name</font>';
		}
		if(empty($classname))
		{
			return '<font color="#FF0000" size="-2">Please select student\'s classname</font>';
		}
		if(empty($arm))
		{
			return '<font color="#FF0000" size="-2">Please select student\'s class arm</font>';
		}
		
		$onterm = "SECOND";
		$onsession="2011/2012";
		
		for($i=1; $i<=20; $i++)
		{
				$subject = strtoupper($_POST['sub'.$i]);
				
				if(empty($subject))
				{
					continue;
				}
				
				$fo1 = $_POST['sub'.$i.'fo1'];
				$fo2 = $_POST['sub'.$i.'fo2'];
				$exam = $_POST['sub'.$i.'fo3'];
				
				$total=$fo1+$fo2+$exam;
				
				
					$sql = mysql_query("SELECT * FROM tblreportcard WHERE stud_id='$stud' AND class ='$classname' AND subject = '$subject' AND arm = '$arm' AND term='$onterm' AND session='$onsession'") or die(mysql_error());
					$no_rows = mysql_num_rows($sql);
				
				//if no such record insert else update
				if ($no_rows == 0) 
				{
					$query="INSERT INTO kctemptblreportcard(id,name,stud_id,subject,session,term,class,arm,formorder1,formorder2,exam,total,daterecord)
						VALUES('', '$name','$stud', '$subject', '$onsession', '$onterm', '$classname', '$arm', '$fo1','$fo2','$exam','$total','".time()."')";
						
						//return $query;
						$result = mysql_query($query) or die(mysql_error());
						
				}
				else
				{
					$query="UPDATE kctemptblreportcard SET formorder1='$fo1',formorder2='$fo2',exam='$exam',total='$total',daterecord='".time()."' WHERE stud_id='$stud' AND subject = '$subject' AND class ='$classname' AND arm = '$arm' AND term='$onterm' AND session='$onsession'";
						
						//return $query;
						$result = mysql_query($query) or die(mysql_error());
				}
				
			}//end for loop
			
			$this->audit->audit_log("Admin ".$_SESSION['username']." updated result for class ".$name." in ".$classn." ".$arm);
			return '<font color="#006600" size="-2">Score was updated successfully for <strong>'.$name.'</strong></font>';
				
				
	 }//end addMultiscore temporary
			
	
function subjectscorehighest($subject,$class,$arm,$onsession,$onterm)
	{
	  if ($onterm == 'FIRST' || $onterm =='SECOND')
	  {
		$qry="SELECT  MAX(total) as highest FROM tblreportcard WHERE subject='$getsubject' and arm ='$arm' and session='$onsession' and term='$onterm' and class='$class'";
		 
		 $res=$this->db->fetchData($qry);
		 
		  return $res['highest'];
	  }
	  else
	  {
				 
	 $qry="SELECT  MAX(sessionaverage) as highest FROM tblreportcard WHERE subject='$subject' and arm ='$arm' and session='$onsession' and term='THIRD' and class='$class'";
		 
		 $res=$this->db->fetchData($qry);
		 
		  return $res['highest'];
		
	  }
	}
	
	function subjectave($getsubject,$class,$arm,$onsession,$onterm)
	{
		if ($onterm == 'FIRST' || $onterm =='SECOND')
	  {
	 $qry =" SELECT ROUND(AVG(sessionaverage)) AS subaverage FROM  tblreportcard WHERE subject='$getsubject' and arm ='$arm' and session='$onsession' and term='$onterm' and class='$class'";
	 	 	 
		$res=$this->db->fetchData($qry);
	  	return $res['subaverage'];
	  }
	  else
	  {
		  $qry =" SELECT ROUND(AVG(sessionaverage)) AS subaverage FROM  tblreportcard WHERE subject='$getsubject' and arm ='$arm' and session='$onsession' and term='THIRD' and class='$class'";
	 	 	 
		$res=$this->db->fetchData($qry);
	  	return $res['subaverage'];
	  }
	}
			
	function getgrade($gettotal)
	{
		if(empty($gettotal))
		return "F9";
	//'A:75% and above, B2:70%-74%, B3:65%-69%, C4:60%-64%, C5:55%-59%, C6:50%-54%, D7:45%-49%, E8:40%-44%,F9:0%-39%;
	switch ($gettotal) {
    case ($gettotal >= 75):
        return "A1";
        break;
    case ($gettotal >= 70 && $gettotal <= 74):
        return "B2";
        break;
    case ($gettotal >= 65 && $gettotal <= 69):
        return "B3";
        break;
	 case ($gettotal >= 60 && $gettotal <= 64):
       return "C4";
       break;
	   case ($gettotal >= 55 && $gettotal <= 59):
        return "C5";
        break;
		case ($gettotal >= 50 && $gettotal <= 54):
        return "C6";
        break;
		case ($gettotal >= 45 && $gettotal <= 49):
        return "D7";
        break;
		case ($gettotal >= 40 && $gettotal <= 44):
        return "D8";
        break;
		case ($gettotal < 40):
        return "F9";
		case ($gettotal == 0):
        return "-";
        break;
   }
	
}


function getgradejnr($gettotal)
	{	
	// A : 70% and Above,  C:55%-69% P:40%-54% F:below 40%
	 
	if ($gettotal >= 70 && $gettotal <=100)
    {
	return "A";
	}
    elseif($gettotal >= 55 && $gettotal <= 69){
        return "C";
	}
    elseif ($gettotal >= 40 && $gettotal <= 54){
        return "P";
	}
	elseif ($gettotal >= 0 && $gettotal < 40){
       return "F";
	}
	
}
	//////////new
 public function getAllCorrect($studid,$onsession,$onterm,$subject)
	 {
		
		
		 $qry="SELECT * FROM tblreportcard WHERE stud_id='$studid' and subject = '$subject' AND term='$onterm' AND session='$onsession'";
		 
		 $res=$this->db->fetchData($qry);
		 
		 return $res['formorder1']."_".$res['formorder2']."_".$res['exam']."_".$res['total'];
	 }//end getAllCorrect();
	 
	 
	 public function correctUpdateReport($username,$session,$term)
	{
		
		$name=$this->util->getStudentName($username);
		
		//capture each subjects id from checkbox
		$arraySubject = $_POST['list'];
		
		$onsession = $session;
		$onterm = $term;
		
		if(count($arraySubject) == 0)
		{
			return '<font color="#FF0000" size="-2">Please select at least 1 subject</font>';
		}
			
			$num = 0;
			foreach($arraySubject as $subj)
			{
				
				$subject = base64_decode($subj);
				
				$formorder1 = $_POST[$subj."_1"];
				$formorder2 = $_POST[$subj."_2"];
				$exam = $_POST[$subj."_3"];
				$total = $formorder1 + $formorder2 + $exam;
				
				$num++;
				
					$sq="SELECT * FROM tblreportcard WHERE stud_id='$username' AND subject = '$subject' AND term='$onterm' AND session='$onsession'";
					//return $sq." here";
					$sql = mysql_query($sq) or die(mysql_error());
					$no_rows = mysql_num_rows($sql);
				
				//if no such record insert else update
				if ($no_rows > 0) 
				{
					$query="UPDATE tblreportcard SET formorder1='$formorder1', formorder2='$formorder2',exam='$exam',total='$total',daterecord='".time()."' WHERE stud_id='$username' AND subject='$subject' AND term='$onterm' AND session='$onsession'";
						
				//return $query;	
					$result = mysql_query($query) or die(mysql_error());
					$this->audit->audit_log("Admin ".$_SESSION['username']." updated ".$username."(".$name.") result for session ".$session." and term ".$onterm);
				}
				
			}//end for each
			
			
			return '<font color="#006600" size="-2">'.$onterm.' TERM '.$onsession.' Session Result was updated successfully for '.$username.'</font>';
				
				
	 }//end correctupresult
	
	
	
public function getposition($class,$arm,$session,$term)	
{	
	
 $sqlstudid = "SELECT distinct stud_id FROM tblreportcard WHERE class ='$class' AND arm = '$arm' AND session = '$session' AND term = 						'$term' order by  stud_id asc";
	$restudid = mysql_query($sqlstudid) or die( "Could not execute sql: $sql1");
	
	
	while($r = mysql_fetch_array($restudid))
	{
	$fulltotal = 0;
	
	$stud_id= $r['stud_id'];

	$sqlpstn = "SELECT * FROM tblreportcard WHERE stud_id = '$stud_id' and session = '$session' AND term = '$term'";
	$resultpstn = mysql_query($sqlpstn) or die( "Could not execute sql: $sql1");
	
	$num = mysql_num_rows($resultpstn);

	while($rsttl = mysql_fetch_array($resultpstn))
	{
	$fulltotal = $fulltotal + $rsttl['total'];
	
	}
	
	
		
$sqlcheck = "SELECT * from tblposition WHERE stud_id = '$stud_id' and class = '$class' and arm ='$arm' and session = '$session' AND term = '$term'";
	 $resultcheck = mysql_query($sqlcheck) or die(mysql_error());
	 
	 
	 $numcheck = mysql_num_rows($resultcheck);
	// echo $numcheck;
	if ($numcheck != 0)
	{
	    $qryupdate="UPDATE tblposition SET fulltotal = '$fulltotal' WHERE stud_id = '$stud_id' and class = '$class' and arm ='$arm' and session = '$session' AND term = '$term'";
		$resultupdate = mysql_query($qryupdate) or die(mysql_error());
					
	}
	 else
	{
$queryinsert="INSERT INTO tblposition(id,stud_id,class,arm,session,term,fulltotal,sessiontotal,position)VALUES('','$stud_id','$class','$arm','$session','$term','$fulltotal','','$position')";
		$resultinsert = mysql_query($queryinsert) or die(mysql_error());
							
	}


	
 if($term == "THIRD")	
	{ 
		$alltotal = $this->getTotalScoresInSession($class,$arm,$session,$stud_id);
	}
 
	    $qryupdatethird="UPDATE tblposition SET  sessiontotal = '$alltotal' WHERE stud_id = '$stud_id' and session = '$session' AND term = 'THIRD'";
		$resultupdate = mysql_query($qryupdatethird) or die(mysql_error());
		
	}
	
}
	    
	 

public	function getTotalTerm($class,$arm,$onsession,$term,$stud_id)
	{

		$firsttermstotal =$this->getTotalScoresPerTerm($class,$arm,$onsession,'FIRST',$stud_id);
		$secondtermtotal = $this->getTotalScoresPerTerm($class,$arm,$onsession,'SECOND',$stud_id);
		$thirdtermtotal = $this->getTotalScoresPerTerm($class,$arm,$onsession,'THIRD',$stud_id);
		$sessiontotal = $firsttermstotal + $secondtermtotal + $thirdtermtotal;
		
		return $sessiontotal;
		
	}
public	function getTotalScoresPerTerm($class,$arm,$onsession,$term,$stud_id)
	{
$sqlcheckt = "SELECT * from tblposition WHERE stud_id = '$stud_id' and class = '$class' and arm ='$arm' and session = '$onsession' AND term = '$term'";
	 $res=$this->db->fetchData($sqlcheckt);
	 
	  return $res['fulltotal'];
	}

public	function getTotalScoresInSession($class,$arm,$session,$stud_id)
	{
     $sqlgetall = "SELECT * from tblreportcard WHERE stud_id = '$stud_id' and class = '$class' and arm ='$arm' and session = '$session'";
	 $allscores = mysql_query($sqlgetall) or die( "Could not execute sql: $sqlgetall");
	 
	 $fulltotal = 0;
	 while($score = mysql_fetch_array($allscores))
		{
			$fulltotal = $fulltotal + $score['total'];
		}
		
	 
	  return $fulltotal;
	}

// process  average for all subjects taken by a student  in the session
public function procesSessionAverage($class,$arm,$session,$term)	
{	
	
 	$sqlstudid = "SELECT  *  FROM tblstudent WHERE class ='$class' AND arm = '$arm'";
	$restudid = mysql_query($sqlstudid) or die( "Could not execute sql: $sqlstudid");
	
	while($r = mysql_fetch_array($restudid))
	{
	
	$stud_id= $r['stud_id'];
	
$sqlallsub = "SELECT distinct subject FROM tblreportcard WHERE stud_id = '$stud_id' and class = '$class' and arm = '$arm' and session = '$session' order by subject asc";
	$resultallsub = mysql_query($sqlallsub) or die( "Could not execute sql: $sqlallsub");
	 while($onesubject = mysql_fetch_array($resultallsub))
		{
		$fulltotal = 0;
		$avescore = 0;
		$num = 0;	
	$subject = 	$onesubject['subject'];
	$sqlpsub = "SELECT * FROM tblreportcard WHERE stud_id = '$stud_id' and class = '$class' and arm = '$arm'  and subject = '$subject' and session = '$session'";
	$resultsub = mysql_query($sqlpsub) or die( "Could not execute sql: $sqlpsub");
	
	//$num = mysql_num_rows($resultsub);
	  while($rscore = mysql_fetch_array($resultsub))
		{
		if($rscore['total'] == 0 || $rscore['total']=="")
			{ 
			 continue ;
			}
			else
			{
			 $num++;	
			$fulltotal = round($fulltotal + $rscore['total']);	
			}
		}// 3 end of while 
		
		if ($num != 0 )
		{
	   		$avescore = round(($fulltotal / $num)); 
		} 
		
		
  $qryupdatethird="UPDATE tblreportcard SET  sessionaverage = '$avescore' WHERE stud_id = '$stud_id' and session = '$session' AND term = 'THIRD' and class = '$class' and arm = '$arm' and subject = '$subject'";
		$resultupdate = mysql_query($qryupdatethird) or die( "Could not execute sql: $qryupdatethird");
	
		}// 2 end of while
		 
	}// 1  end of while
  }
	}	

?>