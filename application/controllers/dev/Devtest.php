<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Devtest extends ESCI_Controller {

    public function index() {

        $twig_config = [
            'paths' => [APPPATH. '/views/twig_based', VIEWPATH]
        ];
        $this->load->library('twig', $twig_config);
        
        
        $this->view_data['name']= 'just a test';

        $data = array('name' => 'just a test');

        $this->twig->display('welcome', $this->view_data);
    }
    
    public function table(){
        $twig_config = [
            'paths' => [APPPATH. '/views/twig_based', VIEWPATH]
        ];
        $this->load->library('twig', $twig_config);

        $this->twig->display('papdash_table', $this->view_data);
    }

}
