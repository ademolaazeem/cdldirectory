<?php
//*****************************************
//* MyDate Class to handle date/time matters
//* Coded by: Oluwatosin M. Adesanya
//* Date: 23rd July, 2009.
//**************************************
class MyDate
{
	var $numofyrs;
	public function MyDate($numofyrs)
	{
		$this->numofyrs=$numofyrs;
	}
	//receives a time stamp as argument	
	public function formatDate($ts)
	{
		return date("d-M-Y g:i A",$ts);
	}
	
	//the argument this function receives is a PHP
	//date in this format HisdmY
	//otherwise it may not work.
	public function getTimeStamp($dt)
	{
		//$dt=date("HisdmY");
		//print $dt;
		$hr=substr($dt,0,2);
		//print $sec;
		$min=substr($dt,2,2);
		//print $min;
		$sec=substr($hr,4,2);
		//print $hr;
		$day=substr($dt,6,2);
		//print $day;
		$mon=substr($dt,8,2);
		//print $mon;
		$yr=substr($dt,10,4);
		//print $yr;
		$ts=mktime($hr,$min,$sec,$mon,$day,$yr);
		//print $ts;
		return $ts;
	}
	
	private function getFutureDateByYear()
	{
		//returns a timestamp
		return mktime(0,0,0,date("m"),date("d"),date("Y")+$this->numofyrs);
	}
	
	public function getFutureMonth()
	{
		return date("m",$this->getFutureDateByYear());
	}
	
	public function getFutureYear()
	{
		return date("y",$this->getFutureDateByYear());
	}
	
	public function getDateSlashStyle($ts)
	{
		return date("d/m/Y ",$ts);
	}
	
	public function getDateShortestStyle($ts)
	{
		return date("d/m/y ",$ts);
	}
	
	public function getDateLongStyle($ts)
	{
		return date("d F, Y ",$ts);
	}
	
	public function getDateForPassport($ts)
	{
		return date("d M y ",$ts);
	}
	
	
	public function getReminder($val)
	{
		switch($val)
		{
			case "3d": //3days
				$reminder=86400; 
				break;
			case "1w": //1 Week
				$reminder=345600; 
				break;
			case "2w": //2 Weeks
				$reminder=864000; 
				break;
			case "1m":
				$reminder=1728000; 
				break;
			case "3m":
				$reminder=2592000; 
				break;
			case "6m":
				$reminder=2592000; 
				break;
			case "1y":
				$reminder=2592000; 
				break;
			case "2y":
				$reminder=2592000; 
				break;
		}
		return $reminder;
	}
	
	function getTimeLeft($tmstmp)
	{
		$today=mktime(0,0,0,date("m"),date("d"),date("Y"));
		$tm=$tmstmp-$today;
		$tm = ceil($tm/86400);
		if($tm<0)
			$msg = "<font color='red'>Already Expired</font>";
		else if($tm==1)
			$msg = "Tomorrow";
		else if($tm==0)
			$msg = "Today";
		else if($tm==7)
			$msg = "1 week";
		else if($tm==14)
			$msg = "2 weeks";
		else if($tm==21)
			$msg = "3 weeks";
		else if($tm==30)
			$msg = "1 month";
		else if($tm > 30) {
			$numofmonths=floor($tm/30);
			$rem=$tm%30;
			if($numofmonths > 1)
				$msg=$numofmonths." months ";		
			else
				$msg=$numofmonths." month";
				
			if($rem > 0){ 
				if($rem > 1)
					$msg.=$rem." days";
				else
					$msg.=$rem." day";				
			}
		}			
		else
			$msg = $tm." days";			
		return $msg;					
	}
	
	
}

?>
