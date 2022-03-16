<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class ModComments_FilePreview1_View extends Vtiger_IndexAjax_View {

	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();

		if (!Users_Privileges_Model::isPermitted($moduleName, 'DetailView', $request->get('record'))) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED', $moduleName));
		}
	}

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
		//var_dump($moduleName);
		//exit;
		//$attachmentId = $request->get('attachmentid');
		$basicFileTypes = array('txt', 'csv', 'ics');
		$imageFileTypes = array('image/gif', 'image/png', 'image/jpeg');
		//supported by video js
		$videoFileTypes = array('video/mp4', 'video/ogg', 'audio/ogg', 'video/webm');
		$audioFileTypes = array('audio/mp3', 'audio/mpeg', 'audio/wav');
		//supported by viewer js
		$opendocumentFileTypes = array('odt', 'ods', 'odp', 'fodt');
		//$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
		//$attachments = $recordModel->getFileDetails($attachmentId);
         $modulName="Quotes";
         $model = Vtiger_Module_Model::getInstance('Quotes');
		 $recordModel = Vtiger_Record_Model::getInstanceById($recordId, $modulName);
         $pdfFileName = $recordModel->getPDFFileName();
         //$pdfFileName ="storage/Invoices_INV19.pdf";
          $sequenceNo = getModuleSequenceNumber($modulName,$recordId);
		  $translatedName = vtranslate($modulName, $modulName);
		  $filename = "$translatedName"."_".$sequenceNo.".pdf";
		  $trimmedFileName="$translatedName"."_".$sequenceNo;
         //$filename="Invoices_INV19.pdf";
         //$trimmedFileName="Invoices_INV19";
		//$fileDetails = $attachments[0];
		$fileContent = false;
		if (!empty($pdfFileName)) {
			$filePath = $pdfFileName;
			$fileName = $filename;
			//$fileName = html_entity_decode($fileName, ENT_QUOTES, vglobal('default_charset'));
			//$savedFile = $fileDetails['attachmentsid']."_".$fileName;

			$fileSize = filesize($pdfFileName);
			$fileSize = $fileSize + ($fileSize % 1024);

			if (fopen($pdfFileName, "r")) {
				$fileContent = fread(fopen($pdfFileName, "r"), $fileSize);
			}
		}

		$path = $pdfFileName;
		$type = 'application/pdf';
		$contents = $fileContent;
		//$filename = $fileDetails['name'];
		$parts = explode('.', $filename);
		//if ($recordModel->get('filename')) {
		//	$fileDetails = $recordModel->getFileNameAndDownloadURL($recordId, $attachmentId);
		//}

		// if (is_array($fileDetails[0])) {
		// 	$downloadUrl = $fileDetails[0]['url'];
		// 	$trimmedFileName = $fileDetails[0]['trimmedFileName'];
		// }
         $downloadUrl ="index.php?module=".$modulName."&action=ExportPDF&record=".$recordId;
		//support for plain/text document
		$extn = 'txt';
		if (count($parts) > 1) {
			$extn = end($parts);
		}
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE_NAME', 'ModComments');
		if (in_array($extn, $basicFileTypes))
			$viewer->assign('BASIC_FILE_TYPE', 'yes');
		else if (in_array($type, $videoFileTypes))
			$viewer->assign('VIDEO_FILE_TYPE', 'yes');
		else if (in_array($type, $imageFileTypes))
			$viewer->assign('IMAGE_FILE_TYPE', 'yes');
		else if (in_array($type, $audioFileTypes))
			$viewer->assign('AUDIO_FILE_TYPE', 'yes');
		else if (in_array($extn, $opendocumentFileTypes)) {
			$viewer->assign('OPENDOCUMENT_FILE_TYPE', 'yes');
			//$downloadUrl .= "&type=$extn";
		} else if ($extn == 'pdf') {
			$viewer->assign('PDF_FILE_TYPE', 'yes');
		} else
			$viewer->assign('FILE_PREVIEW_NOT_SUPPORTED', 'yes');

		$viewer->assign('DOWNLOAD_URL', $downloadUrl);
		$viewer->assign('FILE_PATH', $path);
		$viewer->assign('TRIMMED_FILE_NAME', $trimmedFileName);
		$viewer->assign('FILE_NAME', $filename);
		$viewer->assign('FILE_EXTN', $extn);
		$viewer->assign('FILE_TYPE', $type);
		$viewer->assign('FILE_CONTENTS', $contents);
		$site_URL = vglobal('site_URL');
		$viewer->assign('SITE_URL', $site_URL);
        
       
		//echo $viewer->view('FilePreview.tpl', $moduleName, true);
		echo $viewer->view('FilePreview.tpl', $moduleName, true);

	}

}
