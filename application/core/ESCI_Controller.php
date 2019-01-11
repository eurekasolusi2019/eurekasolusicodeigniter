<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ESCI_Controller extends CI_Controller {

    /**
     * --- application info ---
     * 
     * application name
     * @var string
     * */
    public $esci_app_name;

    /**
     * application version
     * @var string
     */
    public $esci_app_version;
    public $esci_debug_info;

    /**
     * data for view
     * @var array of string
     */
    public $view_data = array();
    public $tpldir = 'paperdash';

    public function __construct() {
        parent::__construct();
        $this->esci_app_name = $this->config->item('esci_app_name');
        $this->esci_app_version = $this->config->item('esci_app_version');

        //--- avoid config:auto loader, load here
        $this->load->database();
        $this->load->add_package_path(FCPATH . 'vendor/ion_auth/');

        //--- avoid config:auto loader, load helpers and libraries here
        $this->load->helper(
                array('url', 'form', 'html', 'language')
        );
        $this->load->library(
                array('session', 'ion_auth', 'escihybridauth', 'form_validation')
        );

        //--- debhug info
        $this->esci_debug_info = array(
            'database_name' => $this->db->database,
            'database_host' => $this->db->hostname
        );

// should do nav generation here
        //then.... :
        //--- navigations, might be template dependent :(
        // site structure
        // public area vs restricted area
        //------ public area
        //------  -- landing page
        //------  -- login page
        //------  -- registration page
        //------ member / restricted area
        // ... site / application has modules
        // ... site / application --> page has navigation elements
        // hide search 
        // sidemenu
        // sidemenugroups
        // sidemenuitem



        $_site_menu = array(
            'type' => 'nav-item',
            'label' => 'Administrasi Sistem',
            'url' => site_url() . ' modul_admin',
            'icon' => 'icon-drop',
            'submenu' => array(
                'Groups' => array(
                    'type' => 'nav-item',
                    'label' => ' Groups',
                    'url' => site_url() . 'modul_admin/groups',
                    'icon' => 'nav-icon icon-drop'
                ),
                'Jenjang' => array(
                    'type' => 'nav-item',
                    'label' => ' Jenjang',
                    'url' => site_url() . 'modul_admin/jenjang',
                    'icon' => 'nav-icon icon-drop'
                ),
                'Unit' => array(
                    'type' => 'nav-item',
                    'label' => ' Unit',
                    'url' => site_url() . 'modul_admin/unit',
                    'icon' => 'nav-icon icon-drop'
                ),
                'User' => array(
                    'type' => 'nav-item',
                    'label' => ' User',
                    'url' => site_url() . 'modul_admin_sistem/users',
                    'icon' => 'nav-icon icon-drop'
                )
            )
        );
    }

    // --------------------------------------------------------------------

    public function initialize_twig() {

        // maybe config is enough
        $this->load->library('UI_Paperdash', NULL, 'UICONF');
        $this->UICONF->tpldir;

        $this->twig_config = [
            'paths' => [
                APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->UICONF->tpldir . DIRECTORY_SEPARATOR,
                APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->UICONF->tpldir . DIRECTORY_SEPARATOR . 'esciauth' . DIRECTORY_SEPARATOR,
                VIEWPATH],
            'functions_safe' => ['lang', 'form_checkbox', 'form_submit']
        ];

        $this->load->library('twig', $this->twig_config);
    }

    public function twig_display($view, $data) {
        $this->initialize_twig();

        $this->load->library('base_renderer');
        $this->base_renderer->initialize_page_data();
        $this->base_renderer->render_page_elements();

        //override!
        $merge_data = array_merge($this->view_data, $data);

        $this->twig->display($view, $merge_data);
    }

    // --------------------------------------------------------------------

    public function show_debug_info() {
        foreach ($this->esci_debug_info as $key => $val) {
            echo $key . ':' . $val . '<br>';
        }
    }

}
