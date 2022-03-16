<?php

class Mandub extends CRMEntity {
        var $table_name = 'vtiger_mandub';
        var $table_index= 'mandubid';
          
        var $customFieldTable = Array('vtiger_mandubcf', 'mandubid');

        var $tab_name = Array('vtiger_crmentity', 'vtiger_mandub', 'vtiger_mandubcf');

        var $tab_name_index = Array(
                'vtiger_crmentity' => 'crmid',
                'vtiger_mandub' => 'mandubid',
                'vtiger_mandubcf'=>'mandubid');

        var $list_fields = Array (
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'name' => Array('mandub', 'name'),
                'Assigned To' => Array('crmentity','smownerid')
        );
        var $list_fields_name = Array (
                /* Format: Field Label => fieldname */
                'name' => 'name',
                'Assigned To' => 'assigned_user_id',
        );

        // Make the field link to detail view
        var $list_link_field = 'name';

        // For Popup listview and UI type support
        var $search_fields = Array(
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'name' => Array('mandub', 'name'),
                'Assigned To' => Array('vtiger_crmentity','assigned_user_id'),
        );
        var $search_fields_name = Array (
                /* Format: Field Label => fieldname */
                'name' => 'name',
                'Assigned To' => 'assigned_user_id',
        );

        // For Popup window record selection
        var $popup_fields = Array ('name');

        // For Alphabetical search
        var $def_basicsearch_col = 'name';

        // Column value to use on detail view record text display
        var $def_detailview_recname = 'name';

        // Used when enabling/disabling the mandatory fields for the module.
        // Refers to vtiger_field.fieldname values.
        var $mandatory_fields = Array('name','assigned_user_id');

        var $default_order_by = 'name';
        var $default_sort_order='ASC';
        
        
    /** Constructor which will set the column_fields in this object
     */
    function Mandub() {
        $this->log =LoggerManager::getLogger('Mandub');
        $this->log->debug("Entering Mandub() method ...");
        $this->db = PearDatabase::getInstance();
        $this->column_fields = getColumnFields('Mandub');
        $this->log->debug("Exiting Mandub method ...");
    }

    function save_module($module)
    {
        
    }

}

