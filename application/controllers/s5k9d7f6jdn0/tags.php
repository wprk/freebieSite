<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends CI_Controller
{
    protected $messages = array();
    protected $form_messages;

    function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library(array('session', 'Erkana_auth'));
        $this->load->model('admin_model');
        $this->load->model('account');
        $this->breadcrumbs[] = array('name' => "Tags", 'url' => '/s5k9d7f6jdn0/tags/');
    }

    public function index()
    {
        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "View", 'url' => '/s5k9d7f6jdn0/tags/');

        $page = $this->getPageData();

        $page['title'] = 'Tags';
        $page['tags'] = $this->admin_model->get_tags();
        $page['content'] = $this->load->view('admin/tags', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function add()
    {
        if($this->input->post('tag_name')) {
            $this->addTag();
        }

        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "Add", 'url' => '/s5k9d7f6jdn0/tags/add/');

        $page = $this->getPageData();

        $page['title'] = 'Add Tag';
        $page['content'] = $this->load->view('admin/add_tag', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function edit($id = null)
    {
        if($id != null) {
            if($this->input->post('tag_name')) {
                $this->editTag($id);
            }

            $this->erkana_auth->required();
            $this->breadcrumbs[] = array('name' => "Edit", 'url' => '/s5k9d7f6jdn0/tags/edit/');

            $page = $this->getPageData();

            $page['title'] = 'Edit Tag';
            $page['tag_record'] = $this->admin_model->get_tag($id);
            $page['content'] = $this->load->view('admin/edit_tag', $page, true);

            echo $this->load->view('admin/home', $page, true);
        } else {
            $this->index();
        }
    }

    public function delete($id)
    {
        if($this->admin_model->delete('tag', $id)) {
            $this->admin_model->save_routes(); // Updates Routes file
            if($this->input->post('return_url')) {
                redirect($this->input->post('return_url'));
            } else {
                $this->messages[] = array("type" => 'success', "content" => "Tag deleted successfully");
            }
        } else {
            $this->messages[] = array("type" => 'error', "content" => "Tag could not be deleted.");
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

    protected function addTag()
    {
        $this->form_validation->set_rules('tag_name', 'Tag Name', 'required');
        if ($this->form_validation->run()) {
            $slug = $this->input->post('tag_slug');
            $finalSlug = (strlen($slug)>0 ? $slug : $this->admin_model->slugify(set_value('tag_name')));
            $tag_data = array(
                'tag_name' => set_value('tag_name'),
                'tag_slug' => $finalSlug
            );
            $tag_id = $this->admin_model->create_tag($tag_data);
            $this->admin_model->save_routes(); // Updates Routes file
            if($tag_id > 0) {
                if($this->input->post('return_url')) {
                    redirect($this->input->post('return_url'));
                } else {
                    $this->messages[] = array("type" => 'success', "content" => "Tag added successfully");
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }

    protected function editTag($id)
    {
        $this->form_validation->set_rules('tag_name', 'Tag Name', 'required');
        if ($this->form_validation->run()) {
            $slug = $this->input->post('tag_slug');
            $finalSlug = (strlen($slug)>0 ? $slug : $this->admin_model->slugify(set_value('tag_name')));
            $tag_data = array(
                'tag_name' => set_value('tag_name'),
                'tag_slug' => $finalSlug
            );
            $tag_id = $this->admin_model->edit_tag($id, $tag_data);
            $this->admin_model->save_routes(); // Updates Routes file
            if($tag_id > 0) {
                if($this->input->post('return_url')) {
                    redirect($this->input->post('return_url'));
                } else {
                    $this->messages[] = array("type" => 'success', "content" => "Tag edited successfully");
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }
}