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

    public $tpldirs = 'paperdash';
    protected $CI;

    public function __construct() {
        log_message('application_debug', 'class:' . get_class($this) . ' function:' . __FUNCTION__);

        $this->CI = &get_instance();
    }

    // --------------------------------------------------------------------

    function twig_config() {

        $twig_config = [
            'paths' => [
                APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->tpldirs . DIRECTORY_SEPARATOR,
                APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->tpldirs . DIRECTORY_SEPARATOR . 'esciauth' . DIRECTORY_SEPARATOR,
                VIEWPATH
            ],
            'functions_safe' => [
                'lang', 'form_checkbox', 'form_submit'
            ]
        ];

        return $twig_config;
    }

    // --------------------------------------------------------------------

    public function initialize_page_data() {

        //--- initialize page attributes, might be overriden later
        $htmlpageattr = array(
            'apple-touch-icon' => '../assets/paper-dashboard/img/apple-icon.png',
            'icon' => site_url() . 'assets/rapor/logoykki.png',
            'title' => $this->CI->esci_app_name . ' - ' . $this->CI->esci_app_version
        );
        
                
        if (isset($this->CI->htmlpageattr)){
            
            $htmlpageattr = array_merge($htmlpageattr, $this->CI->htmlpageattr);
            
        }
        
        $this->CI->view_data['htmlpageattr'] = $htmlpageattr;

        $this->CI->view_data['app_debug_info'] = $this->CI->app_debug_info;
        $this->CI->view_data['site_url'] = site_url();

        $this->CI->view_data['site_label'] = $this->CI->esci_app_name . ' - ' . $this->CI->esci_app_version;

        $this->CI->view_data['site_logo'] = TRUE;
        $this->CI->view_data['site_logo_text'] = $this->CI->esci_app_name;
        $this->CI->view_data['site_logo_img_src'] = site_url() . 'assets/rapor/logoykki.png';

        $this->CI->view_data['page_title_lable'] = $this->CI->esci_app_name . ' - ' . $this->CI->esci_app_version;
        $this->CI->view_data['side_nav'] = $this->extract_main_nav($this->CI->site_structure);

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
            'href' => site_url('esciauth/logout'),
            'caption' => 'Logout',
            'iclass' => 'nc-icon nc-spaceship',
            'target' => ''
        );
    }

    /**
     * extract_main_nav from site_structure
     * 
     * @param type $site_structure
     */
    public function extract_main_nav($site_structure) {

        if (!empty($site_structure)) {
            $result = array();

            foreach ($site_structure as $node) {
                if ($node['level'] == 1) {

                    $active = false;

                    if ($node['name'] == $this->CI->curnavlevel_1) {
                        $active = true;
                    }

                    $extracted = array(
                        'id' => $node['id'],
                        'active' => $active,
                        'name' => $node['name'],
                        'label' => $node['label'],
                        'url' => site_url() . $node['url'],
                        'icon' => $node['icon']
                    );
                    $result[] = $extracted;
                }
            }

            return $result;
        }
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
