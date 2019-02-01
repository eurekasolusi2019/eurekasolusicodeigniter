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
 * Db_util
 * 
 * This class ...
 *
 * @author eurek
 */
class Db_util extends ESCI_Controller {

    /**
     *
     * @var type 
     */
    protected $require_login = FALSE;

    public function index() {
        $this->show_debug_info();
        $class_methods = get_class_methods('Db_util');
        foreach ($class_methods as $method_name) {
            echo "$method_name<br>\n";
        }
    }

    public function dataextract($tblname) {
        $query = $this->db->get($tblname);
        $q_result = $query->result_array();
        if (!empty($q_result)) {


            foreach ($q_result as $row) {
                $str_row = "\tarray (\n";
                $row_item = array();
                foreach ($row as $key => $val) {
                    $row_item[] = "\t\t '$key' \t => \t '$val'";
                }
                $str_row .= implode(",\n", $row_item);
                $str_row .= "\t)";

                $str_rows[] = $str_row;
            }
            echo "<pre>\n";
            echo "array (\n";
            echo implode(",\n", $str_rows);
            echo ")</pre>\n";
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
        echo '<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.';
        echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '';
        echo '</p>';
    }

    public function dropalltables_and_regenerate() {
        $this->dropalltables();
        redirect(site_url('/dev/db_migration/'));
    }

    public function insert_data_siswa_kelas() {
        $tblname = 'apl_siswa';
        $query = $this->db->get($tblname);
        $q_result = $query->result();

        if (!empty($q_result)) {
            $kelas_id = 1;
            foreach ($q_result as $row) {

                var_dump($row);
                if ($row->id > 20)
                    $kelas_id = 2;
                if ($row->id > 40)
                    $kelas_id = 3;
                if ($row->id > 60)
                    $kelas_id = 4;
                if ($row->id > 83)
                    $kelas_id = 5;
                if ($row->id > 104)
                    $kelas_id = 6;
                $dbin = array(
                    'siswa_id' => $row->id,
                    'kelas_id' => $kelas_id,
                );

                $this->db->insert('apl_siswa_kelas', $dbin);
            }
        }
    }

    public function insert_data_mata_pelajaran_tingkat() {
        $tblname = 'apl_tingkat';
        $query = $this->db->get($tblname);
        $q_result = $query->result();

        if (!empty($q_result)) {
            $kelas_id = 1;
            foreach ($q_result as $row) {

                var_dump($row);
                
                $query_mp = $this->db->get('apl_mata_pelajaran');
                $qmp_result = $query->result();
                
                foreach ($qmp_result as $qmp_row){
                    $dbin = array(
                        'tingkat_id' => $row->id,
                        'mata_pelajaran_id' => $qmp_row->id
                    );
                    $this->db->insert('apl_mata_pelajaran_tingkat', $dbin);
                }
                
                
                
//                if ($row->id > 20)
//                    $kelas_id = 2;
//                if ($row->id > 40)
//                    $kelas_id = 3;
//                if ($row->id > 60)
//                    $kelas_id = 4;
//                if ($row->id > 83)
//                    $kelas_id = 5;
//                if ($row->id > 104)
//                    $kelas_id = 6;

//
//                $this->db->insert('apl_siswa_kelas', $dbin);
            }
        }
    }

}
