<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Invoice_FilePreview_View extends Vtiger_IndexAjax_View {

	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();

		if (!Users_Privileges_Model::isPermitted($moduleName, 'DetailView', $request->get('record'))) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED', $moduleName));
		}
	}

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
		$basicFileTypes = array('txt', 'csv', 'ics');
		$imageFileTypes = array('image/gif', 'image/png', 'image/jpeg');
		//supported by video js
		$videoFileTypes = array('video/mp4', 'video/ogg', 'audio/ogg', 'video/webm');
		$audioFileTypes = array('audio/mp3', 'audio/mpeg', 'audio/wav');
		//supported by viewer js
		$opendocumentFileTypes = array('odt', 'ods', 'odp', 'fodt');
         //$model = Vtiger_Module_Model::getInstance($moduleName);
		 $recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
         $pdfFileName = $recordModel->getPDFFileName();
          $sequenceNo = getModuleSequenceNumber($moduleName,$recordId);
		  $translatedName = vtranslate($moduleName, $moduleName);
		  $filename = "$translatedName"."_".$sequenceNo.".pdf";
		  $trimmedFileName="$translatedName"."_".$sequenceNo;

		$fileContent = false;
		if (!empty($pdfFileName)) {
			$filePath = $pdfFileName;
			$fileName = $filename;
			$fileSize = filesize($pdfFileName);
			$fileSize = $fileSize + ($fileSize % 1024);
			if (fopen($pdfFileName, "r")) {
				$fileContent = fread(fopen($pdfFileName, "r"), $fileSize);
			}
		}

		$path = $pdfFileName;
		$type = 'application/pdf';
		$contents = $fileContent;
		$parts = explode('.', $filename);

        $downloadUrl ="index.php?module=".$moduleName."&action=ExportPDF&record=".$recordId;
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
		echo $viewer->view('FilePreview.tpl', 'ModComments', true);

	}

}
