<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/**
 * ErkanaAuth
 *
 * An easy-to-use authentication framework for CodeIgniter
 *
 * @package		ErkanaAuth
 * @author		Michael Wales
 * @copyright	Copyright (c) 2010, Michael D. Wales
 * @license		http://creativecommons.org/licenses/BSD/
 */

// ------------------------------------------------------------------------

/**
 * Erkana Auth Class
 *
 * @package		ErkanaAuth
 * @subpackage	Libraries
 * @category	Authentication
 * @author		Michael Wales
 */

// ------------------------------------------------------------------------
class Erkana_auth {

    var $CI;
    var $errors					= array();

    // Default the accounts controller to something intelligent
    var $accounts_controller	= '/admin/login/';

    function Erkana_auth() {
        $this->CI =& get_instance();
        $this->CI->lang->load('erkana_auth', 'english');
        $this->CI->load->helper('erkana_auth');
    }

    /**
     * Required - Enforces authentication on a controller method
     *
     * @access		public
     * @return		void
     */
    function required() {
        if (!$this->is_logged_in()) {
            if (!function_exists('redirect')) {
                $this->CI->load->helper('url');
            }

            redirect($this->accounts_controller);
        }
    }

    /**
     * Logout - Unsets all session data and redirects to login page
     *
     * @access		public
     * @return		void
     */
    function logout() {
        if ($this->is_logged_in()) {
            if (!function_exists('redirect')) {
                $this->CI->load->helper('url');
            }
            if (!class_exists('CI_Session')) {
                $this->CI->load->library('session');
            }
            $login_credentials = array(array('user_id', 'user_token'));
            $this->CI->session->unset_userdata($login_credentials);
            $this->CI->session->sess_destroy();

            redirect($this->accounts_controller);
        }
    }


    /**
     * Accounts Controller - Sets the controller that processes your
     * authentication forms.
     *
     * @access 		public
     * @return		void
     */
    function accounts_controller($controller) {
        $this->accounts_controller = $controller;
    }


    /**
     * Is Logged In? - Checks if the user is logged in / valid session
     *
     * @access		public
     * @return		bool
     */
    function is_logged_in() {
        if (!class_exists('CI_Session')) {
            $this->CI->load->library('session');
        }

        // Check if there is any session data we can use
        if ($this->CI->session->userdata('user_id') && $this->CI->session->userdata('user_token')) {
            if (!class_exists('Account')) {
                $this->CI->load->model('account');
            }

            // Get a user account via the Account model
            $account = $this->CI->account->get($this->CI->session->userdata('user_id'));
            if ($account !== FALSE) {
                if (!function_exists('do_hash')) {
                    $this->CI->load->helper('security');
                }

                // Ensure user_token is still equivalent to the SHA1 of the user_id and password_hash
                if (do_hash($this->CI->session->userdata('user_id') . $account->password_hash) === $this->CI->session->userdata('user_token')) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }


    /**
     * Validate Login - Checks authentication credentials against the database
     *
     * @access		public
     * @param		string	the unique identifier: email or username
     * @return		bool
     */
    function validate_login($identifiers = array('email')) {
        if ($this->CI->input->post($identifiers[0])) {
            if (!class_exists('Account')) {
                $this->CI->load->model('account');
            }

            $where = array();
            foreach($identifiers as $identifier) {
                $where[$identifier] = $this->CI->input->post($identifier);
            }

            $account = $this->CI->account->get_by($where);
            if ($account !== NULL) {
                if (!function_exists('do_hash')) {
                    $this->CI->load->helper('security');
                }

                if (do_hash($account->salt . $this->CI->input->post('password')) === $account->password_hash) {
                    if ($account->$identifier === $this->CI->input->post($identifier)) {
                        $this->_establish_session($account);
                        return TRUE;
                    }
                }
            }

            $this->errors[] = $this->CI->lang->line('erkana_auth_invalid_login');
        }

        return FALSE;
    }


    /**
     * Create Account - Will create an account if form validation requirements are met
     *
     * @access		public
     * @param		string	the unique identifier: email or username
     * @return		bool
     */
    function create_account($identifier = 'email') {
        if (!class_exists('CI_Form_validation')) {
            $this->CI->load->library('form_validation');
        }

        $this->CI->form_validation->set_rules('fullname', 'Full Name', 'required|trim');
        $this->CI->form_validation->set_rules('username', 'username', 'required|min_length[4]|max_length[20]|trim');
        $this->CI->form_validation->set_rules('email', 'email', 'required|max_length[120]|valid_email|trim');
        $this->CI->form_validation->set_rules('password', 'password', 'required|matches[passwordconf]');
        $this->CI->form_validation->set_rules('passwordconf', 'password confirmation', 'required');

        if ($this->CI->form_validation->run()) {
            if (!class_exists('Account')) {
                $this->CI->load->model('account');
            }

            foreach ($this->CI->form_validation->_error_array as $error) {
                $this->errors[] = $error;
            }

            $account = $this->CI->account->get_by(array($identifier => $this->CI->input->post($identifier)));
            if ($account === NULL) {
                $salt = $this->_generate_salt();

                if (!function_exists('do_hash')) {
                    $this->CI->load->helper('security');
                }

                $account = array(
                    'fullname'		=> $this->CI->input->post('fullname'),
                    'username'		=> $this->CI->input->post('username'),
                    'email'		=> $this->CI->input->post('email'),
                    'salt'			=> $salt,
                    'password_hash'	=> do_hash($salt . $this->CI->input->post('password'))
                );

                return $this->CI->account->create($account);
            }

            $this->errors[] = $this->CI->lang->line('erkana_auth_account_exists');
        }

        return FALSE;
    }

    /**
     * Create Account - Will create an account if form validation requirements are met
     *
     * @access		public
     * @param		string	the unique identifier: email or username
     * @return		bool
     */
    function edit_account($id, $identifier = 'email') {
        if (!class_exists('CI_Form_validation')) {
            $this->CI->load->library('form_validation');
        }

        $this->CI->form_validation->set_rules('fullname', 'Full Name', 'trim');
        $this->CI->form_validation->set_rules('username', 'username', 'min_length[4]|max_length[20]|trim');
        $this->CI->form_validation->set_rules('email', 'email', 'max_length[120]|valid_email|trim');
        $this->CI->form_validation->set_rules('password', 'password', 'matches[passwordconf]');
        $this->CI->form_validation->set_rules('passwordconf', 'password confirmation', '');

        if ($this->CI->form_validation->run()) {
            if (!class_exists('Account')) {
                $this->CI->load->model('account');
            }

            foreach ($this->CI->form_validation->_error_array as $error) {
                $this->errors[] = $error;
            }

            $account = $this->CI->account->get_by(array($identifier => $this->CI->input->post($identifier)));
            if ($account) {
                $salt = $account->salt;

                if (!function_exists('do_hash')) {
                    $this->CI->load->helper('security');
                }

                if(strlen($this->CI->input->post('password')) > 0) {
                    $account = array(
                        'fullname'		=> $this->CI->input->post('fullname'),
                        'username'		=> $this->CI->input->post('username'),
                        'email'		=> $this->CI->input->post('email'),
                        'password_hash'	=> do_hash($salt . $this->CI->input->post('password'))
                    );
                } else {
                    $account = array(
                        'fullname'		=> $this->CI->input->post('fullname'),
                        'username'		=> $this->CI->input->post('username'),
                        'email'		=> $this->CI->input->post('email')
                    );
                }

                return $this->CI->account->edit($id, $account);
            }

            $this->errors[] = $this->CI->lang->line('erkana_auth_account_exists');
        }

        return FALSE;
    }


    /**
     * Establish Session - Sets identifying information via the Session Class
     *
     * @access		private
     * @return		void
     */
    function _establish_session($account) {
        if (!class_exists('CI_Session')) {
            $this->CI->load->library('session');
        }
        if (!class_exists('Account')) {
            $this->CI->load->model('account');
        }
        $this->CI->session->set_userdata(array(
            'user_id'	=> $account->id,
            'user_token'=> do_hash($account->id . $account->password_hash))
        );
        $data = array('last_login' => date ("Y-m-d H:i:s"));
        $this->CI->account->update($account->id, $data);
    }


    /**
     * Generate Salt - Generates a random string to be used as a salt
     *
     * @access		private
     * @return		string
     */
    function _generate_salt() {
        if (!function_exists('random_string')) {
            $this->CI->load->helper('string');
        }

        return random_string('alnum', 7);
    }

}

/* End of file Erkana_auth.php */
/* Location: ./applicaiton/libraries/Erkana_auth.php */
