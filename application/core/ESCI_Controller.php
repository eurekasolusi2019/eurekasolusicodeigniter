<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ESCI_Controller extends CI_Controller {

    /**
     * --- application info ---
     * 
     * application name
     * @var string
     * */
    protected $esci_app_name;

    /**
     * application version
     * @var string
     */
    protected $esci_app_version;
    protected $esci_debug_info;

    /**
     * data for view
     * @var array of string
     */
    protected $view_data = array();

    public function __construct() {
        parent::__construct();
        $this->esci_app_name = $this->config->item('esci_app_name');
        $this->esci_app_version = $this->config->item('esci_app_version');

        //--- avoid config:auto loader, load here
        $this->load->database();
        $this->load->add_package_path(FCPATH . 'vendor/ion_auth/');

        //--- avoid config:auto loader, load here
        $this->load->library(
                array('session', 'escihybridauth', 'form_validation')
        );
        $this->load->helper(
                array('url', 'form', 'html', 'language')
        );

        $this->load->library('ion_auth');
        $this->load->library('escihybridauth');

        //--- debhug info
        $this->esci_debug_info = array(
            'database_name' => $this->db->database,
            'database_host' => $this->db->hostname
        );

        //--- initialize page attributes, might be overriden later
        $htmlpageattr = array(
            'apple-touch-icon' => '../assets/paper-dashboard/img/apple-icon.png',
            'icon' => '../assets/paper-dashboard/img/favicon.png',
            'title' => $this->esci_app_name . ' - ' . $this->esci_app_version
        );
        $this->view_data['htmlpageattr'] = $htmlpageattr;

        $this->view_data['esci_debug_info'] = $this->esci_debug_info;
        $this->view_data['site_url'] = site_url();

        $this->view_data['site_label'] = $this->esci_app_name . ' - ' . $this->esci_app_version;

        $this->view_data['site_logo'] = TRUE;
        $this->view_data['site_logo_img_src'] = site_url() . '/assets/paper-dashboard/img/logo-small.png';

        $this->view_data['page_title_lable'] = $this->esci_app_name . ' - ' . $this->esci_app_version;

        $this->view_data['page_footer_nav_items'] = array();
        $this->view_data['page_footer_nav_items'][] = array(
            'href' => 'https://www.creative-tim.com',
            'caption' => 'Creative Tim',
            'target' => '_blank');
        $this->view_data['page_footer_nav_items'][] = array(
            'href' => 'https://blog.creative-tim.com',
            'caption' => 'Blog',
            'target' => '_blank');
        $this->view_data['page_footer_nav_items'][] = array(
            'href' => 'https://www.creative-tim.com/license',
            'caption' => 'Licenses',
            'target' => '_blank');


        $this->view_data['page_footer_copyright'] = '2019, made with <i class="fa fa-heart heart"></i> by Creative Tim';

        $this->view_data['display_setting'] = TRUE;


// should do nav generation here
        //then.... :

        $this->view_data['side_nav_last_item'] = array(
            'href' => 'https://www.creative-tim.com/upgrade.html',
            'caption' => 'Upgrade to PRO',
            'iclass' => 'nc-icon nc-spaceship',
            'target' => ''
        );



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

    public function show_debug_info() {
        foreach ($this->esci_debug_info as $key => $val) {
            echo $key . ':' . $val . '<br>';
        }
    }

}
