<?php

 require_once("../ClassesController/fpdf/fpdf.php"); 
  
	 
 class myPDF extends FPDF {
    
       


       
function Header() {
	
        $this->Ln(5);
		
		$this->Image('printbg.png',50,50,100,120);

		$this->SetY(35);

}



        //Page footer method

        function Footer()       {

       
        }

function Listp($particulars)
{

	    $this->SetFillColor(248);
        $this->SetTextColor(0);
      	$this->SetFont('Arial','B',12);



        //now spool out the data from the $data array

        $fill=true; // used to alternate row color backgrounds

        foreach($particulars as $row)
        {

        $this->Cell($w[0],6,$row[0],'0',0,'L');

        // set colors to show a URL style link

        $this->SetTextColor(21);

        $this->SetFont('');
		$this->SetDrawColor(0);
		//$this->SetX(85);
       
		$this->SetFont('Arial','B',12);
		
       
        $this->Cell($w[1],6,$row[1],'0',1,'R');

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

        $this->SetFillColor(232,255,245);
        $this->SetTextColor(0);

        $this->SetDrawColor(128,0,0);

        $this->SetLineWidth(.1);

        $this->SetFont('Times','B',7);

        //Header

        // make an array for the column widths

        $w=array(5,45,25,25,18,22,10,22,22);

        // send the headers to the PDF document

        for($i=0;$i<count($header);$i++)

        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);

        $this->Ln();

        //Color and font restoration

         $this->SetFillColor(248,248,248);

        $this->SetTextColor(0);
    

		$this->SetFont('Times','B',8);

        //now spool out the data from the $data array

        $fill=true; // used to alternate row color backgrounds

       foreach($data as $row)
        {

        $this->Cell($w[0],6,$row[0],'1',0,'L',$fill);

        $this->Cell($w[1],6,$row[1],'1',0,'L',$fill);

		
        $this->Cell($w[2],6,$row[2],'1',0,'C',$fill);
		

		$this->Cell($w[3],6,$row[3],'1',0,'C',$fill);
	
        $this->Cell($w[4],6,$row[4],'1',0,'C',$fill);

       
        $this->Cell($w[5],6,$row[5],'1',0,'C',$fill);

        $this->Cell($w[6],6,$row[6],'1',0,'C',$fill);

		
		$this->Cell($w[7],6,$row[7],'1',0,'C',$fill);
		
		$this->Cell($w[8],6,$row[8],'1',0,'C',$fill);

		
        $this->Ln();

        // flips from true to false and vise versa

         $fill =! $fill;

        }

       //$this->Cell(array_sum($w),0,'','T');

        }

 




function Listcomment($comment){
      
	    $this->SetFillColor(248,248,248);
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

       
		 $this->SetFillColor(248,248,248);
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

       
		
		 $this->SetFillColor(248,248,248);
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

  
		 $this->SetFillColor(248,248,248);
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