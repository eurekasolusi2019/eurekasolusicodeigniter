<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_ion_auth extends CI_Migration {

    private $tables;

    public function __construct() {
        parent::__construct();
        $this->load->dbforge();

        $this->load->config('ion_auth', TRUE);
        $this->tables = $this->config->item('tables', 'ion_auth');
    }

    public function up() {
        log_message('application_debug', 'class:' . get_class($this) . ' function:' . __FUNCTION__);

        //---- GROUPS TABLE
        // Drop table 'groups' if it exists
        $this->dbforge->drop_table($this->tables['groups'], TRUE);

        // Table structure for table 'groups'
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
        $this->dbforge->create_table($this->tables['groups']);

        // Dumping data for table 'groups'
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
                'name' => 'users',
                'description' => 'Pengguna Biasa',
                '_created_at' => '2018-12-08 11:11:11',
                '_created_by' => '-99',
                '_updated_at' => '2018-12-08 11:11:11',
                '_updated_by' => '-99'
            )
        );

        $this->db->insert_batch($this->tables['groups'], $data);

        //---- USERS TABLE
        // Drop table 'users' if it exists
        $this->dbforge->drop_table($this->tables['users'], TRUE);

        // Table structure for table 'users'
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
        $this->dbforge->create_table($this->tables['users']);

        // Dumping data for table 'users'
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
        $this->db->insert($this->tables['users'], $data);

        //---- USERS GROUPS TABLE
        // Drop table 'users_groups' if it exists
        $this->dbforge->drop_table($this->tables['users_groups'], TRUE);

        // Table structure for table 'users_groups'
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

        $this->dbforge->create_table($this->tables['users_groups']);

        // Dumping data for table 'users_groups'
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
        $this->db->insert_batch($this->tables['users_groups'], $data);

        //---- LOGIN ATTEMPTS TABLE
        // Drop table 'login_attempts' if it exists
        $this->dbforge->drop_table($this->tables['login_attempts'], TRUE);

        // Table structure for table 'login_attempts'
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

        $this->dbforge->create_table($this->tables['login_attempts']);


        //--- CONSTRAINTS, FOREIGN KEYS
        $_sqlstring = "
            ALTER TABLE " . $this->tables['users_groups'] . " " .
                "ADD CONSTRAINT `uq_" . $this->tables['users_groups'] . "` " .
                "UNIQUE (`user_id`, `group_id`);";
        $this->db->query($_sqlstring);

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users_groups'] . " " .
                "ADD CONSTRAINT `fk_" . $this->tables['users_groups'] . "1` " .
                "FOREIGN KEY (`user_id`) REFERENCES `" . $this->tables['users'] . "`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;";
        $this->db->query($_sqlstring);

        $_sqlstring = "
            ALTER TABLE " . $this->tables['users_groups'] . " " .
                "ADD CONSTRAINT `fk_" . $this->tables['users_groups'] . "2` " .
                "FOREIGN KEY (`group_id`) REFERENCES `" . $this->tables['groups'] . "`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;";
        $this->db->query($_sqlstring);
    }

    public function down() {
        $this->dbforge->drop_table($this->tables['users'], TRUE);
        $this->dbforge->drop_table($this->tables['groups'], TRUE);
        $this->dbforge->drop_table($this->tables['users_groups'], TRUE);
        $this->dbforge->drop_table($this->tables['login_attempts'], TRUE);
    }

}
