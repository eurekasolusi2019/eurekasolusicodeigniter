<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Db_util
 *
 * @author eurek
 */
class Db_util extends ESCI_Controller {

    public function index() {
        $this->show_debug_info();
        $class_methods = get_class_methods('Db_util');
        foreach ($class_methods as $method_name) {
            echo "$method_name<br>\n";
        }
    }

    public function dropalltables() {

        echo "--- dropalltables START --- <br>";
        $_sqlstring = "SHOW TABLES;";

        echo "executing $_sqlstring ...<br>";
        $dbquery_result = $this->db->query($_sqlstring)->result();

        $tables = array();
        if (!empty($dbquery_result)) {
            $this->load->dbforge();

            //--- turn off foreign key restriction
            $_sqlstring = "SET FOREIGN_KEY_CHECKS=0;";
            $this->db->query($_sqlstring);
            echo "$_sqlstring<br>";

            //--- loop to drop each tables
            foreach ($dbquery_result as $resultobj) {
                $tablename = $resultobj->Tables_in_es_ci;

                echo "DROP TABLE " . $tablename . " if it exists<br>";
                $this->dbforge->drop_table($tablename, TRUE);
            }

            //--- turn on foreign key restriction
            $_sqlstring = "SET FOREIGN_KEY_CHECKS=1;";
            $this->db->query($_sqlstring);
            echo "$_sqlstring<br>";
        }

        echo "--- dropalltables COMPLETED --- <br>";
    }

}
