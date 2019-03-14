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
 * Pengguna Class
 * 
 * This class ...
 * 
 * @author eurek
 */
class Pengguna extends ESCI_Controller {

    public $curnavlevel_1 = 'administrasi_sistem';
    public $curnavlevel_2 = 'pengguna';
    public $init_crud_on_construct = FALSE;
    public $crud;
    public $gc_app_tbl_name = '';
    public $gc_app_subject = 'Pengguna';
    public $gc_app_tbl_key = 'id';
    //
    //--- authentication params
    //TODO: protected $require_login = TRUE;
    protected $require_login = TRUE;

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
        $this->view_data['content_title'] = 'Manajemen Pengguna (User Account)';
        $this->view_data['content_subtitle'] = 'Manajemen Pengguna (User Account)';
        $this->view_data['content_footericon'] = 'fa fa-history';
        $this->view_data['content_footer'] = 'Any intelligent fool can make things bigger, more complex, and more violent';

        $this->view_data['module_navs'] = $this->create_module_nav();

        $this->gc_app_tbl_name = $this->ionauth_tables['users'];

        //--- init GC
        $this->crud = $this->Esci_GC->gc_getGroceryCrudEnterprise();

        //--- set columns and fields
        $this->crud->columns(['username', 'email', 'active']);
        $this->crud->fields(['username', 'email', 'active', '_groups', '_pegawai', '_login_email']);

        $this->crud->fieldType('active', 'checkbox_boolean');
        $this->crud->uniqueFields(['username', 'email']);

        //--- set relations
        $this->crud->setRelationNtoN(
                '_groups', 'sys_users_groups', 'sys_groups', $this->ionauth_join['users'], $this->ionauth_join['groups'], 'name'
        );
        $this->crud->setRelationNtoN(
                '_pegawai', 'apl_pegawai_users', 'apl_pegawai', $this->ionauth_join['users'], 'pegawai_id', 'nama_pegawai'
        );
        $this->crud->setRelationNtoN(
                '_login_email', 'sys_users_external_auths', 'sys_external_auths', 'user_id', 'external_auth_id', 'identity'
        );

        //--- set display as
        $this->crud->displayAs(
                array(
                    'username' => 'Nama untuk Login',
                    'email' => 'Surel (email)',
                    'active' => 'Aktif',
                    '_groups' => 'Kelompok Pengguna',
                    '_pegawai' => 'Nama Pegawai',
                    '_login_email' => 'Email untuk Login'
                )
        );

        //--- set ActionButtons
        $this->crud->setActionButton('Hak Akses Pengguna', 'fa fa-folder', function ($row) {
            return site_url() . 'modul_administrasi_sistem/pengguna/hak_akses_pengguna/' . $row->id;
        }, false);

        //--- RENDER!
        $output = $this->crud->render();

        $this->gc_crud_output($output);
    }

    // --------------------------------------------------------------------

    /**
     * Hak Akses Pengguna:
     * atas unit <--- tidak perlu lagi
     * atas jenjang <--- tidak perlu lagi
     * atas departemen <--- tidak perlu juga?
     * sebagai pegawai yang mana
     * 
     * hubungan sebagai role / group yang mana...
     * 
     */
    public function hak_akses_pengguna_departemen() {

        die('sementara di sini dulu');
    }

    // --------------------------------------------------------------------

    protected function allow_delete($primary_key) {

        // TODO:
        // --- tidak boleh sama dengan user account sendiri
        // 
        // --- seharusnya dengan aturan di atas tidak perlu cek lagi apakah system admin tinggal satu
        // --- relational database
        // : masih digunakan oleh pegawai
        $_related_tbls[] = array(
            'tblpkey' => 'id',
            'usedbytbl' => 'apl_pegawai_users',
            'usedbykey' => $this->ionauth_join['users'],
            'error_str' => 'Akun Pengguna masih terkait ke pegawai'
        );

        return $this->Esci_GC->check_used_in_tbls($this->db, $_related_tbls, $primary_key);
    }

    // --------------------------------------------------------------------

    function additional_callback_before_update($stateParameters) {
        return $stateParameters;
        if ($stateParameters->primaryKeyValue == '1') {

            if (!isset($_POST['data']['_groups'])) {
                $this->str_error = 'super admin harus menjadi anggota group ' . $this->ionauth_admin_group;
                return $this->Esci_GC->_set_GC_failure_and_die($this->str_error);
            }

            $this->db->select('id');
            $this->db->where('`name` = ' . "'" . $this->ionauth_admin_group . "'");
            $admin_group = $this->db->get($this->ionauth_tables['groups'])->row();

            $requested_groups = explode(',', $_POST['data']['_groups']);

            if (!in_array($admin_group->id, $requested_groups)) {
                $this->str_error = 'super admin harus menjadi anggota group ' . $this->ionauth_admin_group;
                return $this->Esci_GC->_set_GC_failure_and_die($this->str_error);
            }
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
                'url' => site_url('modul_administrasi_sistem/kelompok_pengguna'),
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Kelompok Pengguna',
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
                'label' => 'Audit Trail'
            )
        );
        $this_nav_icon = 'nc-icon nc-satisfied';
        $this->dummy_insert_site_structure('pengguna', $module_nav, $this_nav_icon);
        return $module_nav;

    }

}
