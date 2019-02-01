<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Db_migration
 *
 * @author eurek
 */
class Db_migration extends ESCI_Controller {

    /**
     *
     * @var type 
     */
    protected $require_login = FALSE;

    public function __construct() {
        parent::__construct();

        echo 'might be you want to ';
        echo '<a href="' . site_url('dev/db_util/dropalltables_and_regenerate') . '">dropalltables_and_regenerate AGAIN</a><br>';

        $this->show_debug_info();
    }

    public function Index() {
        echo 'ENV is ' . ENVIRONMENT . '<br>';

        $_sqlstring = "SET FOREIGN_KEY_CHECKS=0;";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

        echo '<br>loading migration library<br>';
        $this->load->library('migration');

        $_sqlstring = "SET FOREIGN_KEY_CHECKS=1;";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

        echo 'seems everything is okay<br>';
    }

}
