<?php
		require_once("DBDirect.php");
		require_once('audit.php');
		require_once('Utilities.php');
		require_once('ResultManager.php');

class MeritManager
{
	private $db, $audit,$util,$result;
	
	function __construct()
	{
		$this->db = new DBConnecting();
		$this->audit = new AuditLog();
		$this->util = new Utilities();
		$this->result = new ResultManager();
	} 
	
	public function getbest10($class,$session,$term)
	{
		if($class=="SS1" || $class=="SS2" || $class=="SS2")
		{
			return $this->getbest10senior($class,$session,$term);
		}
		
		if($class=="JSS1" || $class=="JSS2" || $class=="JSS3")
		{
			return $this->getbest10junior($class,$session,$term);
		}
	}
	
	public function getbest10junior($class,$session,$term)
	{
		//if done return 1
		$qry= "select * from tblstudent where class='$class'";
		$res=mysql_query($qry);
		
		$alldone=0;
			while($response=mysql_fetch_array($res))
			{ 
				
				//get it student 1 by 1
				$studid=$response['stud_id'];
				$qryst="select * from tblreportcard where stud_id='$studid' and session='$session' and term='$term'";
				$rs=mysql_query($qryst);
				$totalpoints=0;
				$allgrades="";
				$totsubj=0;
				$arm="";
				$a=0;$c=0;$p=0;$f=0;
				$done1=false;
				$allscorestotal=0;
				while($row=mysql_fetch_array($rs))
				{
					//loop 2tru student score to get grades
					$arm=$row['arm'];
						$allscorestotal+=$row['total'];
						$grade = $this->result->getgradejnr($row['total']);
						$totalpoints += $this->getjuniorgrade($grade, strtoupper($row['subject']));
						
						if($grade=="A")
						$a+=1;
						if($grade=="C")
						$c+=1;
						if($grade=="P")
						$p+=1;
						if($grade=="F")
						$f+=1;
					
					//total subject
					$totsubj++;
					
					$done1=true;
					
				}//end while getting stud subject report
			
				
					if($a!=0)
					{
						$allgrades.=$a."(A) ";
					}
					if($c!=0)
					{
						$allgrades.=$c."(C) ";
					}
					if($p!=0)
					{
						$allgrades.=$p."(P) ";
					}
					if($f!=0)
					{
						$allgrades.=$f."(F) ";
					}
			
				
				if($done1==true)
				{
					//check if the record exist
					$sle="select * from tblbest10 where stud_id='$studid' AND class='$class' AND session='$session' AND arm='$arm'";
					$numrow=$this->db->getNumOfRows($sle);
					$fetch=$this->db->fetchData($sle);
					
					if ($totsubj!=0)
					{
					$avescore = number_format(($allscorestotal/$totsubj),2,'.','');
					}
					//if found get id
					$curid=$fetch['id'];
					//insert check for student record before insert
					$insQry="";
					if($numrow==0)
					{
						$insQry="INSERT INTO tblbest10 (id,stud_id,class,arm,session,term,totalpoint,grades,noofsubject,allscoretotal,avescore)
					 VALUE ('','$studid','$class','$arm','$session','$term',$totalpoints,'$allgrades',$totsubj,$allscorestotal,$avescore)";
					}
					else
					{
						//update
						$insQry="UPDATE tblbest10 SET totalpoint=$totalpoints, grades='$allgrades', noofsubject=$totsubj,allscoretotal=$allscorestotal, avescore = $avescore WHERE id=$curid AND stud_id='$studid'";
					}
					if($r1=$this->db->executeQuery($insQry))
					$alldone++;
					
				}
				
			}//end while getting each student
			
			if($alldone !=0 )
			{
				return 1;
			}
			else return 0;
	}
	
	public function getbest10senior($class,$session,$term)
	{
		//if done return 1
		$qry= "select * from tblstudent where class='$class'";
		$res=mysql_query($qry);
		
		$alldone=0;
		while($response=mysql_fetch_array($res))
		{
			$alldone++;
			//get it student 1 by 1
			$studid=$response['stud_id'];
			$qryst="select * from tblreportcard where stud_id='$studid' and session='$session' and term='$term'";
			$rs=mysql_query($qryst);
			$totalpoints=0;
			$allgrades="";
			$totsubj=0;
			$arm="";
			$a1=0;$b2=0;$b3=0;$c4=0;$c5=0;$c6=0;$d7=0;$e8=0;$f9=0;
			$done1=false;
			$allscorestotal=0;
			while($row=mysql_fetch_array($rs))
			{
				//loop 2tru student score to get grades
				$allscorestotal+=$row['total'];
					$grade = $this->result->getgrade($row['total']);
					$totalpoints += $this->getseniorgrade($grade, strtoupper($row['subject']));
					
					if($grade=="A1")
					$a1+=1;
					if($grade=="B2")
					$b2+=1;
					if($grade=="B3")
					$b3+=1;
					if($grade=="C4")
					$c4+=1;
					if($grade=="C5")
					$c5+=1;
					if($grade=="C6")
					$c6+=1;
					if($grade=="D7")
					$d7+=1;
					if($grade=="E8")
					$e8+=1;
					if($grade=="F9")
					$f9+=1;
					
					$arm=$row['arm'];
					
					$done1=true;
					
					//total subject
				$totsubj++;
				}//end while all subject for that student
				
				
				
					if($a1!=0)
					{
						$allgrades.=$a1."(A1) ";
					}
					if($b2!=0)
					{
						$allgrades.=$b2."(B2) ";
					}
					if($b3!=0)
					{
						$allgrades.=$b3."(B3) ";
					}
					if($c4!=0)
					{
						$allgrades.=$c4."(C4) ";
					}
					if($c5!=0)
					{
						$allgrades.=$c5."(C5) ";
					}
					if($c6!=0)
					{
						$allgrades.=$c6."(C6) ";
					}
					if($d7!=0)
					{
						$allgrades.=$d7."(D7) ";
					}
					if($e8!=0)
					{
						$allgrades.=$e8."(E8) ";
					}
					if($f9!=0)
					{
						$allgrades.=$f9."(F9) ";
					}
				
				if($done1==true)
				{
					//check if the record exist
					$sle="select * from tblbest10 where stud_id='$studid' AND class='$class' AND session='$session' AND arm='$arm'";
					$numrow=$this->db->getNumOfRows($sle);
					$fetch=$this->db->fetchData($sle);
					if ($totsubj!=0)
					{
						//number_format($number, 2, '.', '');
					$avescore = number_format(($allscorestotal/$totsubj),2,'.','');
					}
					//if found get id
					$curid=$fetch['id'];
					//insert check for student record before insert
					$insQry="";
					if($numrow==0)
					{
						$insQry="INSERT INTO tblbest10 (id,stud_id,class,arm,session,term,totalpoint,grades,noofsubject,allscoretotal,avescore)
					 VALUE ('','$studid','$class','$arm','$session','$term',$totalpoints,'$allgrades','$totsubj','$allscorestotal',$avescore)";
					
					}
					else
					{
						//update
						$insQry="UPDATE tblbest10 SET totalpoint=$totalpoints,grades='$allgrades', noofsubject=$totsubj,allscoretotal=$allscorestotal, avescore = $avescore WHERE id=$curid AND stud_id='$studid'";
					}
					//return $insQry;
					if($r1=$this->db->executeQuery($insQry))
					$alldone++;
					
				}
			}//goin to next student
		
		if($alldone !=0 )
		{
			return 1;
		}
		else return 0;
	}
	
	function getseniorgrade($grade,$subject)
	{	
		switch ($grade)
		{
			case ($grade == "A1"):
				if($subject=="ENGLISH LANGUAGE" || $subject=="MATHEMATICS")
				{ return 18; }
				else return 16;
				break;
			
			case ($grade == "B2"):
				return 14;
				break;
			
			case ($grade == "B3"):
				return 12;
				break;
				
			case ($grade == "C4"):
				return 10;
				break;
				
			case ($grade == "C5"):
				return 8;
				break;
				
			case ($grade == "C6"):
				return 6;
				break;
				
			case ($grade == "D7"):
				return 4;
				break;
				
			case ($grade == "E8"):
				return 2;
				break;
			
			case ($grade == "F9"):
				return 0;
				break;
   		}
	}
	
	function getjuniorgrade($grade,$subject)
	{	
		switch ($grade)
		{
			case ($grade == "A"):
				if($subject=="ENGLISH LANGUAGE" || $subject=="MATHEMATICS")
				{ return 8; }
				else return 6;
				break;
			
			case ($grade == "C"):
				return 4;
				break;
			
			case ($grade == "P"):
				return 2;
				break;
				
			case ($grade == "F"):
				return 0;
				break;
				
			
   		}
	}
	
	
	//generate best subjects
	public function getSubjectBest($class,$session,$term)
	{
		//if done return 1
		$qry= "select * from tblstudent where class='$class'";
		$res=mysql_query($qry);
		
		while($response=mysql_fetch_array($res))
		{ 
				
				//get it student 1 by 1
				$studid=$response['stud_id'];
				$qryst="select * from tblstudsubject where stud_id='$studid' and session='$session'";
				$rs=mysql_query($qryst);
				
				while($row=mysql_fetch_array($rs))
				{
					$subject = $row['subject'];
					$arm = $row['arm'];
					
					$firstterm100 = $this->getTermTotal($studid,$session,"FIRST",$subject);
					$secondterm100 = $this->getTermTotal($studid,$session,"SECOND",$subject);
					$thirdterm100 = $this->getTermTotal($studid,$session,"THIRD",$subject);
						
					$Conver20 = round(($firstterm100/100) * 20);
					
					$Conver30 = round(($secondterm100/100) * 30);
					
					$Conver50 = round(($thirdterm100/100) * 50);
					
					$firstsecond50 = $Conver20 + $Conver30;
					
					$alltotal100 = $Conver20 + $Conver30 + $Conver50;
					//check if the record exist
					$sle="select * from tblsuboverall where stud_id='$studid' AND subject='$subject' AND session='$session'";
					$numrow=$this->db->getNumOfRows($sle);
					$fetch=$this->db->fetchData($sle);
					//if found get id
					$curid=$fetch['id'];
					
					
					//insert check for student record before insert
					$insQry="";
					if($numrow==0)
					{
						$insQry="INSERT INTO tblsuboverall (id,stud_id,subject,firstterm20,secondterm30,thirdterm50,firstsecondtotal50,alltotal100,session,class,arm) VALUE ('','$studid','$subject','$Conver20','$Conver30','$Conver50','$firstsecond50',$alltotal100,'$session','$class','$arm')";
					}
					else
					{
						//update
						$insQry="UPDATE tblsuboverall SET firstterm20=$Conver20, secondterm30=$Conver30,thirdterm50=$Conver50,firstsecondtotal50=$firstsecond50,alltotal100=$alltotal100 WHERE id=$curid AND stud_id='$studid' AND subject='$subject'";
					}
					
					$r1=$this->db->executeQuery($insQry);
					
					
					
				}//FIRST WHILE
				
			}//end while getting each student
			
			return 1;
	}
	
	public function getTermTotal($studid,$onsession,$onterm,$subject)
	 {
		 $qry="SELECT * FROM tblreportcard WHERE stud_id='$studid' and subject = '$subject' and session='$onsession' and term='$onterm'";

		 $res=$this->db->fetchData($qry);
		 
		 return $res['total'];
	 }
	 
	 public function getBestInSubject($subject,$class,$session,$term)
	 {
		 //studid,class,arm,score
		 $fullsql="";
		
		if($term=="FIRST")
		{
			$fullsql="select * from tblsuboverall where firstterm20=(select max(firstterm20) from tblsuboverall where subject='$subject' and class='$class' and session='$session' and firstterm20!=0) and class='$class' and subject='$subject' and session='$session' and firstterm20!=0";
			
			$dat = $this->db->fetchData($fullsql);
		
			$alldata = $dat['stud_id']."_".$dat['firstterm20']."_".$dat['class']." ".$dat['arm'];
		
			return $alldata;
		}
		if($term=="SECOND")
		{
			$fullsql="select * from tblsuboverall where secondterm30=(select max(secondterm30) from tblsuboverall where subject='$subject' and class='$class' and session='$session' and secondterm30!=0) and class='$class' and subject='$subject' and session='$session' and secondterm30!=0";
			
			$dat = $this->db->fetchData($fullsql);
		
			$alldata = $dat['stud_id']."_".$dat['secondterm30']."_".$dat['class']." ".$dat['arm'];
		
			return $alldata;
		}
		if($term=="THIRD")
		{
			$fullsql="select * from tblsuboverall where thirdterm50=(select max(thirdterm50) from tblsuboverall where subject='$subject' and class='$class' and session='$session' and thirdterm50!=0) and class='$class' and subject='$subject' and session='$session' and thirdterm50!=0";
			
			$dat = $this->db->fetchData($fullsql);
		
			$alldata = $dat['stud_id']."_".$dat['thirdterm50']."_".$dat['class']." ".$dat['arm'];
		
			return $alldata;
		}
		if($term=="FIRSTSECOND")
		{
			$fullsql="select * from tblsuboverall where firstsecondtotal50=(select max(firstsecondtotal50) from tblsuboverall where subject='$subject' and class='$class' and session='$session' and firstsecondtotal50!=0) and class='$class' and subject='$subject' and session='$session' and firstsecondtotal50!=0";
			
			$dat = $this->db->fetchData($fullsql);
		
			$alldata = $dat['stud_id']."_".$dat['firstsecondtotal50']."_".$dat['class']." ".$dat['arm'];
		
			return $alldata;
		}
		if($term=="all")
		{
			$fullsql="select * from tblsuboverall where alltotal100=(select max(alltotal100) from tblsuboverall where subject='$subject' and class='$class' and session='$session' and alltotal100!=0) and class='$class' and subject='$subject' and session='$session' and alltotal100!=0";
			
			$dat = $this->db->fetchData($fullsql);
		
			$alldata = $dat['stud_id']."_".$dat['alltotal100']."_".$dat['class']." ".$dat['arm'];
		
			return $alldata;
		}
		
		
	 }
}