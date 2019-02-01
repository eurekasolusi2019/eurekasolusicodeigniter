<?php

defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'migration_base_class.php');

class Migration_install_ion_auth extends Migration_base_class {

    public function __construct() {
        parent::__construct();

        echo 'load config ion_auth, we need the tables...<br>';
        $this->load->config('ion_auth', TRUE);
        $this->tables = $this->config->item('tables', 'ion_auth');
    }

    public function up() {
        log_message('application_debug', 'class:' . get_class($this) . ' function:' . __FUNCTION__);
        echo '<p>class:' . get_class($this) . __FILE__ . ' started</p>';
        echo 'MIGRATION UP<br>';

        //-----------------------------------------------------------------------
        //--- TABLES UP!
        $this->up_group_table();
        $this->up_users_table();
        $this->up_users_group_table();
        $this->up_external_authentications_table();
        $this->up_users_external_authentications_table();

        //-----------------------------------------------------------------------
        //--- CONSTRAINTS, FOREIGN KEYS
        echo "--- CONSTRAINTS, FOREIGN KEYS --- <br>";
        $this->fks_and_constraints();

        echo '<p>class:' . get_class($this) . __FILE__ . ' completed</p>';
    }

    public function up_group_table() {

        //-----------------------------------------------------------------------
        //---- GROUPS TABLE
        // DROP TABLE $this->tables['groups'] if it exists
        echo "DROP TABLE " . $this->tables['groups'] . " if it exists<br>";
        $this->dbforge->drop_table($this->tables['groups'], TRUE);

        // Table structure for table $this->tables['groups']
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
            ),
            'description' => array(
                'type' => 'VARCHAR',
                'constraint' => '250',
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
        echo "CREATE TABLE " . $this->tables['groups'] . "<br>";
        $this->dbforge->create_table($this->tables['groups']);
        //-----------------------------------------------------------------------
        // Dumping data for table $this->tables['groups']
        echo "Dumping data for table  " . $this->tables['groups'] . "<br>";
        $data = array(
            array(
                'id' => '1',
                'name' => 'superadmin',
                'description' => 'Administrator Tertinggi',
                '_created_at' => '2018-12-08 11:11:11',
                '_created_by' => '-99',
                '_updated_at' => '2018-12-08 11:11:11',
                '_updated_by' => '0'
            ),
            array(
                'id' => '2',
                'name' => 'admin',
                'description' => 'Administrator Sistem',
                '_created_at' => '2018-12-08 11:11:11',
                '_created_by' => '-99',
                '_updated_at' => '2018-12-08 11:11:11',
                '_updated_by' => '0'
            ),
            array(
                'id' => '3',
                'name' => 'terdaftar',
                'description' => 'Pengguna mungkin butuh aktivasi',
                '_created_at' => '2018-12-08 11:11:11',
                '_created_by' => '-99',
                '_updated_at' => '2018-12-08 11:11:11',
                '_updated_by' => '0'
            ),
            array(
                'id' => '4',
                'name' => 'kepsek',
                'description' => 'Kepala Sekolah',
                '_created_at' => '2018-12-08 11:11:11',
                '_created_by' => '-99',
                '_updated_at' => '2018-12-08 11:11:11',
                '_updated_by' => '0'
            ),
            array(
                'id' => '5',
                'name' => 'guru',
                'description' => 'Guru',
                '_created_at' => '2018-12-08 11:11:11',
                '_created_by' => '-99',
                '_updated_at' => '2018-12-08 11:11:11',
                '_updated_by' => '0'
            ),
            array(
                'id' => '6',
                'name' => 'dapodik',
                'description' => 'Admin Dapodik',
                '_created_at' => '2018-12-08 11:11:11',
                '_created_by' => '-99',
                '_updated_at' => '2018-12-08 11:11:11',
                '_updated_by' => '0'
            )
        );

        $this->db->insert_batch($this->tables['groups'], $data);
    }

    public function up_users_table() {

        //-----------------------------------------------------------------------
        //---- USERS TABLE
        // DROP TABLE $this->tables['users'] if it exists
        echo "DROP TABLE " . $this->tables['users'] . " if it exists<br>";
        $this->dbforge->drop_table($this->tables['users'], TRUE);

        // Table structure for table $this->tables['users']
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '45'
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '254'
            ),
            'activation_selector' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'activation_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'forgotten_password_selector' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'forgotten_password_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'forgotten_password_time' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'null' => TRUE
            ),
            'remember_selector' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => TRUE
            ),
            'remember_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => TRUE
            ),
            'last_login' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'null' => TRUE
            ),
            'active' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'unsigned' => TRUE,
                'null' => TRUE
            ),
            'first_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE
            ),
            'last_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE
            ),
            'company' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
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
        echo "CREATE TABLE " . $this->tables['users'] . "<br>";
        $this->dbforge->create_table($this->tables['users']);

        $this->insert_data_users();
    }

    protected function insert_data_users() {
        //-----------------------------------------------------------------------
        // Dumping data for table $this->tables['users']
        $data = array(
            array(
                'ip_address' => '127.0.0.1',
                'username' => 'administrator',
                'password' => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
                'email' => 'admin@admin.com',
                'activation_code' => '',
                'forgotten_password_code' => NULL,
                'last_login' => '1268889823',
                'active' => '1',
                'first_name' => 'Admin',
                'last_name' => 'istrator',
                'company' => 'SUPERADMIN',
                'phone' => '0',
                '_created_at' => '1268889823',
                '_created_by' => '-99',
                '_updated_at' => '1268889823',
                '_updated_by' => '0',
            ),
            array(
                'ip_address' => '127.0.0.1',
                'username' => 'uadmin',
                'password' => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
                'email' => 'uadmin@admin.com',
                'activation_code' => '',
                'forgotten_password_code' => NULL,
                'last_login' => '1268889823',
                'active' => '1',
                'first_name' => 'uadmin',
                'last_name' => '',
                'company' => '',
                'phone' => '0',
                '_created_at' => '1268889823',
                '_created_by' => '-99',
                '_updated_at' => '1268889823',
                '_updated_by' => '0',
            ),
            array(
                'ip_address' => '127.0.0.1',
                'username' => 'uterdaftar',
                'password' => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
                'email' => 'uterdaftar@terdaftar.com',
                'activation_code' => '',
                'forgotten_password_code' => NULL,
                'last_login' => '1268889823',
                'active' => '1',
                'first_name' => 'uadmin',
                'last_name' => '',
                'company' => '',
                'phone' => '0',
                '_created_at' => '1268889823',
                '_created_by' => '-99',
                '_updated_at' => '1268889823',
                '_updated_by' => '0',
            ),
            array(
                'ip_address' => '127.0.0.1',
                'username' => 'ukepsek',
                'password' => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
                'email' => 'ukepsek@kepsek.com',
                'activation_code' => '',
                'forgotten_password_code' => NULL,
                'last_login' => '1268889823',
                'active' => '1',
                'first_name' => 'ukepsek',
                'last_name' => '',
                'company' => '',
                'phone' => '0',
                '_created_at' => '1268889823',
                '_created_by' => '-99',
                '_updated_at' => '1268889823',
                '_updated_by' => '0',
            ),
            array(
                'ip_address' => '127.0.0.1',
                'username' => 'uguru',
                'password' => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
                'email' => 'uguru@guru.com',
                'activation_code' => '',
                'forgotten_password_code' => NULL,
                'last_login' => '1268889823',
                'active' => '1',
                'first_name' => 'uguru',
                'last_name' => '',
                'company' => '',
                'phone' => '0',
                '_created_at' => '1268889823',
                '_created_by' => '-99',
                '_updated_at' => '1268889823',
                '_updated_by' => '0',
            ),
            array(
                'ip_address' => '127.0.0.1',
                'username' => 'udapodik',
                'password' => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
                'email' => 'udapodik@dapodik.com',
                'activation_code' => '',
                'forgotten_password_code' => NULL,
                'last_login' => '1268889823',
                'active' => '1',
                'first_name' => 'udapodik',
                'last_name' => '',
                'company' => '',
                'phone' => '0',
                '_created_at' => '1268889823',
                '_created_by' => '-99',
                '_updated_at' => '1268889823',
                '_updated_by' => '0',
            ),
        );

        echo "Insert into table " . $this->tables['users'] . "<br>";
        $this->db->insert_batch($this->tables['users'], $data);
    }

    public function up_users_group_table() {

        //-----------------------------------------------------------------------
        //---- USERS GROUPS TABLE
        // DROP TABLE $this->tables['users_groups'] if it exists
        echo "DROP TABLE " . $this->tables['users_groups'] . " if it exists<br>";
        $this->dbforge->drop_table($this->tables['users_groups'], TRUE);

        // Table structure for table $this->tables['users_groups']
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE
            ),
            'group_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE
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
        $this->dbforge->add_key('user_id', FALSE);
        $this->dbforge->add_key('group_id', FALSE);

        //-----------------------------------------------------------------------
        echo "CREATE TABLE " . $this->tables['users_groups'] . "<br>";
        $this->dbforge->create_table($this->tables['users_groups']);
        //-----------------------------------------------------------------------
        // Dumping data for table $this->tables['users_groups']
        $data = array(
            array(
                'user_id' => '1',
                'group_id' => '1',
            ),
            array(
                'user_id' => '1',
                'group_id' => '2',
            )
        );

        echo "Insert into table " . $this->tables['users_groups'] . "<br>";
        $this->db->insert_batch($this->tables['users_groups'], $data);

        //-----------------------------------------------------------------------
        //---- LOGIN ATTEMPTS TABLE
        // DROP TABLE $this->tables['login_attempts'] if it exists
        echo "DROP TABLE " . $this->tables['login_attempts'] . " if it exists<br>";
        $this->dbforge->drop_table($this->tables['login_attempts'], TRUE);

        // Table structure for table $this->tables['login_attempts']
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '45'
            ),
            'login' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ),
            'time' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);

        //-----------------------------------------------------------------------
        echo "CREATE TABLE " . $this->tables['login_attempts'] . "<br>";
        $this->dbforge->create_table($this->tables['login_attempts']);
        //-----------------------------------------------------------------------
    }

    // external auth table
    public function up_external_authentications_table() {
        //-----------------------------------------------------------------------
        //---- AUTHENTICATIONS TABLE
        // DROP TABLE $this->tables['authentications'] if it exists
        echo "DROP TABLE " . $this->tables['authentications'] . " if it exists<br>";
        $this->dbforge->drop_table($this->tables['authentications'], TRUE);

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => FALSE,
                'null' => TRUE
            ),
            'registration_approved' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'unsigned' => TRUE,
                'null' => TRUE
            ),
            'active' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'unsigned' => TRUE,
                'null' => TRUE
            ),
            'provider' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'provider_uid' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'identity' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'secret' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'saved_object' => array(
                'type' => 'mediumtext',
                'null' => FALSE,
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
        echo "CREATE TABLE " . $this->tables['authentications'] . "<br>";
        $this->dbforge->create_table($this->tables['authentications']);
    }

    public function up_users_external_authentications_table() {

        $thistablename = $this->tables['users_authentications'];

        //-----------------------------------------------------------------------
        //---- AUTHENTICATIONS TABLE
        // DROP TABLE $this->tables['authentications'] if it exists
        echo "DROP TABLE " . $thistablename . " if it exists<br>";
        $this->dbforge->drop_table($thistablename, TRUE);

        // Table structure for table $this->tables[$thistablename
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE
            ),
            'external_auth_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE
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
        $this->dbforge->add_key('user_id', FALSE);
        $this->dbforge->add_key('external_auth_id', FALSE);
        //-----------------------------------------------------------------------
        echo "CREATE TABLE " . $thistablename . "<br>";
        $this->dbforge->create_table($thistablename);
    }

    public function fks_and_constraints() {

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users'] . " " .
                "ADD CONSTRAINT `uq_" . $this->tables['users'] . "_email` " .
                "UNIQUE (`email`);";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users'] . " " .
                "ADD CONSTRAINT `uq_" . $this->tables['users'] . "_activation_selector` " .
                "UNIQUE (`activation_selector`);";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users'] . " " .
                "ADD CONSTRAINT `uq_" . $this->tables['users'] . "_forgotten_password_selector` " .
                "UNIQUE (`forgotten_password_selector`);";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users'] . " " .
                "ADD CONSTRAINT `uq_" . $this->tables['users'] . "_remember_selector` " .
                "UNIQUE (`remember_selector`);";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users_groups'] . " " .
                "ADD CONSTRAINT `uq_" . $this->tables['users_groups'] . "` " .
                "UNIQUE (`user_id`, `group_id`)"
                . ";";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users_groups'] . " " .
                "ADD CONSTRAINT `fk_" . $this->tables['users_groups'] . "1` " .
                "FOREIGN KEY (`user_id`) REFERENCES `" . $this->tables['users'] . "`(`id`) "
                . "ON DELETE CASCADE ON UPDATE NO ACTION"
                . ";";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users_groups'] . " " .
                "ADD CONSTRAINT `fk_" . $this->tables['users_groups'] . "2` " .
                "FOREIGN KEY (`group_id`) REFERENCES `" . $this->tables['groups'] . "`(`id`) "
                . "ON DELETE CASCADE ON UPDATE NO ACTION"
                . ";";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";


        $thistablename = str_replace($this->tables['tbl_prefix'], "", $this->tables['users_authentications']);
        echo $thistablename . '<br>';
        $_sqlstring = "
            ALTER TABLE " . $this->tables['users_authentications'] . " " .
                "ADD CONSTRAINT `uq_" . $thistablename . "` " .
                'UNIQUE (`user_id`, `external_auth_id`)'
                . ";";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users_authentications'] . " " .
                "ADD CONSTRAINT `fk_" . $thistablename . "1` " .
                "FOREIGN KEY (`user_id`) REFERENCES `" . $this->tables['users'] . "`(`id`) "
                . "ON DELETE CASCADE ON UPDATE NO ACTION"
                . ";";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users_authentications'] . " " .
                "ADD CONSTRAINT `fk_" . $thistablename . "2` " .
                "FOREIGN KEY (`external_auth_id`) REFERENCES `" . $this->tables['authentications'] . "`(`id`) "
                . "ON DELETE CASCADE ON UPDATE NO ACTION"
                . ";";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";
    }

    public function down() {
        log_message('application_debug', 'class:' . get_class($this) . ' function:' . __FUNCTION__);
        echo "<p>001_install_ion_auth.php (uninstall) started</p>";
        echo 'MIGRATION DOWN<br>';

        echo "DROP TABLE " . $this->tables['users'] . " if it exists<br>";
        $this->dbforge->drop_table($this->tables['users'], TRUE);
        echo "DROP TABLE " . $this->tables['groups'] . " if it exists<br>";
        $this->dbforge->drop_table($this->tables['groups'], TRUE);
        echo "DROP TABLE " . $this->tables['users_groups'] . " if it exists<br>";
        $this->dbforge->drop_table($this->tables['users_groups'], TRUE);
        echo "DROP TABLE " . $this->tables['login_attempts'] . " if it exists<br>";
        $this->dbforge->drop_table($this->tables['login_attempts'], TRUE);
        echo "DROP TABLE " . $this->tables['authentications'] . " if it exists<br>";
        $this->dbforge->drop_table($this->tables['authentications'], TRUE);
    }

}
