<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sites extends CI_Controller
{
    protected $messages = array();
    protected $form_messages;

    function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library(array('session', 'Erkana_auth'));
        $this->load->model('admin_model');
        $this->load->model('account');
        $this->breadcrumbs[] = array('name' => "Sites", 'url' => '/s5k9d7f6jdn0/sites/');
    }

    public function index()
    {
        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "View", 'url' => '/s5k9d7f6jdn0/sites/');

        $page = $this->getPageData();

        $page['title'] = 'Sites';
        $page['sites'] = $this->admin_model->get_sites();
        $page['content'] = $this->load->view('admin/sites', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function add()
    {
        if($this->input->post('site_name')) {
            $this->addSite();
        }

        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "Add", 'url' => '/s5k9d7f6jdn0/sites/add/');

        $page = $this->getPageData();

        $page['title'] = 'Add Site';
        $page['content'] = $this->load->view('admin/add_site', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function edit($id = null)
    {
        if($id != null) {
            if($this->input->post('site_name')) {
                $this->editSite($id);
            }

            $this->erkana_auth->required();
            $this->breadcrumbs[] = array('name' => "Edit", 'url' => '/s5k9d7f6jdn0/sites/edit/');

            $page = $this->getPageData();

            $page['title'] = 'Edit Site';
            $page['site_record'] = $this->admin_model->get_site($id);
            $page['content'] = $this->load->view('admin/edit_site', $page, true);

            echo $this->load->view('admin/home', $page, true);
        } else {
            $this->index();
        }
    }

    public function delete($id)
    {
        if($this->admin_model->delete('site', $id)) {
            if($this->input->post('return_url')) {
                redirect($this->input->post('return_url'));
            } else {
                $this->messages[] = array("type" => 'success', "content" => "Site deleted successfully");
            }
        } else {
            $this->messages[] = array("type" => 'error', "content" => "Site could not be deleted.");
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

    protected function addSite()
    {
        $this->form_validation->set_rules('site_name', 'Site Name', 'required');
        $this->form_validation->set_rules('site_url', 'Site Url', 'required');
        $this->form_validation->set_rules('site_summary', 'Site Summary', 'required');
        $this->form_validation->set_rules('google_analytics', 'Google Analytics ID', 'required');
        $this->form_validation->set_rules('twitter_handle', 'Twitter Handle', '');
        $this->form_validation->set_rules('facebook_handle', 'Facebook Handle', '');
        if ($this->form_validation->run()) {
            $site_data = array(
                'site_name' => set_value('site_name'),
                'site_url' => set_value('site_url'),
                'site_summary' => set_value('site_summary'),
                'google_analytics' => set_value('google_analytics'),
                'twitter_handle' => set_value('twitter_handle'),
                'facebook_handle' => set_value('facebook_handle')
            );
            $site_id = $this->admin_model->create_site($site_data);
            if($site_id > 0) {
                if($this->input->post('return_url')) {
                    redirect($this->input->post('return_url'));
                } else {
                    $this->messages[] = array("type" => 'success', "content" => "Site added successfully");
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }

    protected function editSite($id)
    {
        $this->form_validation->set_rules('site_name', 'Site Name', 'required');
        $this->form_validation->set_rules('site_url', 'Site Url', 'required');
        $this->form_validation->set_rules('site_summary', 'Site Summary', 'required');
        $this->form_validation->set_rules('google_analytics', 'Google Analytics ID', 'required');
        $this->form_validation->set_rules('twitter_handle', 'Twitter Handle', '');
        $this->form_validation->set_rules('facebook_handle', 'Facebook Handle', '');
        if ($this->form_validation->run()) {
            $site_data = array(
                'site_name' => set_value('site_name'),
                'site_url' => set_value('site_url'),
                'site_summary' => set_value('site_summary'),
                'google_analytics' => set_value('google_analytics'),
                'twitter_handle' => set_value('twitter_handle'),
                'facebook_handle' => set_value('facebook_handle')
            );
            $site_id = $this->admin_model->edit_site($id, $site_data);
            if($site_id > 0) {
                if($this->input->post('return_url')) {
                    redirect($this->input->post('return_url'));
                } else {
                    $this->messages[] = array("type" => 'success', "content" => "Site edited successfully");
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }
}