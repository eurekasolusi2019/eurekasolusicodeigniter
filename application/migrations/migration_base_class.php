<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * migration_base_class Class
 * 
 * This class ...
 * 
 * @author eurek
 */
class Migration_base_class extends CI_Migration {
    protected $recordofkeys = array();

    public function __construct() {
        parent::__construct();

        echo get_class($this) . ' extends CI_Migration<br>';
        echo 'load dbforge...<br>';
        $this->load->dbforge();
        echo '<p>class:<strong>' . get_class($this) . '</strong> ' . __FILE__ . ' started</p>';
        echo '--- MIGRATION UP ---<br>';
    }

    public function extended_create_table($tblname, $fields, $keys) {
        // DROP TABLE '...' if it exists
        echo "DROP TABLE <strong>" . $tblname . "</strong> if it exists<br>";
        $this->dbforge->drop_table($tblname, TRUE);

        echo "<strong>CREATE TABLE " . $tblname . "</strong><br>";
        // Table structure for table 'apl_siswa_kelas'
        $this->dbforge->add_field($fields);

        echo "ADD KEYS TO TABLE " . $tblname . "<br>";
        if (!empty($keys)) {
            foreach ($keys as $keyOfkeys => $valOfkeys) {
                $this->create_table_key($keyOfkeys, $valOfkeys);
            }
        }

        //-----------------------------------------------------------------------

        $this->dbforge->create_table($tblname);
        //-----------------------------------------------------------------------
    }

    public function create_table_key($fieldname = 'id', $is_primary_key = TRUE) {
        $this->dbforge->add_key($fieldname, $is_primary_key);

        echo "... add KEY <strong>$fieldname</strong>, is_primary_key: $is_primary_key IS CREATED<br>";
    }

    public function create_unique_key($tablename, $fieldname) {

        $constraint_name = 'uq_' . $tablename . '_' . $fieldname;

        $_sqlstring = "
            ALTER TABLE " . $tablename . " " .
                "ADD CONSTRAINT `$constraint_name` " .
                "UNIQUE (`$fieldname`);";
        $this->db->query($_sqlstring);
        echo "UNIQUE KEY $constraint_name FOR $fieldname IN $tablename IS CREATED<br>";
    }

    public function create_foreign_key($tablename, $thistablekey, $foreigntable, $foreigntablekey = 'id', $action = 'ON DELETE CASCADE ON UPDATE NO ACTION') {
        
        echo "... add FOREIGN KEY <strong>$tablename - $thistablekey</strong> to <strong>$foreigntable - $foreigntablekey</strong><br>";

        $constraint_name = 'fk_' . $tablename . '_' . $foreigntable;
        if (array_key_exists($constraint_name,$this->recordofkeys)){
            $this->recordofkeys[$constraint_name] = $this->recordofkeys[$constraint_name]+1;
        } else {
            $this->recordofkeys[$constraint_name] = 1;
        }
        
        $final_constraint_name = $constraint_name . $this->recordofkeys[$constraint_name];
        
        $_sqlstring = "
            ALTER TABLE `$tablename` " .
                "ADD CONSTRAINT `$final_constraint_name` " .
                "FOREIGN KEY (`$thistablekey`) REFERENCES `$foreigntable`(`$foreigntablekey`) "
                . "ON DELETE CASCADE ON UPDATE NO ACTION"
                . ";";
//        echo "$_sqlstring<br>";
        $this->db->query($_sqlstring);
    }

    // --------------------------------------------------------------------
}
