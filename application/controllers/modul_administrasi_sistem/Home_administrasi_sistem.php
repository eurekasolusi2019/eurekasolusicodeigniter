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
 * Description of Home_administrasi_sistem
 * 
 * This class ...
 *
 * @author eurek
 */
class Home_administrasi_sistem extends ESCI_Controller {

    public function __construct() {
        parent::__construct();
        $this->htmlpageattr['title'] = 'Administrasi Sistem | ' . $this->esci_app_name . ' - ' . $this->esci_app_version;
    }

    public function index() {

        $this->view_data['display_setting'] = true;

        $this->view_data['content_title'] = 'Modul Administrasi Sistem';
        $this->view_data['content_subtitle'] = 'Dashboard Modul Administras Sistem';
        $this->view_data['content_footericon'] = 'fa fa-history';
        $this->view_data['content_footer'] = 'Patient is s virtue';

        $this->view_data['module_navs'] = $this->create_module_nav();

        $this->view_data['output'] = 'belum ada isinya<br>';

        $this->twig_display('module_dashboard', $this->view_data);
    }

    // --------------------------------------------------------------------

    protected function create_module_nav() {
        $module_nav = array(
            array(
                'url' => site_url('modul_administrasi_sistem/pengguna'),
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Pengguna',
                'level' => '2'
            ),
            array(
                'url' => site_url('modul_administrasi_sistem/kelompok_pengguna'),
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Kelompok Pengguna',
                'level' => '2'
            ),
            array(
                'url' => site_url('modul_administrasi_sistem/site_structure'),
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Struktur Situs',
                'level' => '2'
            ),
            array(
                'url' => site_url('modul_administrasi_sistem/audit_trail'),
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Audit Trail',
                'level' => '2'
            )
        );
        $this_nav_icon = 'nc-icon nc-settings';
        $this->dummy_insert_site_structure('administrasi_sistem', $module_nav, $this_nav_icon);
        return $module_nav;
    }
    // --------------------------------------------------------------------

}
