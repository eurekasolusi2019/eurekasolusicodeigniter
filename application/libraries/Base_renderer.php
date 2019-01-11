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
 * Base_renderer Class
 * 
 * This class ...
 * 
 * @author eurek
 */
class Base_renderer {

    public function __construct() {
        $this->CI = &get_instance();
    }

    // --------------------------------------------------------------------

    public function index() {
        
    }

    public function initialize_page_data() {

//        $this->CI = &get_instance();
        //--- initialize page attributes, might be overriden later
        $htmlpageattr = array(
            'apple-touch-icon' => '../assets/paper-dashboard/img/apple-icon.png',
            'icon' => '../assets/paper-dashboard/img/favicon.png',
            'title' => $this->CI->esci_app_name . ' - ' . $this->CI->esci_app_version
        );
        $this->CI->view_data['htmlpageattr'] = $htmlpageattr;

        $this->CI->view_data['esci_debug_info'] = $this->CI->esci_debug_info;
        $this->CI->view_data['site_url'] = site_url();

        $this->CI->view_data['site_label'] = $this->CI->esci_app_name . ' - ' . $this->CI->esci_app_version;

        $this->CI->view_data['site_logo'] = TRUE;
        $this->CI->view_data['site_logo_img_src'] = site_url() . '/assets/paper-dashboard/img/logo-small.png';

        $this->CI->view_data['page_title_lable'] = $this->CI->esci_app_name . ' - ' . $this->CI->esci_app_version;

        $this->CI->view_data['page_footer_nav_items'] = array();
        $this->CI->view_data['page_footer_nav_items'][] = array(
            'href' => 'https://www.creative-tim.com',
            'caption' => 'Creative Tim',
            'target' => '_blank');
        $this->CI->view_data['page_footer_nav_items'][] = array(
            'href' => 'https://blog.creative-tim.com',
            'caption' => 'Blog',
            'target' => '_blank');
        $this->CI->view_data['page_footer_nav_items'][] = array(
            'href' => 'https://www.creative-tim.com/license',
            'caption' => 'Licenses',
            'target' => '_blank');


        $this->CI->view_data['page_footer_copyright'] = '2019, made with <i class="fa fa-heart heart"></i> by Creative Tim';
        if (!isset($this->CI->view_data['display_setting'])) {
            $this->CI->view_data['display_setting'] = TRUE;
        }

        $this->CI->view_data['side_nav_last_item'] = array(
            'href' => 'https://www.creative-tim.com/upgrade.html',
            'caption' => 'Upgrade to PRO',
            'iclass' => 'nc-icon nc-spaceship',
            'target' => ''
        );
    }

    public function render_page_elements() {


        $this->CI->view_data['html_head'] = $this->render_html_head();
        $this->CI->view_data['page_logo'] = $this->render_page_logo();
        $this->CI->view_data['page_js_bottom'] = $this->render_page_js_bottom();
        $this->CI->view_data['page_footer'] = $this->render_page_footer();
        $this->CI->view_data['page_sidebar_nav'] = $this->render_page_sidebar_nav();
        $this->CI->view_data['page_main_navbar'] = $this->render_page_main_navbar();
    }

    // --------------------------------------------------------------------
    public function render_html_head() {


        $html = $this->CI->twig->render('pg_html_head', $this->CI->view_data);
        return $html;
    }

    public function render_page_logo() {


        $html = $this->CI->twig->render('pg_logo', $this->CI->view_data);
        return $html;
    }

    public function render_page_js_bottom() {


        $html = $this->CI->twig->render('pg_js_bottom', $this->CI->view_data);
        return $html;
    }

    public function render_page_footer() {


        $html = $this->CI->twig->render('pg_footer', $this->CI->view_data);
        return $html;
    }

    public function render_page_sidebar_nav() {


        $html = $this->CI->twig->render('pg_sidebar_nav', $this->CI->view_data);
        return $html;
    }

    public function render_page_main_navbar() {

        $html = $this->CI->twig->render('pg_main_navbar', $this->CI->view_data);
        return $html;
    }

}
