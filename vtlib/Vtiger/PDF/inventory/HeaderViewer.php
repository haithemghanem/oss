<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
include_once dirname(__FILE__) . '/../viewers/HeaderViewer.php';

class Vtiger_PDF_InventoryHeaderViewer extends Vtiger_PDF_HeaderViewer {

	function totalHeight($parent) {
		$height = 52;
		
		if($this->onEveryPage) return $height;
		if($this->onFirstPage && $parent->onFirstPage()) $height;
		return 0;
	}
	
	function display($parent) {
		$pdf = $parent->getPDF();
		$headerFrame = $parent->getHeaderFrame();
		if($this->model) {
			$headerColumnWidth = $headerFrame->w/3.0;
			
			$modelColumns = $this->model->get('columns');
			
			// Column 1
			$offsetX =2 ;//def=5
			
			$modelColumn0 = $modelColumns[0];

			list($imageWidth, $imageHeight, $imageType, $imageAttr) = $parent->getimagesize(
					$modelColumn0['logo']);
			//division because of mm to px conversion
			$w = $imageWidth/3;
			if($w > 45) {   //def=w>60 w=60
				$w=45;
			}
			$h = $imageHeight/3;
			if($h > 15) {   //def h>30 , h=30
				$h = 20;
			}
			//$pdf->MultiCell($w, 1, "", 1, 'R', 0, 1);
			 $offsetY = 1;
			$pdf->Image($modelColumn0['logo'], 155, $headerFrame->y, $w, 20,'','','R');
			$imageHeightInMM = 18;//def=30/18
			
			
			
			$pdf->SetFillColor(0,0,0);
			$pdf->SetFillColor(205,201,201);
			$pdf->SetFont('freeserif', 'B','18'); //def=freeserif
			$contentHeight = $pdf->GetStringHeight( $modelColumn0['summary'], $headerColumnWidth);
			//$pdf->MultiCell($headerColumnWidth, $contentHeight, $modelColumn0['summary'], 0, 'L', 0, 1, 
			//	$headerFrame->x, $headerFrame->y+$imageHeightInMM+2);
			
			$pdf->SetFont('aealarabiya', '','8');
			$contentHeight = $pdf->GetStringHeight( $modelColumn0['content'], $headerColumnWidth);			
			//$pdf->MultiCell($headerColumnWidth, $contentHeight, $modelColumn0['content'], 0, 'L', 0, 1, 
			//	$headerFrame->x, $pdf->GetY());
				
			// Column 2
			$offsetX = 2; //def=5
			$pdf->SetY($headerFrame->y);

			$modelColumn1 = $modelColumns[1];
			//$pdf->Ln(2);
			$offsetY = 2;//def=8
			
			$firstcontant="";
			$Company="";
			$Phone="";
		    $Mobile="";
		    $email="";
		    $revedeName="";
		    $RecevdePhone="";
		    
			foreach($modelColumn1 as $label => $value) {

				if(!empty($value)) {
					$pdf->SetFont('aealarabiya', 'B','8');
					//$pdf->SetFillColor(205,201,201);
					$Contant= $label .": ".$value;
					if($label =="Customer Name" ||  $label=="Contact Name"){
					   $Company = $value;
					}

					if($label =="contactphone"){
					   $Phone = $value;
					}
					if($label =="contactmobil"){
					   $Mobile = $value;
					}
					if($label =="contactemail"){
					   $email = $value;
					}
					if($label =="recevedname"){
						$revedeName=$value;
					}if($label =="RecevdePhone"){
					    $RecevdePhone=$value;

					}


					//$pdf->MultiCell($w+20, 7, $Contant, 0, 'l', 0, 1, $headerFrame->x, $headerFrame->y+$imageHeightInMM+2);

					//$pdf->SetFont('aealarabiya', 'B','8');
					//$pdf->MultiCell($headerColumnWidth-$offsetX, 5, $value, 1, 'C', 0, 1, $headerFrame->x+$headerColumnWidth+$offsetX, $pdf->GetY());
				  // $offsetY = 1;//def=2
				}
			}
			
			$firstcontant .="المرسل : ".$Company;
			$firstcontant .="\n";
			$firstcontant .="هاتف المرسل: ".$Mobile;
			$firstcontant .="\n";

			$firstcontant .="المستلم :".$revedeName;
			$firstcontant .="\n";
			$firstcontant .="هاتف المستلم :".$RecevdePhone;
			$firstcontant .="\n";
			
			$pdf->SetFont('aealarabiya', '','11'); 
			//$pdf->MultiCell($w+20, 7, $firstcontant, 1, 'R', 0, 1, $headerFrame->x, $headerFrame->y+$imageHeightInMM+6);
			$pdf->MultiCell($w+30, 7, $firstcontant, 0, 'R', 0, 1, 125,$headerFrame->y+$imageHeightInMM+6);  
			 $offsetY = 1;
			
			
			// Column 3
			$offsetX = 5;//def=6
			
			$modelColumn2 = $modelColumns[2];
			
			$contentWidth = $pdf->GetStringWidth($this->model->get('title'));
			$contentHeight = $pdf->GetStringHeight($this->model->get('title'), $contentWidth);
			
			$roundedRectX = $headerFrame->w+$headerFrame->x-$contentWidth*2.0;
			$roundedRectW = $contentWidth*2.0;
			
			//$pdf->RoundedRect($roundedRectX, 10, $roundedRectW, 10, 3, '1111', 'DF', array(), array(205,201,201));
			
			$contentX = $roundedRectX + (($roundedRectW - $contentWidth)/2.0);
			$hades ="مؤسـسـة ";
			$hades.="زمـن الحـلـول";
			$hades .="\n";
			$hades .="AL-OSTORAH";
			$pdf->SetFont('aealarabiya', 'B','14');
			
			//$pdf->MultiCell($w, $h, $hades, 0, 'R', 0, 1, $contentX-$contentWidth,$headerFrame->y+2,);
			$pdf->SetFont('aealarabiya', 'B','20'); 
			$hant="عقد شحن";
			$pdf->MultiCell($w+6, 6, 'AL-OSTORAH', 0, 'L', 0, 1, '',$headerFrame->y,true, 0, false, true, 40, 'T');



			//

            $pdf->SetFont('aealarabiya', 'B','12'); 
            $pdf->MultiCell($w+6, 6, 'Mubasher For Transport', 0, 'L', 0, 1, '',$headerFrame->y+8,true, 0, false, true, 40, 'T');

            $reco="سجل تجاري";
            $reco .=": ".$this->model->get('vatid');
            $pdf->SetFont('aealarabiya', 'B','14'); 
            $pdf->MultiCell($w+6, 6,$reco, 0, 'L', 0, 1, '',$headerFrame->y+16,true, 0, false, true, 40, 'T');

            $pdf->SetFont('aealarabiya', 'B','24'); 
			$pdf->MultiCell($w+4, 6, $hant, 1, 'C', 0, 1, 83,$headerFrame->y,true, 0, false, true, 40, 'T');

           $saned="سند استلام وتسليم";
           $pdf->SetFont('aealarabiya', '','14'); 
           $pdf->MultiCell($w+4, 7, $saned, 0, 'C', 1, 1, 83,$headerFrame->y+14,true);

			$pdf->SetFont('aealarabiya', 'B','14'); 
			$pdf->MultiCell($w+4, 14,  $this->model->get('title'), 0, 'C', 0, 1, 83,'',true);

			// set some text for example

			//$pdf->MultiCell(55, 40, '[VERTICAL ALIGNMENT - TOP] '.$txt, 1, 'J', 1, 0, '', '', true, 0, false, true, 40, 'T')
				 
		   //$pdf->SetFont('aealarabiya', 'B','8');
           //$pdf->Cell(190, 1, ' ', 1, 1, 'C', 0);
           //$pdf->Ln(2);
           
             
			$offsetY =1;//def =4

// 			foreach($modelColumn2 as $label => $value) {
// 				if(is_array($value)) {
// 					$pdf->SetFont('aealarabiya', 'B','8');
// 					foreach($value as $l => $v) {
// 						$pdf->MultiCell($headerColumnWidth-$offsetX, 7, sprintf('%s: %s', $l, $v), 1, 'C', 0, 1, 
// 							$headerFrame->x+$headerColumnWidth*2.0+$offsetX, $pdf->GetY()+$offsetY);
// 						$offsetY = 0;
// 					}
// 				} else {
// 					$offsetY = 1;
					
// 				$pdf->SetFont('aealarabiya', '','8');
// 				$pdf->SetFillColor(205,201,201);
//                                 if($label=='Shipping Address'){ 
//                                     $width=$pdf->GetStringWidth($value); 
//                                     $height=$pdf->GetStringHeight($value,$width);
//                                     $pdf->MultiCell($headerColumnWidth-$offsetX, 7, $label, 1, 'L', 1, 1, $headerFrame->x+$headerColumnWidth*2.0+$offsetX,
//                                             $pdf->GetY()+$offsetY-$height-$offsetX-4.0); 

//                                     $pdf->SetFont('aealarabiya', '','8');
//                                     $pdf->MultiCell($headerColumnWidth-$offsetX, 7, $value, 1, 'L', 0, 1, $headerFrame->x+$headerColumnWidth*2.0+$offsetX, 
// 					$pdf->GetY());
// 				} else{ 
//                                     $pdf->MultiCell($headerColumnWidth-$offsetX, 7, $label, 1, 'L', 1, 1, $headerFrame->x+$headerColumnWidth, 
//                                             $pdf->GetY()+$offsetY); 

//                                     $pdf->SetFont('aealarabiya', '','8'); 
//                                     $pdf->MultiCell($headerColumnWidth-$offsetX, 7, $value, 1, 'L', 0, 1, $headerFrame->x+$headerColumnWidth,  
//                                             $pdf->GetY()); 
//                                     } 
//                                 } 
//                             }
                            
                 $rightcontant="";
                 $secondcontant="";
                 $IssuedDate="";
                 $ValidDate="";
                 $username="";
                 $terms_conditions="";
                 $VendorName="";
                 foreach($modelColumn2 as $label => $value) {
                     
					if(is_array($value)) {
						$pdf->SetFont('aealarabiya', '','8');
						foreach($value as $l => $v) {
						   
						   if($l=="Issued Date"){
        					    $IssuedDate=$v;
        					  }
        					
        				   if($l=="Valid Date"){
        					    $ValidDate=$v;
        					}
        					

        					
        					
						   //$rightcontant.= sprintf('%s: %s', $l, $v) ."\n";
							//$pdf->MultiCell($headerColumnWidth-$offsetX, 7, sprintf('%s: %s', $l, $v), 1, 'C', 0, 1,
							//	$headerFrame->x+$headerColumnWidth*2.0+$offsetX, $pdf->GetY()+$offsetY);
							$offsetY = 0;
						}
					} else {
						$offsetY = 2;
                      if($value != ""){
                          
                     
                     if($label=="username"){
                         $username=$value;
                     }
                     if($label=="VendorNameL"){
        						$VendorName=$value;
        			  }
					$pdf->SetFont('aealarabiya', 'B','8');
					//$pdf->SetFillColor(205,201,201);
					$rightcontant .=$label ." : ".$value."\n";
					
					 if ($label="terms_conditions"){
					 	//$terms_conditions=$value;

					 }
					//$pdf->MultiCell($headerColumnWidth-$offsetX, 7, $label, 1, 'L', 1, 1, $headerFrame->x+$headerColumnWidth*2.0+$offsetX,
					//	$pdf->GetY()+$offsetY);

					//$pdf->SetFont('aealarabiya', '','8');
					//$pdf->MultiCell($headerColumnWidth-$offsetX, 7, $value, 1, 'L', 0, 1, $headerFrame->x+$headerColumnWidth*2.0+$offsetX,
					//	$pdf->GetY());
					}
					}
				}           
            
                
                
               
         
                $secondcontant ="الى فرع  :الرياض";
                $secondcontant.="\n";
                $secondcontant.="السائق : ".$VendorName;
                $secondcontant.="\n";
                $secondcontant.="تاريخ العقد :".$IssuedDate;

                $secondcontant.="\n";
                $secondcontant.="المستخدم : ".$username;
                
                
                
               
                 
                
               // $headerFrame->x, $headerFrame->y+$imageHeightInMM+2
                //$pdf->MultiCell($w+30, 10, $secondcontant, 1, 'R', 0, 1, 135,$pdf->GetY()+$offsetY); 
                $pdf->setFont('aealarabiya', '','11');  
                $pdf->MultiCell($w+20, 10, $secondcontant, 0, 'R', 0, 1, $headerFrame->x-10, $headerFrame->y+$imageHeightInMM+8);

               // $pdf->MultiCell($contentFrame->w, 30, $terms_conditions, 1, 'L', 0, 1 ,10,230);         
                            
                            
			$pdf->setFont('aealarabiya', '','8');

			// Add the border cell at the end
			// This is required to reset Y position for next write
			$pdf->MultiCell($headerFrame->w, $headerFrame->h-$headerFrame->y, "", 0, 'L', 0, 1, $headerFrame->x, $headerFrame->y);
		}	
		
	}
	
}