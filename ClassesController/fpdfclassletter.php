<?php

 require_once("../ClassesController/fpdf/fpdf.php"); 
  
	 
 class myPDF extends FPDF {
      
          
/*function Header() {

       
       $this->SetFont('Times','B',12);

        $w = $this->GetStringWidth($this->sch)+130;

        $this->SetDrawColor(0,0,180);

        $this->SetFillColor(255,255,255);

        $this->SetTextColor(17,55,6);
				
        $this->Cell($w,9,$this->sch,0,1,'C');

        $this->Ln(5);
		
        }*/

function Schheader($schl) {
 		$this->SetFont('Times','B',14);

        $this->SetDrawColor(0,0,180);

        $this->SetFillColor(255,255,255);

        $this->SetTextColor(17,55,6);
        $i=0;
        foreach($schl as $sch)
		
        $this->Cell(200,7,$sch[0],0,1,'C');
		
		$this->SetFont('Times','B',9);

        $this->SetDrawColor(0,0,180);

        $this->SetFillColor(255,255,255);

        $this->SetTextColor(17,55,6);

        $this->Cell(200,7,$sch[1],0,1,'C');
}

function letterTitle($headtitle)
{
	$this->SetFont('Times','B',9);

        $this->SetDrawColor(0,0,180);

        $this->SetFillColor(255,255,255);

        $this->SetTextColor(17,55,6);

        $this->Cell(200,7,$headtitle[0],0,1,'C');
}

function Studname($name) {

        $this->SetFillColor(255,255,255);
        $this->SetTextColor(0);
        $this->SetFont('','B',8);

        for($i=0;$i<count($name);$i++)
        $this->Cell(10,7,$name[$i],0,1,'l');
		$this->Ln(5);
		
        $this->Ln(5);
}


function Particulars($data) {

        //Color and font restoration

        $this->SetFillColor(248);

        $this->SetTextColor(0);

        $this->SetFont('Arial', '', 8);



        //now spool out the data from the $data array

        $fill=true; // used to alternate row color backgrounds

       foreach($data as $row)

        {

       
		
        //$this->ln(450);
        // flips from true to false and vise versa

       
		
		
		$this->SetFillColor(248);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 8);
		$this->Cell($w[0],6,$row[0],0,1,'L');

        $this->SetTextColor(0);

        $this->SetFont('Arial', '', 8);
	   	$this->Cell($w[1],6,$row[1],0,1,'L');
	   
	    $fill =! $fill;

        }

       // $this->Cell(array_sum($w),0,'','T');

        }



}// end of CLASS

?>