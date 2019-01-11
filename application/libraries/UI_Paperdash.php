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
 * UI_Paperdash Class
 * 
 * This class serve Paperdash specific configuration
 * 
 * @author eurek
 */
class UI_Paperdash {

    public $tpldir = 'paperdash';

    public function __construct() {
        log_message('application_debug', 'class:' . get_class($this) . ' function:' . __FUNCTION__);
    }

    // --------------------------------------------------------------------

}
