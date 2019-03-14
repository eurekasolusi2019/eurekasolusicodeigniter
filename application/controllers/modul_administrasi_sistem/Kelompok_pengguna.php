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
 * Kelompok_pengguna Class
 * 
 * This class ...
 * 
 * @author eurek
 */
class Kelompok_pengguna extends ESCI_Controller {

    public $curnavlevel_1 = 'administrasi_sistem';
    public $curnavlevel_2 = 'pengguna';
    public $init_crud_on_construct = FALSE;
    public $crud;
    public $gc_app_tbl_name = '';
    public $gc_app_subject = 'Kelompok_pengguna';
    public $gc_app_tbl_key = 'id';
    //
    //--- authentication params
    //TODO: protected $require_login = TRUE;
    protected $require_login = FALSE;

    public function __construct() {
        parent::__construct();
        $this->htmlpageattr['title'] = $this->gc_app_subject . ' | ' . $this->esci_app_name . ' - ' . $this->esci_app_version;

        $this->load->config('ion_auth', TRUE);
        $this->ionauth_tables = $this->config->item('tables', 'ion_auth');
        $this->ionauth_join = $this->config->item('join', 'ion_auth');
        $this->ionauth_default_group = $this->config->item('default_group', 'ion_auth');
        $this->ionauth_admin_group = $this->config->item('admin_group', 'ion_auth');
    }

    // --------------------------------------------------------------------

    public function index() {

        $this->view_data['display_setting'] = true;
        $this->view_data['content_title'] = 'Manajemen Kelompok_pengguna (User Groups)';
        $this->view_data['content_subtitle'] = 'Manajemen Kelompok_pengguna (User Groups)';
        $this->view_data['content_footericon'] = 'fa fa-history';
        $this->view_data['content_footer'] = 'Any intelligent fool can make things bigger, more complex, and more violent';

        $this->view_data['module_navs'] = $this->create_module_nav();

        $this->gc_app_tbl_name = $this->ionauth_tables['groups'];
        $this->gc_app_subject = 'Kelompok Pengguna';
        $this->gc_app_tbl_key = 'id';

        //--- init GC
        $this->crud = $this->Esci_GC->gc_getGroceryCrudEnterprise();

        //--- set columns and fields
        $this->crud->columns(['name', 'description']);
        $this->crud->fields(['name', 'description', '_users']);

        //--- set relations
        $this->crud->setRelationNtoN(
                '_users', $this->ionauth_tables['users_groups'], $this->ionauth_tables['users'], $this->ionauth_join['groups'], $this->ionauth_join['users'], 'username'
        );

        //--- set display as
        $this->crud->displayAs(
                array(
                    'name' => 'Kelompok Pengguna',
                    'description' => 'Deskripsi',
                    '_users' => 'Pengguna'
                )
        );

        $output = $this->crud->render();

        $this->gc_crud_output($output);
    }

    // --------------------------------------------------------------------

    function allow_delete($primary_key) {

        // --- check if it is used by Ionauth
        $this->db->select('id');
        $this->db->where('`name` in (' . "'" . $this->ionauth_default_group . "'" . ',' . "'" . $this->ionauth_admin_group . "'" . ')');
        $result = $this->db->get($this->gc_app_tbl_name)->result_array();

        foreach ($result as $row) {
            if ($row['id'] == $primary_key) {
                $this->str_error = $this->gc_app_subject . ' digunakan oleh sistem';
                return $this->Esci_GC->_set_GC_failure_and_die($this->str_error);
            }
        }

        // --- relational database
        // : masih memiliki anggota
        $_related_tbls[] = array(
            'tblpkey' => 'id',
            'usedbytbl' => $this->ionauth_tables['users_groups'],
            'usedbykey' => $this->ionauth_join['groups'],
            'error_str' => 'Kelompok Pengguna masih memiliki anggota'
        );

        return $this->Esci_GC->check_used_in_tbls($this->db, $_related_tbls, $primary_key);
    }

    // --------------------------------------------------------------------

    function additional_callback_before_update($stateParameters) {
        if ($stateParameters->primaryKeyValue == '1') {
            
        }

        return $stateParameters;
    }

    protected function create_module_nav() {
        $module_nav = array(
            array(
                'url' => site_url('modul_administrasi_sistem/home_administrasi_sistem'),
                'href_class' => 'btn btn-link btn-primary',
                'label' => 'Halaman Utama Administrasi Sistem',
                'level' => '1'
            ),
            array(
                'url' => site_url('modul_administrasi_sistem/pengguna'),
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Pengguna',
                'level' => '3'
            ),
            array(
                'url' => site_url('modul_administrasi_sistem/site_structure'),
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Struktur Situs',
                'level' => '3'
            ),
            array(
                'url' => site_url('modul_administrasi_sistem/audit_trail'),
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Audit Trail',
                'level' => '3'
            )
        );

        $this_nav_icon = 'nc-icon nc-badge';
        $this->dummy_insert_site_structure('kelompok_pengguna', $module_nav, $this_nav_icon);
        return $module_nav;
    }

}
