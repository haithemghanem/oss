<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
include_once 'vtlib/Vtiger/PDF/models/Model.php';
include_once dirname(__FILE__) . '/../viewers/ContentViewer.php';
include_once 'vtlib/Vtiger/PDF/inventory/FooterViewer.php';
//include_once 'data/CRMEntity.php';

class Vtiger_PDF_InventoryContentViewer extends Vtiger_PDF_ContentViewer {

	protected $headerRowHeight = 8;
	protected $onSummaryPage   = false;
    // static $DESCRIPTION_LABEL_KEY = '__DES_LABEL__';
    //static $DESCRIPTION_DATA_KEY = '__DES__DATA__';
	//static $TERMSANDCONDITION_DATA_KEY = '__TANDC__DATA__';
	//static $DESCRIPTION_LABEL_KEY = '__DES_LABEL__';
	//static $TERMSANDCONDITION_LABEL_KEY = '__TANDC_LABEL__';
	function __construct() {
		// NOTE: General A4 PDF width ~ 189 (excluding margins on either side)
			
		$this->cells = array( // Name => Width
			'Code'    => 30,
			'Name'    => 65,
			'Quantity'=> 30,
			'Price'   => 30,
			'Discount'=> 0,
			'Tax'     => 16,
			'Total'   => 20
		);
	}
	
	function initDisplay($parent) {

		$pdf = $parent->getPDF();
		$contentFrame = $parent->getContentFrame();
        $contentFrame->h =$contentFrame->h - 80;
		$pdf->MultiCell($contentFrame->w, $contentFrame->h, "", 0, 'L', 0, 1, $contentFrame->x, $contentFrame->y);
		
		// Defer drawing the cell border later.
		if(!$parent->onLastPage()) {
			$this->displayWatermark($parent);
		}
		
		// Header	
		$offsetX = 0;
		$pdf->SetFont('','B');
		foreach($this->cells as $cellName => $cellWidth) {
		    	if($cellName =="Discount"){
			    
			}else if($cellName =="Total"){
			    $cellLabel = ($this->labelModel)? $this->labelModel->get($cellName, $cellName) : $cellName;
			$pdf->MultiCell($cellWidth+19.7, $this->headerRowHeight, $cellLabel, 1, 'L', 0, 1, $contentFrame->x+$offsetX, $contentFrame->y);
			$offsetX += $cellWidth+19.7;
			}
			else{
			$cellLabel = ($this->labelModel)? $this->labelModel->get($cellName, $cellName) : $cellName;
			$pdf->MultiCell($cellWidth, $this->headerRowHeight, $cellLabel, 1, 'L', 0, 1, $contentFrame->x+$offsetX, $contentFrame->y);
			$offsetX += $cellWidth;
			}
		}
		$pdf->SetFont('','');
		// Reset the y to use
		$contentFrame->y += $this->headerRowHeight;
	}
	
	function drawCellBorder($parent, $cellHeights=False) {		
		$pdf = $parent->getPDF();
		$contentFrame = $parent->getContentFrame();
		
		if(empty($cellHeights)) $cellHeights = array();

		$offsetX = 0;
		foreach($this->cells as $cellName => $cellWidth) {
			$cellHeight = isset($cellHeights[$cellName])? $cellHeights[$cellName] : $contentFrame->h;
           	if($cellName =="Discount"){
			    
			}else if($cellName =="Total"){
			    
			    	$offsetY = $contentFrame->y-$this->headerRowHeight;			
		
			   $pdf->MultiCell($cellWidth+19.7, $cellHeight, "", 0, 'R', 0, 1, $contentFrame->x+$offsetX, $offsetY);
			    $offsetX += $cellWidth+19.7;
			}
			else{
			    
			$offsetY = $contentFrame->y-$this->headerRowHeight;			
		
			$pdf->MultiCell($cellWidth, $cellHeight, "", 0, 'R', 0, 1, $contentFrame->x+$offsetX, $offsetY);
			$offsetX += $cellWidth;
			}
		}
	}

	function display($parent) {
		$this->displayPreLastPage($parent);
		$this->displayLastPage($parent);
	}

	function displayPreLastPage($parent) {

		$models = $this->contentModels;

		$totalModels = count($models);
		$pdf = $parent->getPDF();

		$parent->createPage();
		$contentFrame = $parent->getContentFrame();

		$contentLineX = $contentFrame->x; $contentLineY = $contentFrame->y;
		$overflowOffsetH = 8; // This is offset used to detect overflow to next page
		for ($index = 0; $index < $totalModels; ++$index) {
			$model = $models[$index];
			
			$contentHeight = 1;
			
			// Determine the content height to use
			foreach($this->cells as $cellName => $cellWidth) {
				$contentString = $model->get($cellName);
				if(empty($contentString)) continue;
				$contentStringHeight = $pdf->GetStringHeight($contentString, $cellWidth);
				if ($contentStringHeight > $contentHeight) $contentHeight = $contentStringHeight;
			}
			
			// Are we overshooting the height?
			if(ceil($contentLineY + $contentHeight) > ceil($contentFrame->h+$contentFrame->y)) {
			
				$this->drawCellBorder($parent);
				$parent->createPage();

				$contentFrame = $parent->getContentFrame();
				$contentLineX = $contentFrame->x; $contentLineY = $contentFrame->y;
			}

			$offsetX = 0;
			foreach($this->cells as $cellName => $cellWidth) {
			    
			    	if($cellName =="Discount"){
			    
			}else if($cellName =="Total"){
			    	$pdf->MultiCell($cellWidth+19.7, $contentHeight, $model->get($cellName), 1, 'L', 0, 1, $contentLineX+$offsetX, $contentLineY);
				$offsetX += $cellWidth+19.7;
			}
			
			else{
				$pdf->MultiCell($cellWidth, $contentHeight, $model->get($cellName), 1, 'L', 0, 1, $contentLineX+$offsetX, $contentLineY);
				$offsetX += $cellWidth;
			}
			}
			
			$contentLineY = $pdf->GetY();
			
			$commentContent = $model->get('Comment');
			
			if (!empty($commentContent)) {
				$commentCellWidth = $this->cells['Name'];
				$offsetX = $this->cells['Code'];
				
				$contentHeight = $pdf->GetStringHeight($commentContent, $commentCellWidth);			
				if(ceil($contentLineY + $contentHeight + $overflowOffsetH) > ceil($contentFrame->h+$contentFrame->y)) {
					
					$this->drawCellBorder($parent);
					$parent->createPage();

					$contentFrame = $parent->getContentFrame();
					$contentLineX = $contentFrame->x; $contentLineY = $contentFrame->y;
				}			
				$pdf->MultiCell($commentCellWidth, $contentHeight, $model->get('Comment'), 1, 'L', 0, 1, $contentLineX+$offsetX,
					 $contentLineY);
					 
				$contentLineY = $pdf->GetY();
			}
		}

		// Summary
		$cellHeights = array();
		
		if ($this->contentSummaryModel) {
			$summaryCellKeys = $this->contentSummaryModel->keys(); $summaryCellCount = count($summaryCellKeys);
		
			//$summaryCellLabelWidth = $this->cells['Quantity'] + $this->cells['Price'] + $this->cells['Discount'] + $this->cells['Tax'];
			$summaryCellLabelWidth = $this->cells['Quantity'] + $this->cells['Price'] +  $this->cells['Tax'];
			$summaryCellHeight = $pdf->GetStringHeight("TEST", $summaryCellLabelWidth); // Pre-calculate cell height
		
			$summaryTotalHeight = ceil(($summaryCellHeight * $summaryCellCount));
	
			if (($contentFrame->h+$contentFrame->y) - ($contentLineY+$overflowOffsetH)  < $summaryTotalHeight) { //$overflowOffsetH is added so that last Line Item is not overlapping
				$this->drawCellBorder($parent);
				$parent->createPage();
					
				$contentFrame = $parent->getContentFrame();
				$contentLineX = $contentFrame->x; $contentLineY = $contentFrame->y;
			}
				
			$summaryLineX = $contentLineX + $this->cells['Code'] + $this->cells['Name'];		
			$summaryLineY = ($contentFrame->h+$contentFrame->y-$this->headerRowHeight)-$summaryTotalHeight;
		
			foreach($summaryCellKeys as $key) {	
				$pdf->MultiCell(190-($contentFrame->w-$summaryLineX+10-$summaryCellLabelWidth), $summaryCellHeight, $key, 1, 'C', 0, 1, 10, $summaryLineY);
				$pdf->MultiCell($contentFrame->w-$summaryLineX+10-$summaryCellLabelWidth, $summaryCellHeight, 
					$this->contentSummaryModel->get($key), 1, 'L', 0, 1, $summaryLineX+$summaryCellLabelWidth, $summaryLineY);
				$summaryLineY = $pdf->GetY();
			}
		
			$cellIndex = 0;
			foreach($this->cells as $cellName=>$cellWidth) {
				if ($cellIndex < 2) $cellHeights[$cellName] = $contentFrame->h;
				else $cellHeights[$cellName] = $contentFrame->h - $summaryTotalHeight;
				++$cellIndex;
			}


		}

		//$termsAndConditionLabelString = $this->labelModel->get(self::$TERMSANDCONDITION_LABEL_KEY);
		//$termsAndCondition = $this->model->get(self::$TERMSANDCONDITION_DATA_KEY);
		//$pdf->MultiCell($contentFrame->w, 10, $termsAndCondition, 1, 'C', 0, 1 ,10,220);
		$this->onSummaryPage = true;
		$this->drawCellBorder($parent, $cellHeights);

		 global $adb , $currentModule;
		$sql = 'SELECT tandc FROM vtiger_inventory_tandc WHERE type = ?';
		$result = $adb->pquery($sql, array($currentModule));
		$tandc = $adb->query_result($result, 0, 'tandc');
        
		//var_dump($currentModule);

		 $Tres="Terms:";
         $Tres.="\n";
         $Tres.="PAYMENT:   70% ADVANCE WITH YOUR PO, 20% WITH DELIVERY & 10% WITH PROJECT COMPLETION.";
         $Tres.="CURRENCY:    ALL PRICES MENTIONED IN THIS QUOTATION ARE IN SR.";
         $Tres.="\n";
         $Tres.="DELIVERY:   AS SHOWN PER ITEMS, FROM DATE OF PO.";
         $Tres.="\n";
         $Tres.="INSTALLATION:   INSTALLATION INCLUDED.";
         $Tres.="\n";
         $Tres.="CANCELLATION:  NO CANCELLATION OR AMENDMENTS ONCE THE ORDER IS PROCESSED.";
         $Tres.="\n \n";
         $Tres.="GENERAL TERMS: \n";
         $Tres.="1. Product Availability & Prices are Subject to Change without Prior Notice\n2. Official PO with sign and stamp is required\n3. We will acknowledge acceptance by email after receiving the PO\n4. Prices quoted are for above mentioned quantities only and might change if the quantities are changed \n";
  
         //$Foter="$Tres";

		 //$foterinstans= new Vtiger_PDF_Model();
		//$descriptionString =$foterinstans->model->get(Vtiger_PDF_InventoryFooterViewer::$DESCRIPTION_LABEL_KEY);
	    // $description =$foterinstans->model->get(Vtiger_PDF_InventoryFooterViewer::$DESCRIPTION_DATA_KEY);
		
	    $pdf->MultiCell($contentFrame->w, 10, $tandc, 0, 'L', 0, 1 ,10,200);

	    $Foter="Address   : 271, Al-Sharafeyah - jaddah,Saudi Arabia   ,  Website : solutions-time.com";
		$Foter.="\n";
		$Foter .="Bank Account: Alinma Bank IBAN / SA03050 00068201297338000 , NCP Bank IBAN / SA2310000012300000371905";

         $pdf->MultiCell($contentFrame->w, 10, $Foter, 1, 'C', 0, 1 ,10,255);
        

        
            
         

			
	}

	function displayLastPage($parent) {
		// Add last page to take care of footer display
		// if($parent->createLastPage()) {
		// 	$this->onSummaryPage = false;
         
		// }


	}

	function drawStatusWaterMark($parent) {
		$pdf = $parent->getPDF();

		$waterMarkPositions=array("30","180");
		$waterMarkRotate=array("45","50","180");

		$pdf->SetFont('Arial','B',50);
		$pdf->SetTextColor(230,230,230);
		$pdf->Rotate($waterMarkRotate[0], $waterMarkRotate[1], $waterMarkRotate[2]);
		$pdf->Text($waterMarkPositions[0], $waterMarkPositions[1], 'created');
		$pdf->Rotate(0);
		$pdf->SetTextColor(0,0,0);
	}
}