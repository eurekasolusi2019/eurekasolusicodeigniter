<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  Eurekasolusi CodeIgniter Quickstarter
 * 
 *  Intended fasten project development using the amazing CodeIgniter. Mainly based on YKKI projects.
 * 
 *  This content is released under the MIT License (MIT)
 * 
 *  @author	Yusuf for YKKI
 *  @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 *  @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 *  @copyright	Copyright (c) 2019, eurekasolusi@gmail.com
 *  @license	https://opensource.org/licenses/MIT	MIT License
 */

/**
 * EsciAuditTrail Class
 * 
 * This class ...
 * 
 * @author eurek
 */
class EsciAuditTrail {

    protected $CI;
    public $audit_trail_table = 'sys_audit_trail';

    public function __construct() {
        log_message('application_debug', 'class:' . get_class($this) . ' function:' . __FUNCTION__);
        $this->CI = &get_instance();
    }

    // --------------------------------------------------------------------

    public function crud_insert($subject, $table_name, $stateParameters) {
        //--- prepare data
        $dbin = $this->set_dbin_crud_insert($subject, $table_name, $stateParameters);
        //--- insert data to audit trail table
        $this->CI->db->insert($this->audit_trail_table, $dbin);
    }

    protected function set_dbin_crud_insert($subject, $table_name, $stateParameters) {

        $_crud_letter = 'C';
        
$data = $_POST['data'];
        $dbin = array();
        $dbin['subject'] = $subject;
        $dbin['table'] = $table_name;
        $dbin['table_id'] = $stateParameters->insertId;
        $dbin['saved_object'] = json_encode($this->sanitize_row_data($data));
        $dbin['crud_type'] = $_crud_letter;
        $dbin['_created_at'] = $this->CI->app_current_time;
        $dbin['_created_by'] = $this->CI->app_current_user->id;
        return $dbin;
    }

    // --------------------------------------------------------------------


    public function crud_update($subject, $table_name, $primary_key_fld, $stateParameters) {
        //--- prepare data
        $dbin = $this->set_dbin_crud_update($subject, $table_name, $primary_key_fld, $stateParameters);
        //--- insert data to audit trail table
        $this->CI->db->insert($this->audit_trail_table, $dbin);
    }

    protected function set_dbin_crud_update($subject, $table_name, $primary_key_fld, $stateParameters) {

        $_crud_letter = 'U';

        $previous_data = $this->get_data_before_update_delete($table_name, $primary_key_fld, $stateParameters->primaryKeyValue);

        $dbin = array();
        $dbin['subject'] = $subject;
        $dbin['table'] = $table_name;
        $dbin['table_id'] = $previous_data->$primary_key_fld;
        $dbin['saved_object'] = json_encode($previous_data);
        $dbin['crud_type'] = $_crud_letter;
        $dbin['_created_at'] = $this->CI->app_current_time;
        $dbin['_created_by'] = $this->CI->app_current_user->id;
        return $dbin;
    }

    // --------------------------------------------------------------------

    public function crud_delete($subject, $table_name, $primary_key_fld, $stateParameters) {
        //--- prepare data
        $dbin = $this->set_dbin_crud_delete($table_name, $primary_key_fld, $stateParameters);
        //--- insert data to audit trail table
        $this->CI->db->insert($this->audit_trail_table, $dbin);
    }

    protected function set_dbin_crud_delete($subject, $table_name, $primary_key_fld, $stateParameters) {

        $_crud_letter = 'D';

        $previous_data = $this->get_data_before_update_delete($table_name, $primary_key_fld, $stateParameters->primaryKeyValue);

        $dbin = array();
        $dbin['subject'] = $subject;
        $dbin['table'] = $table_name;
        $dbin['table_id'] = $stateParameters->primaryKeyValue;
        $dbin['saved_object'] = json_encode($previous_data);
        $dbin['crud_type'] = $_crud_letter;
        $dbin['_created_at'] = $this->CI->app_current_time;
        $dbin['_created_by'] = $this->CI->app_current_user->id;
        return $dbin;
    }

    // --------------------------------------------------------------------

    protected function get_data_before_update_delete($table_name, $primary_key_fld, $id) {
        $this->CI->db->where($primary_key_fld, $id);
        $result = $this->CI->db->get($table_name)->row();

        $sanitized_row = $this->sanitize_row_data($result);

        return $sanitized_row;
    }

    protected function sanitize_row_data($row) {
        foreach ($row as $key => $val) {
            if (empty($val)) {
                unset($row->$key);
            }
            if (strpos($key, 'password') !== false) {
                unset($row->$key);
            }
        }
        return $row;
    }

    // --------------------------------------------------------------------
}
