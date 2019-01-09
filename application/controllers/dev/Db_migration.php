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
        
        $this->show_debug_info();
    }

    public function Index() {
        echo 'ENV is ' . ENVIRONMENT . '<br>';
        echo 'loading migration library<br>';

        $this->load->library('migration');

        echo 'seems everything is okay<br>';
    }

}
