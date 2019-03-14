<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'migration_base_class.php');

class Migration_site_structure extends Migration_base_class {

    public function __construct() {
        parent::__construct();
    }

    public function up() {
        log_message('application_debug', 'class:' . get_class($this) . ' function:' . __FUNCTION__);

        //-----------------------------------------------------------------------
        //--- TABLES UP!
        $this->up___core_site_structure_table();
        $this->up_site_structure_privilege_table();

        //--- CONSTRAINTS, FOREIGN KEYS
        $this->fks_and_constraints();

        echo '<p>class:' . get_class($this) . ' ' . __FILE__ . ' completed</p>';
    }

    public function up___core_site_structure_table() {
        //---- SYS SITE STRUCTURE TABLE
        // Drop table '__core_site_structure' if it exists
        $this->dbforge->drop_table('__core_site_structure', TRUE);

        // Table structure for table '__core_site_structure'
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'parent_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => FALSE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'href_class' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'label' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'url' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'icon' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'level' => array(
                'type' => 'INT',
                'constraint' => '5',
                'unsigned' => TRUE,
                'auto_increment' => FALSE
            ),
            'page_title' => array(
                'type' => 'VARCHAR',
                'constraint' => '55',
            ),
            'page_keywords' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'active' => array(
                'type' => 'INT',
                'constraint' => '1',
                'unsigned' => TRUE,
                'auto_increment' => FALSE
            ),
            '_created_at' => array(
                'type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'null' => FALSE
            ),
            '_updated_at' => array(
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ),
            '_created_by' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE
            ),
            '_updated_by' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);

        //-----------------------------------------------------------------------
        echo "CREATE TABLE " . '__core_site_structure' . "<br>";
        $this->dbforge->create_table('__core_site_structure');
        //-----------------------------------------------------------------------
        // Dumping data for table __core_site_structure
        $data = array(
            array(
                'id' => '1',
                'parent_id' => '0',
                'name' => 'penilaian',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Penilaian',
                'url' => 'modul_penilaian/home_penilaian',
                'icon' => 'nc-icon nc-trophy',
                'level' => '1',
                'page_title' => 'Penilaian',
                'page_keywords' => 'penilaian',
                'active' => '1',
                '_created_at' => '2019-01-28 12:15:23',
                '_updated_at' => '2019-01-28 12:15:23',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '2',
                'parent_id' => '0',
                'name' => 'administrasi_akademik',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Administrasi Akademik',
                'url' => 'modul_administrasi_akademik/home_administrasi_akademik',
                'icon' => 'nc-icon nc-single-copy-04',
                'level' => '1',
                'page_title' => 'Administrasi Akademik',
                'page_keywords' => 'Administrasi Akademik',
                'active' => '1',
                '_created_at' => '2019-01-28 12:15:23',
                '_updated_at' => '2019-01-28 12:15:23',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '3',
                'parent_id' => '0',
                'name' => 'pengaturan',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Pengaturan',
                'url' => 'modul_pengaturan/home_pengaturan',
                'icon' => 'nc-icon nc-ruler-pencil',
                'level' => '1',
                'page_title' => 'Pengaturan',
                'page_keywords' => 'Pengaturan',
                'active' => '1',
                '_created_at' => '2019-01-28 12:15:23',
                '_updated_at' => '2019-01-28 12:15:23',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '4',
                'parent_id' => '0',
                'name' => 'administrasi_sistem',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Administrasi Sistem',
                'url' => 'modul_administrasi_sistem/home_administrasi_sistem',
                'icon' => 'nc-icon nc-settings-gear-65',
                'level' => '1',
                'page_title' => 'Administrasi Sistem',
                'page_keywords' => 'Administrasi Sistem',
                'active' => '1',
                '_created_at' => '2019-01-28 12:15:23',
                '_updated_at' => '2019-01-28 12:15:23',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '5',
                'parent_id' => '4',
                'name' => 'pegawai',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Pegawai',
                'url' => 'modul_administrasi_sistem/pegawai',
                'icon' => 'nc-icon nc-settings-gear-65',
                'level' => '2',
                'page_title' => 'Pegawai',
                'page_keywords' => 'Pegawai',
                'active' => '1',
                '_created_at' => '2019-01-28 12:15:23',
                '_updated_at' => '2019-01-28 12:15:23',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '6',
                'parent_id' => '1',
                'name' => 'penilaian_akhir_semester',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Penilaian Akhir Semester',
                'url' => 'http://localhost/rapor/modul_penilaian/penilaian_akhir_semester',
                'icon' => 'nc-icon nc-palette',
                'level' => '2',
                'page_title' => 'Penilaian Akhir Semester',
                'page_keywords' => 'Penilaian Akhir Semester',
                'active' => '0',
                '_created_at' => '2019-01-28 12:14:29',
                '_updated_at' => '2019-01-28 12:14:29',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '7',
                'parent_id' => '2',
                'name' => 'halaman_utama_administrasi_akademik',
                'href_class' => 'btn btn-link btn-primary',
                'label' => 'Halaman Utama Administrasi Akademik',
                'url' => 'http://localhost/rapor/modul_administrasi_akademik/home_administrasi_akademik',
                'icon' => 'nc-icon nc-palette',
                'level' => '1',
                'page_title' => 'Halaman Utama Administrasi Akademik',
                'page_keywords' => 'Halaman Utama Administrasi Akademik',
                'active' => '0',
                '_created_at' => '2019-01-28 12:14:37',
                '_updated_at' => '2019-01-28 12:14:37',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '8',
                'parent_id' => '2',
                'name' => 'data_pribadi_siswa',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Data Pribadi Siswa',
                'url' => 'http://localhost/rapor/modul_administrasi_akademik/data_pribadi_siswa',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Data Pribadi Siswa',
                'page_keywords' => 'Data Pribadi Siswa',
                'active' => '0',
                '_created_at' => '2019-01-28 12:14:37',
                '_updated_at' => '2019-01-28 12:14:37',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '9',
                'parent_id' => '3',
                'name' => 'struktur_organisasi',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Struktur Organisasi',
                'url' => 'http://localhost/rapor/modul_pengaturan/struktur_organisasi',
                'icon' => 'nc-icon nc-palette',
                'level' => '2',
                'page_title' => 'Struktur Organisasi',
                'page_keywords' => 'Struktur Organisasi',
                'active' => '0',
                '_created_at' => '2019-01-28 12:15:23',
                '_updated_at' => '2019-01-28 12:15:23',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '10',
                'parent_id' => '3',
                'name' => 'periode',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Periode',
                'url' => 'http://localhost/rapor/modul_pengaturan/periode',
                'icon' => 'nc-icon nc-palette',
                'level' => '2',
                'page_title' => 'Periode',
                'page_keywords' => 'Periode',
                'active' => '0',
                '_created_at' => '2019-01-28 12:15:23',
                '_updated_at' => '2019-01-28 12:15:23',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '11',
                'parent_id' => '3',
                'name' => 'struktur_kurikulum',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Struktur Kurikulum',
                'url' => 'http://localhost/rapor/modul_pengaturan/struktur_kurikulum',
                'icon' => 'nc-icon nc-palette',
                'level' => '2',
                'page_title' => 'Struktur Kurikulum',
                'page_keywords' => 'Struktur Kurikulum',
                'active' => '0',
                '_created_at' => '2019-01-28 12:15:23',
                '_updated_at' => '2019-01-28 12:15:23',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '12',
                'parent_id' => '3',
                'name' => 'data_kompetensi',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Data Kompetensi',
                'url' => 'http://localhost/rapor/modul_pengaturan/data_kompetensi',
                'icon' => 'nc-icon nc-palette',
                'level' => '2',
                'page_title' => 'Data Kompetensi',
                'page_keywords' => 'Data Kompetensi',
                'active' => '0',
                '_created_at' => '2019-01-28 12:15:23',
                '_updated_at' => '2019-01-28 12:15:23',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '13',
                'parent_id' => '9',
                'name' => 'halaman_utama_pengaturan',
                'href_class' => 'btn btn-link btn-primary',
                'label' => 'Halaman Utama Pengaturan',
                'url' => 'http://localhost/rapor/modul_pengaturan/home_pengaturan',
                'icon' => 'nc-icon nc-palette',
                'level' => '1',
                'page_title' => 'Halaman Utama Pengaturan',
                'page_keywords' => 'Halaman Utama Pengaturan',
                'active' => '0',
                '_created_at' => '2019-01-28 12:15:27',
                '_updated_at' => '2019-01-28 12:15:27',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '14',
                'parent_id' => '9',
                'name' => 'unit',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Unit',
                'url' => 'http://localhost/rapor/modul_pengaturan/struktur_organisasi/unit',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Unit',
                'page_keywords' => 'Unit',
                'active' => '0',
                '_created_at' => '2019-01-28 12:15:27',
                '_updated_at' => '2019-01-28 12:15:27',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '15',
                'parent_id' => '9',
                'name' => 'jenjang',
                'href_class' => 'btn btn-link btn-primary',
                'label' => 'Jenjang',
                'url' => 'http://localhost/rapor/modul_pengaturan/struktur_organisasi/jenjang',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Jenjang',
                'page_keywords' => 'Jenjang',
                'active' => '0',
                '_created_at' => '2019-01-28 12:15:27',
                '_updated_at' => '2019-01-28 12:15:27',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '16',
                'parent_id' => '9',
                'name' => 'departemen',
                'href_class' => 'btn btn-link btn-success',
                'label' => 'Departemen',
                'url' => 'http://localhost/rapor/modul_pengaturan/struktur_organisasi/departemen',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Departemen',
                'page_keywords' => 'Departemen',
                'active' => '0',
                '_created_at' => '2019-01-28 12:15:27',
                '_updated_at' => '2019-01-28 12:15:27',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '17',
                'parent_id' => '9',
                'name' => 'tingkat',
                'href_class' => 'btn btn-link btn-info',
                'label' => 'Tingkat',
                'url' => 'http://localhost/rapor/modul_pengaturan/struktur_organisasi/tingkat',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Tingkat',
                'page_keywords' => 'Tingkat',
                'active' => '0',
                '_created_at' => '2019-01-28 12:15:27',
                '_updated_at' => '2019-01-28 12:15:27',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '18',
                'parent_id' => '9',
                'name' => 'kelas',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Kelas',
                'url' => 'http://localhost/rapor/modul_pengaturan/struktur_organisasi/kelas',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Kelas',
                'page_keywords' => 'Kelas',
                'active' => '0',
                '_created_at' => '2019-01-28 12:15:27',
                '_updated_at' => '2019-01-28 12:15:27',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '19',
                'parent_id' => '10',
                'name' => 'tahun_pelajaran',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Tahun pelajaran',
                'url' => 'http://localhost/rapor/modul_pengaturan/periode/tahun_pelajaran',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Tahun pelajaran',
                'page_keywords' => 'Tahun pelajaran',
                'active' => '0',
                '_created_at' => '2019-01-28 12:15:56',
                '_updated_at' => '2019-01-28 12:15:56',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '20',
                'parent_id' => '10',
                'name' => 'semester',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Semester',
                'url' => 'http://localhost/rapor/modul_pengaturan/periode/semester',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Semester',
                'page_keywords' => 'Semester',
                'active' => '0',
                '_created_at' => '2019-01-28 12:15:56',
                '_updated_at' => '2019-01-28 12:15:56',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '21',
                'parent_id' => '11',
                'name' => 'kelompok_mata_pelajaran',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Kelompok Mata Pelajaran',
                'url' => 'http://localhost/rapor/modul_pengaturan/struktur_kurikulum/kelompok_mata_pelajaran',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Kelompok Mata Pelajaran',
                'page_keywords' => 'Kelompok Mata Pelajaran',
                'active' => '0',
                '_created_at' => '2019-01-28 12:16:20',
                '_updated_at' => '2019-01-28 12:16:20',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '22',
                'parent_id' => '11',
                'name' => 'mata_pelajaran',
                'href_class' => 'btn btn-link btn-primary',
                'label' => 'Mata Pelajaran',
                'url' => 'http://localhost/rapor/modul_pengaturan/struktur_kurikulum/mata_pelajaran',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Mata Pelajaran',
                'page_keywords' => 'Mata Pelajaran',
                'active' => '0',
                '_created_at' => '2019-01-28 12:16:20',
                '_updated_at' => '2019-01-28 12:16:20',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '23',
                'parent_id' => '11',
                'name' => 'mata_pelajaran_-_tingkat',
                'href_class' => 'btn btn-link btn-success',
                'label' => 'Mata Pelajaran - Tingkat',
                'url' => 'http://localhost/rapor/modul_pengaturan/struktur_kurikulum/mata_pelajaran_tingkat',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Mata Pelajaran - Tingkat',
                'page_keywords' => 'Mata Pelajaran - Tingkat',
                'active' => '0',
                '_created_at' => '2019-01-28 12:16:20',
                '_updated_at' => '2019-01-28 12:16:20',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '24',
                'parent_id' => '11',
                'name' => 'kompetensi_inti_1',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Kompetensi Inti 1',
                'url' => 'http://localhost/rapor/modul_pengaturan/data_kompetensi/ki1',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Kompetensi Inti 1',
                'page_keywords' => 'Kompetensi Inti 1',
                'active' => '0',
                '_created_at' => '2019-01-28 12:16:50',
                '_updated_at' => '2019-01-28 12:16:50',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '25',
                'parent_id' => '11',
                'name' => 'kompetensi_inti_2',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Kompetensi Inti 2',
                'url' => 'http://localhost/rapor/modul_pengaturan/data_kompetensi/ki2',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Kompetensi Inti 2',
                'page_keywords' => 'Kompetensi Inti 2',
                'active' => '0',
                '_created_at' => '2019-01-28 12:16:50',
                '_updated_at' => '2019-01-28 12:16:50',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '26',
                'parent_id' => '11',
                'name' => 'kompetensi_inti_3',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Kompetensi Inti 3',
                'url' => 'http://localhost/rapor/modul_pengaturan/data_kompetensi/ki3',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Kompetensi Inti 3',
                'page_keywords' => 'Kompetensi Inti 3',
                'active' => '0',
                '_created_at' => '2019-01-28 12:16:50',
                '_updated_at' => '2019-01-28 12:16:50',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '27',
                'parent_id' => '11',
                'name' => 'kompetensi_inti_4',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Kompetensi Inti 4',
                'url' => 'http://localhost/rapor/modul_pengaturan/data_kompetensi/ki4',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Kompetensi Inti 4',
                'page_keywords' => 'Kompetensi Inti 4',
                'active' => '0',
                '_created_at' => '2019-01-28 12:16:50',
                '_updated_at' => '2019-01-28 12:16:50',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '28',
                'parent_id' => '11',
                'name' => 'kompetensi_dasar_1',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Kompetensi Dasar 1',
                'url' => 'http://localhost/rapor/modul_pengaturan/data_kompetensi/kd1',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Kompetensi Dasar 1',
                'page_keywords' => 'Kompetensi Dasar 1',
                'active' => '0',
                '_created_at' => '2019-01-28 12:16:50',
                '_updated_at' => '2019-01-28 12:16:50',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '29',
                'parent_id' => '11',
                'name' => 'kompetensi_dasar_2',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Kompetensi Dasar 2',
                'url' => 'http://localhost/rapor/modul_pengaturan/data_kompetensi/kd2',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Kompetensi Dasar 2',
                'page_keywords' => 'Kompetensi Dasar 2',
                'active' => '0',
                '_created_at' => '2019-01-28 12:16:50',
                '_updated_at' => '2019-01-28 12:16:50',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '30',
                'parent_id' => '11',
                'name' => 'kompetensi_dasar_3',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Kompetensi Dasar 3',
                'url' => 'http://localhost/rapor/modul_pengaturan/data_kompetensi/kd3',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Kompetensi Dasar 3',
                'page_keywords' => 'Kompetensi Dasar 3',
                'active' => '0',
                '_created_at' => '2019-01-28 12:16:50',
                '_updated_at' => '2019-01-28 12:16:50',
                '_created_by' => '0',
                '_updated_by' => '0'),
            array(
                'id' => '31',
                'parent_id' => '11',
                'name' => 'kompetensi_dasar_4',
                'href_class' => 'btn btn-link btn-warning',
                'label' => 'Kompetensi Dasar 4',
                'url' => 'http://localhost/rapor/modul_pengaturan/data_kompetensi/kd4',
                'icon' => 'nc-icon nc-palette',
                'level' => '3',
                'page_title' => 'Kompetensi Dasar 4',
                'page_keywords' => 'Kompetensi Dasar 4',
                'active' => '0',
                '_created_at' => '2019-01-28 12:16:50',
                '_updated_at' => '2019-01-28 12:16:50',
                '_created_by' => '0',
                '_updated_by' => '0')
        );

        echo "Insert into table " . '__core_site_structure' . "<br>";
        $this->db->insert_batch('__core_site_structure', $data);
    }

    public function up_site_structure_privilege_table() {

        $_thistable = 'sys_site_structure_privilege';

        //---- SYS SITE STRUCTURE PRIVILEGE TABLE
        // Drop table '__core_site_structure' if it exists
        $this->dbforge->drop_table($_thistable, TRUE);

        // Table structure for table $_thistable
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'site_structure_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => FALSE
            ),
            'sys_group_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => FALSE
            ),
            '_created_at' => array(
                'type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'null' => FALSE
            ),
            '_updated_at' => array(
                'type' => 'TIMESTAMP',
                'null' => TRUE
            ),
            '_created_by' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE
            ),
            '_updated_by' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);

        //-----------------------------------------------------------------------
        echo "CREATE TABLE " . $_thistable . "<br>";
        $this->dbforge->create_table($_thistable);
        //-----------------------------------------------------------------------
    }

    public function fks_and_constraints() {
        $_sqlstring = "
            ALTER TABLE `sys_site_structure_privilege` " .
                "ADD CONSTRAINT `fk_sys_site_structure_privilege1` " .
                "FOREIGN KEY (`site_structure_id`) REFERENCES `___core_site_structure`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

        $_sqlstring = "
            ALTER TABLE `sys_site_structure_privilege` " .
                "ADD CONSTRAINT `fk_sys_site_structure_privilege2` " .
                "FOREIGN KEY (`sys_group_id`) REFERENCES `sys_group`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";
    }

    public function down() {
        log_message('application_debug', 'class:' . get_class($this) . ' function:' . __FUNCTION__);
        echo "<p>002_site_structure.php (uninstall) started</p>";
        echo 'MIGRATION DOWN<br>';

        echo "DROP TABLE " . '__core_site_structure' . " if it exists<br>";
        $this->dbforge->drop_table('__core_site_structure', TRUE);
        echo "DROP TABLE " . 'sys_site_structure_privilege' . " if it exists<br>";
        $this->dbforge->drop_table('sys_site_structure_privilege', TRUE);
    }

}
