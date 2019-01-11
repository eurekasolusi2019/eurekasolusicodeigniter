<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *  TODO: REMOVE THIS
 * use login_view
 * general_model (autoloaded)
 */
class Login extends ESCI_Controller {

    public $access_code = 0;
    public $require_login = 0;

    public function index() {

        //validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() == true) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('home', 'refresh');
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {

            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
                'class' => 'form-control',
                'placeholder' => 'Login'
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Password'
            );

            if ($this->ion_auth->logged_in()) {
                $this->data['message'] = 'Anda sudah login, anda dapat <a href="' . base_url() . '">langsung ke halaman muka</a> atau melakukan login ulang';
            }

            $this->load->view('login_view', $this->data);
        }
    }

    public function google_login($mode = NULL) {
        $this->load->helper('url');

        $provider_id = 'Google';
        if ($mode == 'prompt') {
            $prompt_config = $this->set_config_with_prompt();

            $this->load->library('EsciHybridauth', $prompt_config);
            $params = array(
                'hauth_return_to' => base_url("index.php/login/google_login/prompt"),
            );
        } else {
            $this->load->library('EsciHybridauth');
            $params = array(
                'hauth_return_to' => base_url("index.php/login/google_login"),
            );
        }

        if (isset($_REQUEST['openid_identifier'])) {
            $params['openid_identifier'] = $_REQUEST['openid_identifier'];
        }
        try {
            $adapter = $this->EsciHybridauth->HA->authenticate($provider_id, $params);
            $profile = $adapter->getUserProfile();

            if ($this->ion_auth->login($profile->emailVerified, '', FALSE, 'Google')) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('home', 'refresh');
            } else {
                $_message = $this->ion_auth->errors();
                if (!empty($profile->emailVerified)) {
                    $_message = 'Email Anda (' . $profile->emailVerified . ') berhasil diautentikasi oleh Google tetapi belum terdaftar di dalam sistem RAPBS.<br><br>';
                    $_message .= 'Untuk merubah account Google yang Anda gunakan, <a href="./google_login/prompt"> klik di sini</a>';
                }

                $this->session->set_flashdata('message', $_message);
                $adapter->disconnect(); // $this->EsciHybridauth->HA->logoutAllProviders(); // $adapter->logout();
                $this->index();
            }
        } catch (Exception $e) {
            $_message = $e->getMessage();
            log_message('error', $_message);
            $this->session->set_flashdata('message', 'Google Login gagal:<br>' . $_message);
            $this->EsciHybridauth->HA->logoutAllProviders();
            redirect('login', 'refresh');
        }
    }

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
                    "keys" => array("id" => "531546002717-tuhjq96skk289t48p7fehkpf6n1j9ljq.apps.googleusercontent.com", "secret" => "k47X0HRfa9_hs3Edd8-FHHq3"),
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
                redirect('home', 'refresh');
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
            $this->data['type'] = $this->config->item('identity', 'ion_auth');
            // setup the input
            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
            );

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            // set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_page('auth/forgot_password', $this->data);
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
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                // render
                $this->_render_page('auth/reset_password', $this->data);
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

    	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}

?>
