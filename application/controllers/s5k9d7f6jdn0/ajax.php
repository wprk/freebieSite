<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library(array('session', 'Erkana_auth'));
        $this->load->model('admin_model');
        $this->load->model('account');
    }

    public function subcats($id)
    {
        $page['sub_categories'] = $this->admin_model->get_sub_categories($id);
        $this->load->view('admin/subcats', $page);
    }

    public function add_tag()
    {
        $tag_name = $this->input->get_post('tag_name');
        if ($tag_name) {
            $tag_data = array(
                'tag_name' => $tag_name,
                'tag_slug' => $this->admin_model->slugify($tag_name),
                'tag_created' => date('Y-m-d H:i:s')
            );
            $tag_id = $this->admin_model->create_tag($tag_data);
            $this->admin_model->save_routes(); // Updates Routes file
            if($tag_id > 0) {
                die(json_encode(
                    array(
                        'tag_id' => $tag_id,
                        'tag_name' => $tag_data['tag_name']
                    )
                ));
                if($this->input->get_post('ajax')) {
                    die(json_encode(
                        array(
                            'tag_id' => $tag_id,
                            'tag_name' => $tag_data['tag_name']
                        )
                    ));
                } else {
                    if($this->input->post('return_url')) {
                        redirect($this->input->post('return_url'));
                    } else {
                        $this->messages[] = array("type" => 'success', "content" => "Tag added successfully");
                    }
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = '<h4 class="alert_error">A tag name was not submitted!</h4>';
        }
    }

    public function alter_homepage_listing()
    {
        if($this->admin_model->alter_homepage_listing($_POST['listings'])) {
            return true;
        } else {
            return false;
        }
    }

    public function update_homepage()
    {
        if($this->admin_model->update_hompage($_POST['listings'])) {
            return true;
        } else {
            return false;
        }
    }
}