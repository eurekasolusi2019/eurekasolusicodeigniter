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
//Include Composer's autoloader
include FCPATH . '/vendor/autoload.php';

//Import Hybridauth's namespace
use Hybridauth\Hybridauth;

//Now we may proceed and instantiate Hybridauth's classes
//$instance = new Hybridauth([ /* ... */ ]); ---> later on

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hybridauth Class
 * 
 * This class ...
 * 
 */
class EsciHybridauth {

    /**
     * Reference to the Hybridauth object
     *
     * @var Hybridauth
     */
    public $HA;

    /**
     * Reference to CodeIgniter instance
     *
     * @var CI_Controller
     */
    protected $CI;

    /**
     * Class constructor
     *
     * @param array $config
     */
    public function __construct($_config = array()) {

        $this->CI = & get_instance();
        // Load the HA config.
        if (!$this->CI->load->config('hybridauth')) {
            log_message('error', 'Hybridauth config does not exist.');

            return;
        }

        // Get HA config.
        $config = $this->CI->config->item('hybridauth');

        if (!empty($_config)) {
            $config = array_merge($config, $_config);
        }

        // Specify base url to HA Controller.
        $config['base_url'] = $this->CI->config->site_url('hauth/endpoint');

        try {
            // Initialize Hybridauth.
            $this->HA = new Hybridauth($config);

            log_message('info', 'Hybridauth Class is initialized.');
        } catch (Exception $e) {
            show_error($e->getMessage());
        }
    }

    /**
     * Process the HA request
     */
    public function process() {
        $this->_init('Hybrid_Endpoint');

        Hybrid_Endpoint::process();
    }

    /**
     * Initialize HA library
     *
     * @param string $class_name The class name to initialize
     *
     * @throws \Exception
     */
    //------ removed by Yusuf -------//
}
