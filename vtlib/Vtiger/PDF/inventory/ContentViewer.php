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
	protected $counter ;
    // static $DESCRIPTION_LABEL_KEY = '__DES_LABEL__';
    //static $DESCRIPTION_DATA_KEY = '__DES__DATA__';
	//static $TERMSANDCONDITION_DATA_KEY = '__TANDC__DATA__';
	//static $DESCRIPTION_LABEL_KEY = '__DES_LABEL__';
	//static $TERMSANDCONDITION_LABEL_KEY = '__TANDC_LABEL__';
	function __construct() {
		// NOTE: General A4 PDF width ~ 189 (excluding margins on either side)
			
		$this->cells = array( // Name => Width
			'Code'    => 20,
			'Name'    => 65,
			'Quantity'=> 20,
			'Price'   => 20,
			'Discount'=> 0,
			'Tax'     => 16,
			'Total'   => 20
		);
	}
	

	function initDisplay($parent) {

		$pdf = $parent->getPDF();
		$contentFrame = $parent->getContentFrame();
        $contentFrame->h =$contentFrame->h - 60;
		$pdf->MultiCell($contentFrame->w, $contentFrame->h, "", 1, 'L', 0, 1, $contentFrame->x, $contentFrame->y);
		
		// Defer drawing the cell border later.
		if(!$parent->onLastPage()) {
			$this->displayWatermark($parent);
		}
		
		// Header	
		$offsetX = 0;
		$pdf->SetFont('','B');
		$pdf->SetFont('aealarabiya', '','12');
		foreach($this->cells as $cellName => $cellWidth) {

			  $cellLabel = ($this->labelModel)? $this->labelModel->get($cellName, $cellName) : $cellName;
			  
		    if($cellName =="Discount"){
			    
			}else if($cellName =="Tax"){

			}
			else if ($cellName =="Code"){

				$pdf->MultiCell($cellWidth, $this->headerRowHeight, 'التسلسل', 1, 'R', 0, 1,170, $contentFrame->y);
			    $offsetX -= $cellWidth;

			}
			else if ($cellName =="Name"){
				$pdf->MultiCell($cellWidth, $this->headerRowHeight, 'الوصف', 1, 'R', 0, 1,105, $contentFrame->y);
			    $offsetX -= $cellWidth;

			}else if ($cellName =="Quantity"){

				$pdf->MultiCell($cellWidth, $this->headerRowHeight, $cellLabel, 1, 'R', 0, 1,85, $contentFrame->y);
			    $offsetX -= $cellWidth;

			}else if ($cellName =="Price"){

				$pdf->MultiCell($cellWidth, $this->headerRowHeight, $cellLabel, 1, 'R', 0, 1,60, $contentFrame->y);
			    $offsetX -= $cellWidth;

			}else if($cellName =="Total"){
			   //$cellLabel = ($this->labelModel)? $this->labelModel->get($cellName, $cellName) : $cellName;
			   $pdf->MultiCell($cellWidth+19.7, $this->headerRowHeight, $cellLabel, 1, 'R', 0, 1,10, $contentFrame->y);
			  $offsetX -= $cellWidth+19.7;
			}


			else{
			//$cellLabel =$contentFrame->x." ".$cellLabel; //($this->labelModel)? $this->labelModel->get($cellName, $cellName) : 
			//$pdf->MultiCell($cellWidth, $this->headerRowHeight, $cellLabel, 1, 'L', 0, 1, $offsetX, $contentFrame->y);
			//$offsetX -= $cellWidth;
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

		$offsetX = 170;
		foreach($this->cells as $cellName => $cellWidth) {
			$cellHeight = isset($cellHeights[$cellName])? $cellHeights[$cellName] : $contentFrame->h;
           	if($cellName =="Discount"){
			    
			}else if($cellName =="Tax"){

			}
			else if($cellName =="Total"){
			    
			   $offsetY = $contentFrame->y-$this->headerRowHeight;			
			   $pdf->MultiCell($cellWidth+19.7, $cellHeight, "", 0, 'L', 0, 1, $offsetX, $offsetY);
			    $offsetX -= $cellWidth+19.7;
			}
			else{
			    
			$offsetY = $contentFrame->y-$this->headerRowHeight;			
		
			$pdf->MultiCell($cellWidth, $cellHeight, "", 0, 'L', 0, 1, $offsetX, $offsetY);
			$offsetX -= $cellWidth;
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

			$offsetX = 170;
			$inde= $index + 1;
			foreach($this->cells as $cellName => $cellWidth) {
			    
			 if($cellName =="Discount"){
			    
			}else if($cellName =="Tax"){

			} else if ($cellName =="Code"){

				$pdf->MultiCell($cellWidth, $this->contentHeight, $inde , 1, 'R', 0, 1,170, $contentLineY);
			    $offsetX -= $cellWidth;

			}else if ($cellName =="Name"){
				$pdf->MultiCell($cellWidth , $contentHeight, $model->get($cellName), 1, 'R', 0, 1, 105, $contentLineY);
				$offsetX -= $cellWidth;
			}else if ($cellName =="Quantity"){
				$pdf->MultiCell($cellWidth , $contentHeight, $model->get($cellName), 1, 'R', 0, 1, 85, $contentLineY);
				$offsetX -= $cellWidth;
			}else if ($cellName =="Price"){
				$pdf->MultiCell($cellWidth , $contentHeight, $model->get($cellName), 1, 'R', 0, 1, 60, $contentLineY);
				$offsetX -= $cellWidth;
			}
			else if($cellName =="Total"){
			    	$pdf->MultiCell($cellWidth+19.7, $contentHeight, $model->get($cellName), 1, 'R', 0, 1, 10, $contentLineY);
				$offsetX -= $cellWidth+19.7;
			}
			
			else{

				//$pdf->MultiCell($cellWidth, $contentHeight, $model->get($cellName), 1, 'R', 0, 1, $offsetX, $contentLineY);
				//$offsetX -= $cellWidth;
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
				$pdf->MultiCell(160, $contentHeight-5, $model->get('Comment'), 1, 'R', 0, 1, 10,
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

				$pdf->MultiCell(150, $summaryCellHeight, $key, 1, 'C', 0, 1, 50, $summaryLineY);
				
				$pdf->MultiCell(39.7, $summaryCellHeight, 
					$this->contentSummaryModel->get($key), 1, 'C', 0, 1,10 , $summaryLineY);
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

		 
  
         //$Foter="$Tres";

		 //$foterinstans= new Vtiger_PDF_Model();
		//$descriptionString =$foterinstans->model->get(Vtiger_PDF_InventoryFooterViewer::$DESCRIPTION_LABEL_KEY);
	    // $description =$foterinstans->model->get(Vtiger_PDF_InventoryFooterViewer::$DESCRIPTION_DATA_KEY);
		
	    $pdf->MultiCell($contentFrame->w, 10, $tandc, 0, 'R', 0, 1 ,10,220);

	    $pdf->MultiCell($cellWidth, $this->headerRowHeight, 'الرياض', 1, 'C', 0, 1,170, 248);
	    $pdf->MultiCell($cellWidth, $this->headerRowHeight, 'جـــــــدة', 1, 'C', 0, 1,130, 248);
	    $pdf->MultiCell($cellWidth, $this->headerRowHeight, 'خميس مشيط', 1, 'C', 0, 1,87, 248);

	    $pdf->MultiCell($cellWidth, $this->headerRowHeight, 'أبـــــهــــا', 1, 'C', 0, 1,52, 248);
	    //$pdf->MultiCell($cellWidth, $this->headerRowHeight, 'الدمــــــــام', 1, 'C', 0, 1,41.68, 253);
	    $pdf->MultiCell($cellWidth, $this->headerRowHeight, 'محايل عسير', 1, 'C', 0, 1,10.35, 248);
         
	    $pdf->MultiCell($cellWidth, $this->headerRowHeight, '4468337 4467211', 1, 'C', 0, 1,170, 248 +$this->headerRowHeight);
	    $pdf->MultiCell($cellWidth, $this->headerRowHeight, '6356655 6388020', 1, 'C', 0, 1,130, 248 +$this->headerRowHeight);
	    $pdf->MultiCell($cellWidth, $this->headerRowHeight, '2210101 2220101', 1, 'C', 0, 1,87, 248+$this->headerRowHeight );

	    $pdf->MultiCell($cellWidth, $this->headerRowHeight, '2280101 2290202', 1, 'C', 0, 1,52, 248+$this->headerRowHeight );
	    //$pdf->MultiCell($cellWidth, $this->headerRowHeight, '0507499544 2850960', 1, 'C', 0, 1,41.68, 253+$this->headerRowHeight );
	    $pdf->MultiCell($cellWidth, $this->headerRowHeight, '0138386286 0569513057', 1, 'C', 0, 1,10.35, 248+$this->headerRowHeight);
		
         //$pdf->MultiCell($contentFrame->w, 10, $Foter, 1, 'C', 0, 1 ,10,255);
        

        
            
         

			
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