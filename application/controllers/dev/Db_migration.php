<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Db_migration
 *
 * @author eurek
 */
class Db_migration extends ESCI_Controller {

    public function __construct() {
        parent::__construct();
        // $this->load->helper('ui_coreui');
        $this->construct_page_elements();

    }
    
    public function Index() {
        $this->load->library('migration');
        
        echo 'seems everything is okay';
        
    }

}
