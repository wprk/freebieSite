<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
{
    protected $messages = array();
    protected $form_messages;

    function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library(array('session', 'Erkana_auth'));
        $this->load->model('admin_model');
        $this->load->model('account');
        $this->breadcrumbs[] = array('name' => "Users", 'url' => '/s5k9d7f6jdn0/users/');
    }

    public function index()
    {
        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "View", 'url' => '/s5k9d7f6jdn0/users/');

        $page = $this->getPageData();

        $page['title'] = 'Users';
        $page['users'] = $this->admin_model->get_users();
        $page['content'] = $this->load->view('admin/users', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function add()
    {
        if($this->input->post('fullname')) {
            $this->addUser();
        }

        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "Add", 'url' => '/s5k9d7f6jdn0/users/add/');

        $page = $this->getPageData();

        $page['title'] = 'Add User';
        $page['content'] = $this->load->view('admin/add_user', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function edit($id = null)
    {
        if($id != null) {
            if($this->input->post('fullname')) {
                $this->editUser($id);
            }

            $this->erkana_auth->required();
            $this->breadcrumbs[] = array('name' => "Edit", 'url' => '/s5k9d7f6jdn0/users/edit');

            $page = $this->getPageData();

            $page['title'] = 'Edit User';
            $page['user_record'] = $this->admin_model->get_user($id);
            $page['content'] = $this->load->view('admin/edit_user', $page, true);

            echo $this->load->view('admin/home', $page, true);
        } else {
            $this->index();
        }
    }

    public function delete($id)
    {
        if($this->admin_model->delete('user', $id)) {
            if($this->input->post('return_url')) {
                redirect($this->input->post('return_url'));
            } else {
                $this->messages[] = array("type" => 'success', "content" => "User deleted successfully");
            }
        } else {
            $this->messages[] = array("type" => 'error', "content" => "User could not be deleted.");
        }
        $this->index();
    }

    protected function getPageData()
    {
        $page = array();
        $page['user'] = $this->account->get($this->session->userdata('user_id'));
        $page['messages'] = $this->messages;
        $page['form_messages'] = $this->form_messages;
        $page['breadcrumbs'] = $this->breadcrumbs;
        return $page;
    }

    protected function addUser()
    {
        if($this->erkana_auth->create_account($identifier = 'email')) {
            if($this->input->post('return_url')) {
                redirect($this->input->post('return_url'));
            } else {
                $this->messages[] = array("type" => 'success', "content" => "User added successfully");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }

    protected function editCategory($id)
    {
        if($this->erkana_auth->edit_account($$id, $identifier = 'email')) {
            if($this->input->post('return_url')) {
                redirect($this->input->post('return_url'));
            } else {
                $this->messages[] = array("type" => 'success', "content" => "User edited successfully");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }
}