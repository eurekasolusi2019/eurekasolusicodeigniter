<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 */
class Esciauth extends ESCI_Controller {

    public $redirectsuccess = 'home';
    public $redirectrelogin = 'esciauth/login';
    public $access_code = 0;
    public $require_login = 0;
    public $tpldir = 'paperdash';
    public $view_data = array();

    public function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        
        if (!isset($identity) || !isset($password)):
            $identity = array(
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => '',
                'class' => 'form-control',
                'placeholder' => "email/username", 
            );
            $password = array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => "Password", 
            );
        endif;

        $this->view_data['display_setting'] = false;

        $this->view_data['login_heading'] = lang('login_heading');
        $this->view_data['login_subheading'] = lang('login_subheading');

        $this->view_data['login_identity_label'] = lang('login_identity_label');
        $this->view_data['login_password_label'] = lang('login_password_label');
        $this->view_data['login_remember_label'] = lang('login_remember_label');
        $this->view_data['login_submit_btn'] = lang('login_submit_btn');

        $this->view_data['html_form_submit'] = form_submit('submit', lang('login_submit_btn'), 'class="width-35 btn btn-sm btn-success"');

        $this->view_data['form_input_identity'] = form_input($identity);

        $this->view_data['form_input_password'] = form_input($password);
        $this->view_data['anchor_google_login'] = anchor(base_url('esciauth/google_login'),'Login With Google.');

    }

    public function index() {
        
       $this->view_data['display_setting'] = false;
        

        //validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');
        if ($this->ion_auth->logged_in()) {
            $this->view_data['message'] = 'Anda sudah login, anda dapat <a href="' . base_url() . '">langsung ke halaman muka</a> atau melakukan login ulang';
        }

        $this->twig_display('login2', $this->view_data);
    }

    /**
     * Esciauth::login
     * Log the user in
     */
    public function login() {
        $this->view_data['title'] = $this->lang->line('login_heading');

        $this->view_data['display_setting'] = false;

        // validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');


        if ($this->form_validation->run() === TRUE) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect($this->redirectsuccess, 'refresh');
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect($this->redirectrelogin, 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->view_data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->view_data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->view_data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
                'class' => 'form-control',
                'placeholder' => 'Login'
            );
            $this->view_data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Password'
            );
        }

        if ($this->ion_auth->logged_in()) {
            $this->view_data['message'] = 'Anda sudah login, anda dapat <a href="' . base_url() . '">langsung ke halaman muka</a> atau melakukan login ulang';
        }

        $this->twig_display('login2', $this->view_data);
    }

    public function google_login($mode = NULL) {
        $this->load->helper('url');

        $provider_id = 'Google';
        if ($mode == 'prompt') {
            $prompt_config = $this->set_config_with_prompt();

            $this->load->library('escihybridauth', $prompt_config);
            $params = array(
                'hauth_return_to' => base_url("index.php/login/google_login/prompt"),
            );
        } else {
            $this->load->library('escihybridauth');
            $params = array(
                'hauth_return_to' => base_url("index.php/login/google_login"),
            );
        }

        if (isset($_REQUEST['openid_identifier'])) {
            $params['openid_identifier'] = $_REQUEST['openid_identifier'];
        }
        try {
            $adapter = $this->escihybridauth->HA->authenticate($provider_id, $params);
            $profile = $adapter->getUserProfile();

            if ($this->ion_auth->login($profile->emailVerified, '', FALSE, 'Google')) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect($this->redirectsuccess, 'refresh');
            } else {
                $_message = $this->ion_auth->errors();
                if (!empty($profile->emailVerified)) {
                    $_message = 'Email Anda (' . $profile->emailVerified . ') berhasil diautentikasi oleh Google tetapi belum terdaftar di dalam sistem RAPBS.<br><br>';
                    $_message .= 'Untuk merubah account Google yang Anda gunakan, <a href="./google_login/prompt"> klik di sini</a>';
                }

                $this->session->set_flashdata('message', $_message);
                $adapter->disconnect(); // $this->escihybridauth->HA->logoutAllProviders(); // $adapter->logout();
                // die('go to index');
                $this->index();
            }
        } catch (Exception $e) {
            $_message = $e->getMessage();
            log_message('error', $_message);
            $this->session->set_flashdata('message', 'Google Login gagal:<br>' . $_message);
            $this->escihybridauth->HA->logoutAllProviders();
            die('redirect to login and refresh');
            redirect('login', 'refresh');
        }
    }

// todo: foreach provider, if enabled, set "approval_prompt" => "force",
    function set_config_with_prompt() {
        return array(
            "providers" => array(
                // openid providers
                "OpenID" => array(
                    "enabled" => FALSE,
                ),
                "Yahoo" => array(
                    "enabled" => FALSE,
                    "keys" => array("id" => "", "secret" => ""),
                ),
                "AOL" => array(
                    "enabled" => FALSE,
                ),
                "Google" => array(
                    "enabled" => TRUE,
                    "keys" => array("id" => "102711109122-0ij5pqmc0kbbmmlouhds16pdmgj80npi.apps.googleusercontent.com", "secret" => "-r_8RFRDkTJH5_8V5SsSE2Dx"),
                    'callback' => 'http://localhost/eurekasolusicodeigniter/' . 'esciauth/google_login',
                    "approval_prompt" => "force",
                ),
                "Facebook" => array(
                    "enabled" => FALSE,
                    "keys" => array("id" => "", "secret" => ""),
                    "trustForwarded" => FALSE,
                ),
                "Twitter" => array(
                    "enabled" => FALSE,
                    "keys" => array("key" => "", "secret" => ""),
                    "includeEmail" => FALSE,
                ),
                "Live" => array(
                    "enabled" => FALSE,
                    "keys" => array("id" => "", "secret" => ""),
                ),
                "LinkedIn" => array(
                    "enabled" => FALSE,
                    "keys" => array("id" => "", "secret" => ""),
                    "fields" => array(),
                ),
                "Foursquare" => array(
                    "enabled" => FALSE,
                    "keys" => array("id" => "", "secret" => ""),
                ),
            ),
            // If you want to enable logging, set 'debug_mode' to true.
            // You can also set it to
            // - "error" To log only error messages. Useful in production
            // - "info" To log info and error messages (ignore debug messages)
            "debug_mode" => ENVIRONMENT === 'development',
            // Path to file writable by the web server. Required if 'debug_mode' is not false
            "debug_file" => APPPATH . 'logs/hybridauth.log',
        );
    }

    // activate
    public function activate($id, $code = false) {
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            // redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            if ($this->ion_auth->is_admin()) {
                redirect("user_management", 'refresh');
            } else {
                redirect($this->redirectsuccess, 'refresh');
            }
        } else {
            // redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            if ($this->ion_auth->is_admin()) {
                redirect("user_management", 'refresh');
            } else {
                redirect("login/forgot_password", 'refresh');
            }
        }
    }

    // forgot password
    public function forgot_password() {

        // setting validation rules by checking whether identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }


        if ($this->form_validation->run() == false) {
            $this->view_data['type'] = $this->config->item('identity', 'ion_auth');
            // setup the input
            $this->view_data['identity'] = array('name' => 'identity',
                'id' => 'identity',
            );

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->view_data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->view_data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            // set any errors and display the form
            $this->view_data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_page('auth/forgot_password', $this->view_data);
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            // additional check for email
            if (empty($identity) && $this->config->item('identity', 'ion_auth') != 'email') {
                $identity = $this->ion_auth->where('email', $this->input->post('identity'))->users()->row();
            }

            if (empty($identity)) {
                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("login/forgot_password", 'refresh');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {
                // if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("login/", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("login/forgot_password", 'refresh');
            }
        }
    }

    // reset password - final step for forgotten password
    public function reset_password($code = NULL) {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            // if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false) {
                // display the form
                // set the flash data error message if there is one
                $this->view_data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->view_data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->view_data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->view_data['min_password_length'] . '}.*$',
                );
                $this->view_data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->view_data['min_password_length'] . '}.*$',
                );
                $this->view_data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->view_data['csrf'] = $this->_get_csrf_nonce();
                $this->view_data['code'] = $code;

                // render
                $this->_render_page('auth/reset_password', $this->view_data);
            } else {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));
                } else {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        // if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("login/", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('login/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("login/forgot_password", 'refresh');
        }
    }

    public function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    public function _valid_csrf_nonce() {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function _render_page($view, $data = null, $returnhtml = false) {//I think this makes more sense
        $this->viewdata = (empty($data)) ? $this->view_data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml)
            return $view_html; //This will return html on 3rd argument being true
    }

}

?>
