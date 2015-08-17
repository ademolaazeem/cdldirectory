<?php

 require_once("../ClassesController/fpdf/fpdf.php"); 
  
	 
class myPDF extends FPDF {
  
  function bHeader($sch,$classcontent) {

       
        $this->SetFont('Times','B',14);
        $this->SetDrawColor(0,0,180);

        $this->SetFillColor(255,255,255);

        $this->SetTextColor(17,55,6);
		
		$this->Cell(270,20,$sch[0],0,1,'C');

       	$this->Cell(270,0,$classcontent[0],0,1,'C');
		
		$this->Ln(45);


        }
  
  
  function Header()
{
	global $sch;
	global $classcontent;
	global $header1; 
	global $header2;
	global $header3;
	global $header4;
	global $header5;
	global $header6;
	global $header7;
	
	$this->SetFont('Times','B',18);
	$this->Cell(270,20,$sch[0],0,1,'C');
	$this->SetFont('Times','B',14);
	$this->Cell(270,0,$classcontent[0],0,1,'C');
	
	$this->Ln(10);
	
      //Colors, line width and bold font
	
		
	    $this->SetFillColor(252,252,252);

        $this->SetTextColor(0);

        $this->SetDrawColor(128,0,0);

        $this->SetLineWidth(.1);

		$this->SetDrawColor(0);


        $this->SetFont('Times','B',10);

        $this->Cell(8,7,$header1[0],1,0,'C',1);
        $this->Cell(30,7,$header2[0],1,0,'C',1);
		$this->Cell(105,7,$header3[0],1,0,'C',1);
		$this->Cell(30,7,$header4[0],1,0,'C',1);
		$this->Cell(20,7,$header5[0],1,0,'C',1);
		$this->Cell(35,7,$header6[0],1,0,'C',1);
		$this->Cell(25,7,$header7[0],1,0,'C',1);
        $this->Ln();

	
	
}
        





        //Page footer method

        function Footer()       {

        //Position at 1.5 cm from bottom

		 $this->SetTextColor(0);
        $this->SetY(-15);

        $this->SetFont('Arial','I',8);

        $this->Cell(0,10,'page footer -> Page '
		.$this->PageNo().'/{nb}',0,0,'C');
		
		

        }






function BuildTable($i,$stud_id,$name,$subjno,$totalarray,$ave,$avescore) {

                
	    $this->SetFillColor(252,252,252);

        $this->SetTextColor(0);

        $this->SetDrawColor(128,0,0);

        $this->SetLineWidth(.1);

		$this->SetDrawColor(0);


        $this->SetFont('Times','B',12);
        $h = 12;
        $this->Cell(8,$h,$i[0],1,0,'L',1);
		$this->Cell(30,$h,$stud_id[0],1,0,'L',1);
		$this->Cell(105,$h,$name[0],1,0,'L',1);
		$this->SetTextColor(0);
        $this->Cell(30,$h,$subjno[0],1,0,'C',1);
		$this->Cell(20,$h,$totalarray[0],1,0,'C',1);
		$this->Cell(35,$h,$ave[0],1,0,'C',1);
		$this->Cell(25,$h,$avescore[0],1,0,'C',1);
        $this->Ln();
	
}
	
	
	



}// end of CLASS

?>