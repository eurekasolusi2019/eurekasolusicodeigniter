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
 * Description of Home
 * 
 * This class ...
 *
 * @author eurek
 */
class Home extends ESCI_Controller {

    protected $require_login = TRUE;

    public function index() {

        $this->view_data['display_setting'] = true;
        $this->view_data['content_title'] = 'Halaman Depan';
        $this->view_data['content_subtitle'] = 'Area Terbatas';
        $this->view_data['content_footericon'] = 'nc-icon nc-air-baloon';
        $this->view_data['content_footer'] = 'Patient is s virtue';

        if ($this->ion_auth->logged_in()) {
            $this->view_data['message'] = 'Anda telah login sebagai <strong>' . $this->app_current_user->identity . '</strong><br>';
        }

        $this->twig_display('home', $this->view_data);
    }

}
