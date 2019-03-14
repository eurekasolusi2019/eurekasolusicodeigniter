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
 * ESCI_Controller Class
 * 
 * This class ...
 * 
 * @author eurek
 */
class ESCI_Controller extends CI_Controller {

    /**
     * --- application info ---
     * 
     * application name
     * @var string
     * */
    public $esci_app_name;
    public $esci_app_owner;

    /**
     * application version
     * @var string
     */
    public $esci_app_version;

    /**
     *
     * @var type 
     */
    protected $require_login = TRUE;

    /**
     * esci_UI Library
     * @var object
     */
    public $Esci_UI;

    /**
     * esci_Site Structure Library
     * @var object
     */
    public $Esci_ST;

    /**
     * esci_GC Grocery Crud Library
     * @var object
     */
    public $Esci_GC;

    /**
     * data for view
     * @var array of string
     */
    public $view_data = array();
    public $curnavlevel_1 = '';
    public $curnavlevel_2 = '';
    public $UI_lib = 'UI_Paperdash';
    public $tpldir = 'paperdash';

    /**
     *
     * @var type 
     */
    public $allow_delete_function = FALSE;

    /**
     *
     * @var type 
     */
    public $app_current_time;

    /**
     *
     * @var type 
     */
    public $app_current_user;

    /**
     * debug info
     * @var string
     */
    public $app_debug_info;

    /**
     * Constructor
     * 
     * @return type
     */
    public function __construct() {
        parent::__construct();
        log_message('application_debug', 'class:' . get_class($this) . ' function:' . __FUNCTION__);

        //--- set current time, set it here so that ther is one standardized timestamp
        $this->app_current_time = date("Y-m-d H:i:s");

        //--- initiate debug info
        $this->app_debug_info = array();
        $this->app_debug_info['CI_class'] = get_class($this);

        $this->esci_app_name = $this->config->item('esci_app_name');
        $this->esci_app_owner = $this->config->item('esci_app_owner');
        $this->esci_app_version = $this->config->item('esci_app_version');

        //--- avoid config:auto loader, load here
        $this->load->database();
        $this->load->add_package_path(FCPATH . 'vendor/ion_auth/');

        //--- avoid config:auto loader, load helpers and libraries here
        $this->load->helper(
                array('url', 'form', 'html', 'language')
        );

        $this->load->library(
                array('session', 'ion_auth', 'form_validation') // removed 'escihybridauth'
        );

        //--- load as Esci_AT
        //--- do we need to separate the object...
        $this->load->library('EsciAuditTrail', NULL, 'Esci_AT');

        //--- as soon as session libarary is loaded
        $this->session_flashdata = $this->session->flashdata();
        if (isset($this->session_flashdata['message']) && !empty($this->session_flashdata['message'])) {
            $this->view_data['message'] = $this->session_flashdata['message'];
        }

        //--- check if required to login,
        //- if required to login but user not yet logged in, redirect to login page
        if ($this->require_login) {
            log_message('application_info', 'check_if_login');
            $this->check_if_login();
        }

        //--- if logged in, copy privilege and other auth data from session to this CI Object
        //- get privilege from group membership or admin status
        $this->app_current_user = new stdClass();
        if ($this->ion_auth->logged_in()) {
            $this->get_auth_params_from_session();
        } else {
            $this->app_current_user->id = '0';
            $this->app_current_user->identity = '-';
            $this->app_current_user->username = '-';
        }
        //--- debug info
        $this->app_debug_info['database_name'] = $this->db->database;
        $this->app_debug_info['database_host'] = $this->db->hostname;

        //--- do we need to show UI???
        if (get_class($this) !== 'Db_migration') {
            $this->initialize_esci_st();
            $this->initialize_esci_ui();
        } else {
            //--- no need UI, the state of application is setup or maintenance
            return;
        }
    }

    /*
     * ---------------------------------------------------------------
     * AUTHENTICATION METHODS
     * ---------------------------------------------------------------
     *
     */

    /**
     * check if login,
     * redirect to login page (... /esciauth/login) if not logged in
     *
     * @return type
     */
    private function check_if_login() {
        log_message('application_info', 'class:' . get_class($this) . ' function:' . __FUNCTION__);

        if (!$this->ion_auth->logged_in()) {
            redirect('esciauth/login');
        }
    }

    // -------------------------------------------------------------------------

    public function get_auth_params_from_session() {

        $this->app_current_user->id = $_SESSION['user_id'];
        $this->app_current_user->identity = $_SESSION['identity'];
        $this->app_current_user->username = $_SESSION['username'];
    }

    public function show_debug_info() {
        foreach ($this->app_debug_info as $key => $val) {
            echo $key . ':' . $val . '<br>';
        }
    }

    // -------------------------------------------------------------------------

    /*
     * ---------------------------------------------------------------
     * INITIALIZE ESCI_SITESTRUCTURE
     * ---------------------------------------------------------------
     *
     */
    public function initialize_esci_st() {
        // instantiate Esci_ST
        $this->load->library('EsciSiteStructure', NULL, 'Esci_ST');
        // instantiate site_structure
        $this->site_structure = $this->Esci_ST->esci_site_structure();
        return;
    }

    /*
     * ---------------------------------------------------------------
     * INITIALIZE ESCI_UI
     * ---------------------------------------------------------------
     *
     */

    public function initialize_esci_ui() {
        // instantiate Esci_UI
        $this->load->library($this->UI_lib, NULL, 'Esci_UI');
        // instantiate $this->twig
        $this->initialize_twig();
        return;
    }

    // -------------------------------------------------------------------------

    /*
     * ---------------------------------------------------------------
     * TWIG FUNCTIONS / METHODS
     * ---------------------------------------------------------------
     *
     */

    public function initialize_twig() {
        return $this->load->library('twig', $this->Esci_UI->twig_config());
    }

    public function twig_display($view, $data) {

        $this->Esci_UI->initialize_page_data();
        $this->Esci_UI->render_page_elements();

        //override!
        $merge_data = array_merge($this->view_data, $data);

        $this->twig->display($view, $merge_data);
    }

    // -------------------------------------------------------------------------
}
