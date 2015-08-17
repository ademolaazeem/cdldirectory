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
	global $header;
	global $header2;
	global $header3;
	global $header4;
	
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

        $this->Cell(55,7,$header1[0],1,0,'C',1);
        $this->SetFont('Times','',8);

       
        // send the headers to the PDF document

        for($i=0;$i<count($header);$i++)

        $this->Cell(7,7,$header[$i],1,0,'C',1);
        
	    $this->SetFont('Times','B',8);

        $this->Cell(12,7,$header2[0],1,0,'C',1);
	$this->Cell(8,7,$header3[0],1,0,'C',1);
	$this->Cell(8,7,$header4[0],1,0,'C',1);
	
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






function BuildTable($name,$data,$totalscore,$avescore, $subjno) {

                
	    $this->SetFillColor(252,252,252);

        $this->SetTextColor(0);

        $this->SetDrawColor(128,0,0);

        $this->SetLineWidth(.1);

		$this->SetDrawColor(0);


        $this->SetFont('Times','B',8);

        $this->Cell(55,7,$name[0],1,0,'L',1);

        $this->SetFillColor(252,252,252);

        $this->SetTextColor(0);

        $this->SetDrawColor(128,0,0);

        $this->SetLineWidth(.1);

		$this->SetDrawColor(0);


        $this->SetFont('Times','B',8);

       
        // send the headers to the PDF document

        for($i=0;$i<count($data);$i++)
		
		if ($data[$i]< 50)
		{
		$this->SetTextColor(237,3,68);
        $this->Cell(7,7,$data[$i],1,0,'C',1);
		}
       	else
		{
		$this->SetTextColor(0);
        $this->Cell(7,7,$data[$i],1,0,'C',1);
		}
		$this->SetTextColor(0);
        $this->Cell(12,7,$subjno[0],1,0,'C',1);
		$this->Cell(8,7,$totalscore[0],1,0,'C',1);
		$this->Cell(8,7,$avescore[0],1,0,'C',1);
        $this->Ln();
	
}
	
	
	



}// end of CLASS

?>