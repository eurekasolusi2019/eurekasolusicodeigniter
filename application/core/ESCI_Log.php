<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Logging Class
 * @author		Eureka Solusi

 */
class ESCI_Log extends CI_Log {

    public function __construct() {
        parent::__construct();
        $this->_levels = array('ERROR' => 1, 'APPLICATION_DEBUG' => 2, 'APPLICATION_INFO' => 3, 'DEBUG' => 4, 'INFO' => 5, 'ALL' => 6);
    }

}
