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
 * EsciSiteStructure Class
 * 
 * This class ...
 * 
 * @author eurek
 */
class EsciSiteStructure {

    public function __construct() {
        log_message('application_debug', 'class:' . get_class($this) . ' function:' . __FUNCTION__);

        $this->CI = &get_instance();
    }

    // --------------------------------------------------------------------

    public function esci_site_structure() {
        $site_structure = $this->get_recursive_site_structure();
        return $site_structure;
    }

    protected function get_recursive_site_structure($_parent_id = '0') {
        log_message('application_debug', 'class:' . get_class($this) . ' function:' . __FUNCTION__);

        $tbl_name = '__core_site_structure';
        $fld_parent = 'parent_id';
        $fld_primary = 'id';

        if (!$this->CI->db->table_exists($tbl_name)) {

            if (strtolower($this->CI->app_debug_info['CI_class']) == 'db_util') {
                echo $tbl_name . 'is not found but caller is ' . $this->CI->app_debug_info['CI_class'] . '<br>';
                echo 'continue...<br>';
                return NULL;
            }

            die('esci fatal error: can not find core tables... the system is not installed properly');
        }

        $query = $this->CI->db->select()
                ->from($tbl_name)
                ->where($fld_parent, $_parent_id)
                ->get();
        $db_result = $query->result_array();

        //--- now prepare for final result
        $final_result = array();

        if (!empty($db_result)) {
            foreach ($db_result as $__node) {
                $this_node = $__node;

                $this_node[$fld_primary] = $__node[$fld_primary];

                $_children = $this->get_recursive_site_structure($__node[$fld_primary]);
                if ($_children) {
                    $this_node['children'] = $_children;
                }

                $final_result[] = $this_node;
            }
        } else {
            return FALSE;
        }

        return $final_result;
    }

    // --------------------------------------------------------------------
}
