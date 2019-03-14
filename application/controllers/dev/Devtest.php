<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Devtest extends ESCI_Controller {

    public function __construct() {
        parent::__construct();
        $twig_config = [
            'paths' => [APPPATH . '/views/paperdash', VIEWPATH]
        ];
        $this->load->library('twig', $twig_config);
    }

    public function index() {
        $this->show_debug_info();


        $class_methods = get_class_methods(get_class($this));
        echo '<br>this class methods:<br>';
        foreach ($class_methods as $method_name) {
            echo site_url() . get_class($this) . '/' . "$method_name<br>\n";
        }
    }

    public function welcome() {
//        $this->view_data['name'] = 'just a test';
//
//        $data = array('name' => 'just a test');

        $this->twig_display('welcome', $this->view_data);
    }

    public function table() {
//        $twig_config = [
//            'paths' => [APPPATH . '/views/paperdash', VIEWPATH]
//        ];
//        $this->load->library('twig', $twig_config);

        $this->twig_display('papdash_table', $this->view_data);
    }

}
