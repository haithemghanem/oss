<?php

//include_once 'modules/Vtiger/CRMEntity.php';

class WorkDay extends CRMEntity {
        var $table_name = 'vtiger_workday';
        var $table_index= 'workdayid';

        var $customFieldTable = Array('vtiger_workdaycf', 'workdayid');

        var $tab_name = Array('vtiger_crmentity', 'vtiger_workday', 'vtiger_workdaycf');

        var $tab_name_index = Array(
                'vtiger_crmentity' => 'crmid',
                'vtiger_workday' => 'workdayid',
                'vtiger_workdaycf'=>'workdayid');

        var $list_fields = Array (
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'Summary' => Array('workday', 'summary'),
                'Assigned To' => Array('crmentity','smownerid')
        );
        var $list_fields_name = Array (
                /* Format: Field Label => fieldname */
                'Summary' => 'summary',
                'Assigned To' => 'assigned_user_id',
        );

        // Make the field link to detail view
        var $list_link_field = 'summary';

        // For Popup listview and UI type support
        var $search_fields = Array(
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'Summary' => Array('workday', 'summary'),
                'Assigned To' => Array('vtiger_crmentity','assigned_user_id'),
        );
        var $search_fields_name = Array (
                /* Format: Field Label => fieldname */
                'Summary' => 'summary',
                'Assigned To' => 'assigned_user_id',
        );

        // For Popup window record selection
        var $popup_fields = Array ('summary');

        // For Alphabetical search
        var $def_basicsearch_col = 'summary';

        // Column value to use on detail view record text display
        var $def_detailview_recname = 'summary';

        // Used when enabling/disabling the mandatory fields for the module.
        // Refers to vtiger_field.fieldname values.
        var $mandatory_fields = Array('summary','assigned_user_id');

        var $default_order_by = 'summary';
        var $default_sort_order='ASC';
        
        
    /**	Constructor which will set the column_fields in this object
	 */
	function WorkDay() {
		$this->log =LoggerManager::getLogger('WorkDay');
		$this->log->debug("Entering WorkDay() method ...");
		$this->db = PearDatabase::getInstance();
		$this->column_fields = getColumnFields('WorkDay');
		$this->log->debug("Exiting WorkDay method ...");
	}

	function save_module($module)
	{
	    
	}

}


