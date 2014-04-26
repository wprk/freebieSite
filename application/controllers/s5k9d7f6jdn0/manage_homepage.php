<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_Homepage extends CI_Controller
{
    protected $messages = array();
    protected $form_messages;

    function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library(array('session', 'Erkana_auth'));
        $this->load->model('admin_model');
        $this->load->model('account');
        $this->breadcrumbs[] = array('name' => "Manage Homepage", 'url' => '/s5k9d7f6jdn0/manage_homepage/');
    }

    public function index()
    {
        $this->erkana_auth->required();

        $page = $this->getPageData();

        $page['title'] = 'Manage Homepage';
        $page['affiliate_listings'] = $this->admin_model->get_affiliate_listings();
        $page['chosen_listings'] = $this->admin_model->get_chosen_listings();
        $page['content'] = $this->load->view('admin/manage_homepage', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function add()
    {
        if($this->input->post('page_name')) {
            $this->addPage();
        }

        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "Add", 'url' => '/s5k9d7f6jdn0/pages/add/');

        $page = $this->getPageData();

        $page['title'] = 'Add Page';
        $page['tags'] = $this->admin_model->get_tags();
        $page['content'] = $this->load->view('admin/add_page', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function edit($id = null)
    {
        if($id != null) {
            if($this->input->post('page_name')) {
                $this->editPage($id);
            }

            $this->erkana_auth->required();
            $this->breadcrumbs[] = array('name' => "Edit", 'url' => '/s5k9d7f6jdn0/pages/edit/');

            $page = $this->getPageData();

            $page['title'] = 'Edit Page';
            $page['page_record'] = $this->admin_model->get_page($id);
            $page['tags'] = $this->admin_model->get_tags();
            $page['content'] = $this->load->view('admin/edit_page', $page, true);

            echo $this->load->view('admin/home', $page, true);
        } else {
            $this->index();
        }
    }

    public function delete($id)
    {
        if($this->admin_model->delete('page', $id)) {
            $this->admin_model->save_routes(); // Updates Routes file
            if($this->input->post('return_url')) {
                redirect($this->input->post('return_url'));
            } else {
                $this->messages[] = array("type" => 'success', "content" => "Page deleted successfully");
            }
        } else {
            $this->messages[] = array("type" => 'error', "content" => "Page could not be deleted.");
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

    protected function addPage()
    {
        $this->form_validation->set_rules('page_name', 'Page Name', 'required');
        if ($this->form_validation->run()) {
            $slug = $this->input->post('page_slug');
            $finalSlug = (strlen($slug)>0 ? $slug : $this->admin_model->slugify(set_value('page_name')));
            $page_data = array(
                'page_name' => set_value('page_name'),
                'page_slug' => $finalSlug
            );
            $page_id = $this->admin_model->create_page($page_data);
            $this->admin_model->save_routes(); // Updates Routes file
            if($page_id > 0) {
                $post_tags = $this->input->post('page_tags');
                if (is_array($post_tags)) {
                    foreach ($post_tags as $tag) {
                        $page_tag_data = array (
                            'tag_id' => $tag,
                            'page_id' => $page_id
                        );
                        $this->admin_model->create_page_tag($page_tag_data);
                    }
                } else {
                    $page_tag_data = $post_tags;
                    $this->admin_model->create_page_tag($page_tag_data);
                }
                if($this->input->post('return_url')) {
                    redirect($this->input->post('return_url'));
                } else {
                    $this->messages[] = array("type" => 'success', "content" => "Page added successfully");
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }

    protected function editPage($id)
    {
        $this->form_validation->set_rules('page_name', 'Page Name', 'required');
        if ($this->form_validation->run()) {
            $slug = $this->input->post('page_slug');
            $finalSlug = (strlen($slug)>0 ? $slug : $this->admin_model->slugify(set_value('page_name')));
            $page_data = array(
                'page_name' => set_value('page_name'),
                'page_slug' => $finalSlug
            );
            $page_id = $this->admin_model->edit_page($id, $page_data);
            $this->admin_model->save_routes(); // Updates Routes file
            if($page_id > 0) {
                if($tags = $this->input->post('page_tags')) {
                    if($tags)
                    foreach ($tags as $tag) {
                        $page_tag_data[] = array (
                            'tag_id' => $tag,
                            'page_id' => $page_id
                        );
                    }
                    $this->admin_model->update_page_tags($page_id, $page_tag_data);
                }
                if($this->input->post('return_url')) {
                    redirect($this->input->post('return_url'));
                } else {
                    $this->messages[] = array("type" => 'success', "content" => "Page edited successfully");
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }
}