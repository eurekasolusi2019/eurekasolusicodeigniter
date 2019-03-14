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
 * Site_structure Class
 * 
 * This class ...
 * 
 * @author eurek
 */
class Site_structure extends ESCI_Controller {

    public $curnavlevel_1 = 'administrasi_sistem';
    public $curnavlevel_2 = 'site_structure';
    public $init_crud_on_construct = TRUE;
    public $crud;
    public $gc_app_tbl_name = '__core_site_structure';
    public $gc_app_subject = 'Struktur Situs';
    public $gc_app_tbl_key = 'id';
    //
    //--- authentication params
    //TODO: protected $require_login = TRUE;
    protected $require_login = FALSE;

    public function __construct() {
        parent::__construct();
        $this->htmlpageattr['title'] = $this->gc_app_subject . ' | ' . $this->esci_app_name . ' - ' . $this->esci_app_version;
    }

    // --------------------------------------------------------------------

    public function index() {

        $this->view_data['display_setting'] = true;
        $this->view_data['content_title'] = 'Manajemen Struktur Situs';
        $this->view_data['content_subtitle'] = 'Manajemen Struktur Situs';
        $this->view_data['content_footericon'] = 'fa fa-history';
        $this->view_data['content_footer'] = 'Any intelligent fool can make things bigger, more complex, and more violent';

        $this->view_data['module_navs'] = $this->create_module_nav();

        //--- init GC
        $this->crud = $this->Esci_GC->gc_getGroceryCrudEnterprise();

        //--- RENDER!
        $output = $this->crud->render();

        $this->gc_crud_output($output);
    }

    // --------------------------------------------------------------------

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
                'url' => site_url('modul_administrasi_sistem/pengguna'),
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Pengguna',
                'level' => '3'
            ),
            array(
                'url' => site_url('modul_administrasi_sistem/audit_trail'),
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Audit Trail',
                'level' => '3'
            )
        );
        $this_nav_icon = 'nc-book-bookmark';
        $this->dummy_insert_site_structure('site_structure', $module_nav, $this_nav_icon);
        return $module_nav;
    }

    // --------------------------------------------------------------------
}
