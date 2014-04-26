<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library(array('session', 'Erkana_auth'));
        $this->load->model('admin_model');
        $this->load->model('account');
        $this->edit_id = '';
        $this->page_title = '';
        $this->messages = array();
        $this->form_messages = '';
        $this->breadcrumbs = array();
    }

    public function login()
    {
        $page = array();
        $page['messages'] = array();
        if($this->erkana_auth->validate_login(array('username'))) {
            redirect('/s5k9d7f6jdn0/');
        } else {
            foreach($this->erkana_auth->errors as $error) {
                $this->messages[] = array("type" => 'error', "content" => $error);
            }
        }
        $page['messages'] = $this->messages;
        echo $this->load->view('admin/login', $page, true);
    }

    public function logout()
    {
        $this->erkana_auth->logout();
        redirect('/s5k9d7f6jdn0/');
    }
}