<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_ion_auth extends CI_Migration {

    private $tables;

    public function __construct() {
        parent::__construct();

        echo 'this class extends CI_Migration<br>';
        echo 'load dbforge...<br>';

        $this->load->dbforge();

        echo 'load config ion_auth, we need the tables...<br>';
        $this->load->config('ion_auth', TRUE);
        $this->tables = $this->config->item('tables', 'ion_auth');
        
        var_dump($this->tables);
    }

    public function up() {
        log_message('application_debug', 'class:' . get_class($this) . ' function:' . __FUNCTION__);
        echo "<p>001_install_ion_auth.php started</p>";
        echo 'MIGRATION UP<br>';


        $_sqlstring = "SET FOREIGN_KEY_CHECKS=0;";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

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
                '_updated_by' => '-99'
            ),
            array(
                'id' => '2',
                'name' => 'admin',
                'description' => 'Administrator Sistem',
                '_created_at' => '2018-12-08 11:11:11',
                '_created_by' => '-99',
                '_updated_at' => '2018-12-08 11:11:11',
                '_updated_by' => '-99'
            ),
            array(
                'id' => '3',
                'name' => 'kepsek',
                'description' => 'Kepala Sekolah',
                '_created_at' => '2018-12-08 11:11:11',
                '_created_by' => '-99',
                '_updated_at' => '2018-12-08 11:11:11',
                '_updated_by' => '-99'
            ),
            array(
                'id' => '4',
                'name' => 'guru',
                'description' => 'Guru',
                '_created_at' => '2018-12-08 11:11:11',
                '_created_by' => '-99',
                '_updated_at' => '2018-12-08 11:11:11',
                '_updated_by' => '-99'
            ),
            array(
                'id' => '5',
                'name' => 'dapodik',
                'description' => 'Admin Dapodik',
                '_created_at' => '2018-12-08 11:11:11',
                '_created_by' => '-99',
                '_updated_at' => '2018-12-08 11:11:11',
                '_updated_by' => '-99'
            ),
            array(
                'id' => '6',
                'name' => $this->tables['users'],
                'description' => 'Pengguna Biasa',
                '_created_at' => '2018-12-08 11:11:11',
                '_created_by' => '-99',
                '_updated_at' => '2018-12-08 11:11:11',
                '_updated_by' => '-99'
            )
        );

        $this->db->insert_batch($this->tables['groups'], $data);

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
                'constraint' => '80',
            ),
            'salt' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => TRUE
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '254'
            ),
            'activation_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => TRUE
            ),
            'forgotten_password_code' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => TRUE
            ),
            'forgotten_password_time' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
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
        //-----------------------------------------------------------------------
        // Dumping data for table $this->tables['users']
        $data = array(
            'ip_address' => '127.0.0.1',
            'username' => 'administrator',
            'password' => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
            'salt' => '',
            'email' => 'admin@admin.com',
            'activation_code' => '',
            'forgotten_password_code' => NULL,
            'last_login' => '1268889823',
            'active' => '1',
            'first_name' => 'Admin',
            'last_name' => 'istrator',
            'company' => 'ADMIN',
            'phone' => '0',
            '_created_at' => '1268889823',
            '_created_by' => '-99',
            '_updated_at' => '1268889823',
            '_updated_by' => '-99',
        );

        echo "Insert into table " . $this->tables['users'] . "<br>";
        $this->db->insert($this->tables['users'], $data);

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
        //-----------------------------------------------------------------------
        //---- AUTHENTICATIONS TABLE
        // DROP TABLE $this->tables['authentications'] if it exists
        echo "DROP TABLE " . $this->tables['authentications'] . " if it exists<br>";
        $this->dbforge->drop_table($this->tables['authentications'], TRUE);

        /*
          $data = array(
          'user_id' => $user_id,
          'provider' => $provider,
          'provider_uid' => $provider_uid,
          'created_on' => time()
          ); */
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
                'auto_increment' => FALSE
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

        //-----------------------------------------------------------------------
        //--- CONSTRAINTS, FOREIGN KEYS
        echo "--- CONSTRAINTS, FOREIGN KEYS --- <br>";
        $_sqlstring = "
            ALTER TABLE " . $this->tables['users_groups'] . " " .
                "ADD CONSTRAINT `uq_" . $this->tables['users_groups'] . "` " .
                "UNIQUE (`user_id`, `group_id`);";
        $this->db->query($_sqlstring);
        echo "finishing $_sqlstring<br>";

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users_groups'] . " " .
                "ADD CONSTRAINT `fk_" . $this->tables['users_groups'] . "1` " .
                "FOREIGN KEY (`user_id`) REFERENCES `" . $this->tables['users'] . "`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;";
        $this->db->query($_sqlstring);
        echo "finishing $_sqlstring<br>";

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users_groups'] . " " .
                "ADD CONSTRAINT `fk_" . $this->tables['users_groups'] . "2` " .
                "FOREIGN KEY (`group_id`) REFERENCES `" . $this->tables['groups'] . "`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;";
        $this->db->query($_sqlstring);
        echo "finishing $_sqlstring<br>";

        $_sqlstring = "SET FOREIGN_KEY_CHECKS=1;";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

        echo "<p>001_install_ion_auth.php completed</p>";
    }

    public function down() {

        echo 'MIGRATION DOWN<br>';
        $_sqlstring = "SET FOREIGN_KEY_CHECKS=0;";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";

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

        $_sqlstring = "SET FOREIGN_KEY_CHECKS=1;";
        $this->db->query($_sqlstring);
        echo "$_sqlstring<br>";
    }

}
