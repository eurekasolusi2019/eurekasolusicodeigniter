<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hauth Controller Class
 */
class Hauth extends ESCI_Controller {

    /**
     * {@inheritdoc}
     */
    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('escihybridauth');
    }

    /**
     * {@inheritdoc}
     */
    public function index() {
        // Build a list of enabled providers.
        $providers = array();
        
        
var_dump($this->escihybridauth->HA->getProviders());

    foreach ($this->escihybridauth->HA->getProviders() as $provider_id) {
echo '<br>'.$provider_id . ':';
            $providers[] = anchor("hauth/window/{$provider_id}", $provider_id);
var_dump($this->escihybridauth->HA->getProviderConfig($provider_id));
        }



//        foreach ($this->escihybridauth->HA->getProviders() as $provider_id => $params) {
//echo '<br>'.$provider_id . ':';
//var_dump($params);
//            $providers[] = anchor("hauth/window/{$provider_id}", $provider_id);
//        }
echo '<br>$providers:';
var_dump($providers);
        $this->load->view('hauth/login_widget', array(
            'providers' => $providers,
        ));
    }

    /**
     * Try to authenticate the user with a given provider
     *
     * @param string $provider_id Define provider to login
     */
    public function window($provider_id) {
        $params = array(
            'hauth_return_to' => site_url("hauth/window/{$provider_id}"),
        );
        if (isset($_REQUEST['openid_identifier'])) {
            $params['openid_identifier'] = $_REQUEST['openid_identifier'];
        }
        try {
            $adapter = $this->escihybridauth->HA->authenticate($provider_id, $params);
            $profile = $adapter->getUserProfile();

            $this->load->view('hauth/done', array(
                'profile' => $profile,
            ));
        } catch (Exception $e) {
            show_error($e->getMessage());
        }
    }

    

    /**
     * Handle the OpenID and OAuth endpoint
     */
    public function endpoint() {
        $this->hybridauth->process();
    }

}
