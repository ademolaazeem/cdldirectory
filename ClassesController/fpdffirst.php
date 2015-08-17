<?php

 require_once("fpdf/fpdf.php");
 class myPDF extends FPDF {
    
        
function Header() {

       
       /* $this->SetFont('Times','B',14);

        $w = $this->GetStringWidth($this->sch)+50;

        $this->SetDrawColor(0,0,180);

        $this->SetFillColor(255,255,255);

        $this->SetTextColor(17,55,6);
		
		//$this->Image('ys.jpg',10,10,15,15);

        $this->Cell($w,9,$this->sch,0,1,'C');

        $this->Ln(5);
		
		$this->Cell(200,0,'REPORT SHEET',0,0,'C');
		*/
		//$this->Ln(5);
		
		
		
		//$this->SetXY(26,100);

		$this->Image('printbg.png',50,50,100,120);

		$this->SetY(35);


        }

        //Page footer method

        function Footer()       {

        //Position at 1.5 cm from bottom

        $this->SetY(-15);

        $this->SetFont('Arial','I',8);

        //$this->Cell(0,10,'page footer -> Page '

        //.$this->PageNo().'/{nb}',0,0,'C');

        }

function Listp($particulars)
{

	    $this->SetFillColor(248);
        $this->SetTextColor(0);
      	$this->SetFont('Arial','B',8);



        //now spool out the data from the $data array

        $fill=true; // used to alternate row color backgrounds

        foreach($particulars as $row)
        {

        $this->Cell($w[0],6,$row[0],'0',0,'L');

        // set colors to show a URL style link

        $this->SetTextColor(21);

        $this->SetFont('');
		$this->SetDrawColor(0);
		
		$this->SetFont('Arial','B',8);
		$this->SetX(80);
       
        $this->Cell($w[1],6,$row[1],'0',1,'L');

        // restore normal color settings for 

        $this->SetTextColor(21);
		
		$this->SetFont('Times','B',5);
		
		
        $this->Cell($w[2],6,$row[2],'0',0,'L');
		
		
		$this->SetTextColor(21);
		
		$this->SetFont('Times','B',5);
		
		$this->SetX(40);

        $this->Cell($w[3],6,$row[3],'0',0,'L');
		$this->SetTextColor(21);
		
		$this->SetFont('Times','B',6);
		
		$this->SetX(70);

        $this->Cell($w[4],6,$row[4],'0',0,'L');
		$this->SetTextColor(21);
		
		$this->SetFont('Times','B',6);
		$this->SetX(99);

        $this->Cell($w[5],6,$row[5],'0',0,'L');
		
		$this->SetTextColor(21);
		
		$this->SetFont('Times','B',5);
		
		$this->SetX(140);

        $this->Cell($w[6],6,$row[6],'0',0,'L');
		$this->SetTextColor(21);
		
		$this->SetFont('Times','B',5);
		$this->SetX(170);

        $this->Cell($w[7],6,$row[7],'0',1,'L');
		}


    }

function BuildTable($header,$data) {

        //Colors, line width and bold font

        $this->SetFillColor(128,226,114);

        $this->SetTextColor(0);

        $this->SetDrawColor(128,0,0);

        $this->SetLineWidth(.1);

		$this->SetDrawColor(0);


        $this->SetFont('Times','B',8);

        //Header

        // make an array for the column widths

        $w=array(10,45,30,30,30,30);

        // send the headers to the PDF document

        for($i=0;$i<count($header);$i++)

        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);

        $this->Ln();

        //Color and font restoration

		$this->SetFillColor(200,237,194);
		 
        $this->SetTextColor(0);

      //$this->SetFont('Arial','',);



        //now spool out the data from the $data array

        $fill=true; // used to alternate row color backgrounds

       foreach($data as $row)

        {

        $this->Cell($w[0],6,$row[0],'1',0,'L',$fill);

        // set colors to show a URL style link

        $this->SetTextColor(21);

        $this->SetFont('');
		$this->SetDrawColor(0);
		
		$this->SetFont('Arial','B',8);
       
        $this->Cell($w[1],6,$row[1],'1',0,'L',$fill);

        // restore normal color settings for 

        $this->SetTextColor(21);
		
		$this->SetFont('Times','B',8);

        $this->Cell($w[2],6,$row[2],'1',0,'C',$fill);

			
		$this->SetTextColor(21);

        $this->SetFont('');
		$this->SetDrawColor(0);
		
		$this->SetFont('Arial','B',8);
       
        $this->Cell($w[3],6,$row[3],'1',0,'C',$fill);

        // restore normal color settings for 

        $this->SetTextColor(21);
		
		$this->SetFont('Times','B',8);

        $this->Cell($w[4],6,$row[4],'1',0,'C',$fill);

		$this->SetTextColor(21);

		$this->SetFont('Times','B',8);
		
		$this->Cell($w[5],6,$row[5],'1',0,'C',$fill);

		$this->Ln();

        // flips from true to false and vise versa

         $fill =! $fill;

        }

      //  $this->Cell(array_sum($w),0,'','T');

        }

 






function Listcomment($comment){
      
	   $this->SetFillColor(200,237,194);
        $this->SetTextColor(0);
        $this->SetFont('Times','B',8);
		$this->SetX(10);

        //now spool out the data from the $data array

        $fill=true; // used to alternate row color backgrounds


     $ws=array(45,10,45,10);
      
       foreach($comment as $rowcom)
        {
  
  		
        $this->Cell($ws[0],6,$rowcom[0],'0',0,'L',$fill);

        // set colors to show a URL style link

        $this->SetTextColor(21);
        $this->SetFont('');
		$this->SetDrawColor(0);
		$this->SetX(30);
		$this->SetFont('Arial','B',8);
        $this->Cell($ws[1],6,$rowcom[1],'0',0,'L',$fill);

        // restore normal color settings for 

        $this->SetTextColor(21);
		$this->SetX(50);
		$this->SetFont('Times','B',8);
        $this->Cell($ws[2],6,$rowcom[2],'0',0,'L',$fill);
		
		$this->SetTextColor(21);
		$this->SetFont('Arial','B',8);
		$this->SetX(80);
		$this->Cell($ws[3],6,$rowcom[3],'0',0,'L',$fill);
		

        $this->Ln();

        // flips from true to false and vise versa

         $fill =! $fill;

        }

        //$this->Cell(array_sum($w),0,'','T');

        }

function Listcomment1($comment){

       

        $this->SetFillColor(248);
        $this->SetTextColor(0);
        $this->SetFont('Times','B',8);
		$this->SetX(10);

        //now spool out the data from the $data array

        $fill=true; // used to alternate row color backgrounds

       foreach($comment as $rowcom)
        {
  
  		
        $this->Cell($w[0],6,$rowcom[0],'0',0,'L');

        // set colors to show a URL style link

        $this->SetTextColor(21);
        $this->SetFont('');
		$this->SetDrawColor(0);
		$this->SetX(30);
		$this->SetFont('Arial','B',8);
        $this->Cell($w[1],6,$rowcom[1],'0',0,'L');

        // restore normal color settings for 

        $this->SetTextColor(21);
		$this->SetX(50);
		$this->SetFont('Times','B',8);
        $this->Cell($w[2],6,$rowcom[2],'0',0,'L');
		
		$this->SetTextColor(21);
		$this->SetFont('Arial','B',8);
		$this->SetX(80);
		$this->Cell($w[3],6,$rowcom[3],'0',0,'L');
		

        $this->Ln();

        // flips from true to false and vise versa

         $fill =! $fill;

        }

        //$this->Cell(array_sum($w),0,'','T');

        }



function Listcomment2($comment){

       
		$this->SetFillColor(200,237,194);
        $this->SetTextColor(0);
        $this->SetFont('Times','B',8);
		$this->SetX(10);

        //now spool out the data from the $data array

        $ws=array(45,10,45,10);
        $fill=true; // used to alternate row color backgrounds

       foreach($comment as $rowcom)
        {
  
  		
        $this->Cell($ws[0],6,$rowcom[0],'0',0,'L',$fill);

        // set colors to show a URL style link

        $this->SetTextColor(21);
        $this->SetFont('');
		$this->SetDrawColor(0);
		$this->SetX(30);
		$this->SetFont('Arial','B',8);
        $this->Cell($ws[1],6,$rowcom[1],'0',0,'L',$fill);

        // restore normal color settings for 

        $this->SetTextColor(21);
		$this->SetX(50);
		$this->SetFont('Times','B',8);
        $this->Cell($ws[2],6,$rowcom[2],'0',0,'L',$fill);
		
		$this->SetTextColor(21);
		$this->SetFont('Arial','B',8);
		$this->SetX(80);
		$this->Cell($ws[3],6,$rowcom[3],'0',0,'L');
		

        $this->Ln();

        // flips from true to false and vise versa

         $fill =! $fill;

        }

        //$this->Cell(array_sum($w),0,'','T');

        }


function Listcomment3($comment){

       

        $this->SetFillColor(248);
        $this->SetTextColor(0);
        $this->SetFont('Times','B',8);
		$this->SetX(10);

        //now spool out the data from the $data array

        $fill=true; // used to alternate row color backgrounds

       foreach($comment as $rowcom)
        {
  
  		
        $this->Cell($w[0],6,$rowcom[0],'0',0,'L');

        // set colors to show a URL style link

        $this->SetTextColor(21);
        $this->SetFont('');
		$this->SetDrawColor(0);
		$this->SetX(30);
		$this->SetFont('Arial','B',8);
        $this->Cell($w[1],6,$rowcom[1],'0',0,'L');

        // restore normal color settings for 

        $this->SetTextColor(21);
		$this->SetX(50);
		$this->SetFont('Times','B',8);
        $this->Cell($w[2],6,$rowcom[2],'0',0,'L');
		
		$this->SetTextColor(21);
		$this->SetFont('Arial','B',8);
		$this->SetX(80);
		$this->Cell($w[3],6,$rowcom[3],'0',0,'L');
		

        $this->Ln();

        // flips from true to false and vise versa

         $fill =! $fill;

        }

        //$this->Cell(array_sum($w),0,'','T');

        }


function Listcomment4($comment){

       
		 $this->SetFillColor(200,237,194);
         $this->SetTextColor(0);
        $this->SetFont('Times','B',8);
		$this->SetX(10);

        //now spool out the data from the $data array
      $ws=array(45,10,45,10);
        $fill=true; // used to alternate row color backgrounds

       foreach($comment as $rowcom)
        {
  
  		
        $this->Cell($ws[0],6,$rowcom[0],'0',0,'L',$fill);

        // set colors to show a URL style link

        $this->SetTextColor(21);
        $this->SetFont('');
		$this->SetDrawColor(0);
		$this->SetX(30);
		$this->SetFont('Arial','B',8);
        $this->Cell($ws[1],6,$rowcom[1],'0',0,'L',$fill);

        // restore normal color settings for 

        $this->SetTextColor(21);
		$this->SetX(50);
		$this->SetFont('Times','B',8);
        $this->Cell($ws[2],6,$rowcom[2],'0',0,'L',$fill);
		
		$this->SetTextColor(21);
		$this->SetFont('Arial','B',8);
		$this->SetX(80);
		$this->Cell($ws[3],6,$rowcom[3],'0',0,'L',$fill);
		

        $this->Ln();

        // flips from true to false and vise versa

         $fill =! $fill;

        }

        //$this->Cell(array_sum($w),0,'','T');

        }


function Listcomment5($comment){

       
		$this->SetFillColor(200,237,194);
       // $this->SetFillColor(248);
        $this->SetTextColor(0);
        $this->SetFont('Times','B',8);
		$this->SetX(10);

        //now spool out the data from the $data array
		$ws=array(60,60,60,60,60,60);
        $fill=true; // used to alternate row color backgrounds

       foreach($comment as $rowcom)
        {
  
  		
        $this->Cell($ws[0],6,$rowcom[0],'0',0,'L',$fill);

        // set colors to show a URL style link

        $this->SetTextColor(21);
        $this->SetFont('');
		$this->SetDrawColor(0);
		$this->SetX(50);
		$this->SetFont('Arial','B',6);
        $this->Cell($ws[1],6,$rowcom[1],'0',1,'L',$fill);

        // restore normal color settings for 

        $this->SetTextColor(21);
		$this->SetX(10);
		$this->SetFont('Times','B',8);
        $this->Cell($ws[2],6,$rowcom[2],'0',0,'L');
		
		$this->SetTextColor(21);
		$this->SetFont('Arial','B',6);
		$this->SetX(50);
		$this->Cell($ws[3],6,$rowcom[3],'0',1,'L');
		
		 $this->SetTextColor(21);
        $this->SetFont('');
		$this->SetDrawColor(0);
		$this->SetX(10);
		$this->SetFont('Times','B',8);
        $this->Cell($ws[4],6,$rowcom[4],'0',0,'L',$fill);

        // restore normal color settings for 

        $this->SetTextColor(21);
		$this->SetX(50);
		$this->SetFont('Arial','B',6);
        $this->Cell($ws[5],6,$rowcom[5],'0',1,'L',$fill);
		

        $this->Ln();

        // flips from true to false and vise versa

         $fill =! $fill;

        }

        //$this->Cell(array_sum($w),0,'','T');

        }




 }


// end of CLASS

?>