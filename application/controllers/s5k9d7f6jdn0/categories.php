<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller
{
    protected $messages = array();
    protected $form_messages;

    function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library(array('session', 'Erkana_auth'));
        $this->load->model('admin_model');
        $this->load->model('account');
        $this->breadcrumbs[] = array('name' => "Categories", 'url' => '/s5k9d7f6jdn0/categories/');
    }

    public function index()
    {
        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "View", 'url' => '/s5k9d7f6jdn0/categories/');

        $page = $this->getPageData();

        $page['title'] = 'Categories';
        $page['categories'] = $this->admin_model->get_categories();
        $page['content'] = $this->load->view('admin/categories', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function add()
    {
        if($this->input->post('category_name')) {
            $this->addCategory();
        }

        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "Add", 'url' => '/s5k9d7f6jdn0/categories/add/');

        $page = $this->getPageData();

        $page['title'] = 'Add Category';
        $page['content'] = $this->load->view('admin/add_category', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function addsub()
    {
        if($this->input->post('sub_category_name')) {
            $this->addSubCategory();
        }

        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "Add", 'url' => '/s5k9d7f6jdn0/categories/add/sub');

        $page = $this->getPageData();

        $page['title'] = 'Add Sub Category';
        $page['categories'] = $this->admin_model->get_categories();
        $page['content'] = $this->load->view('admin/add_sub_category', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function edit($id = null)
    {
        if($id != null) {
            if($this->input->post('category_name')) {
                $this->editCategory($id);
            }

            $this->erkana_auth->required();
            $this->breadcrumbs[] = array('name' => "Edit", 'url' => '/s5k9d7f6jdn0/categories/edit/');

            $page = $this->getPageData();

            $page['title'] = 'Edit Category';
            $page['category_record'] = $this->admin_model->get_category($id);
            $page['content'] = $this->load->view('admin/edit_category', $page, true);

            echo $this->load->view('admin/home', $page, true);
        } else {
            $this->index();
        }
    }

    public function editsub($id = null)
    {
        if($id != null) {
            if($this->input->post('sub_category_name')) {
                $this->editSubCategory($id);
            }

            $this->erkana_auth->required();
            $this->breadcrumbs[] = array('name' => "Edit", 'url' => '/s5k9d7f6jdn0/categories/editsub/');

            $page = $this->getPageData();

            $page['title'] = 'Edit Sub Category';
            $page['sub_category_record'] = $this->admin_model->get_sub_category($id);
            $page['categories'] = $this->admin_model->get_categories();
            $page['content'] = $this->load->view('admin/edit_sub_category', $page, true);

            echo $this->load->view('admin/home', $page, true);
        } else {
            $this->index();
        }
    }

    public function delete($id, $type = 'category')
    {
        if($this->admin_model->delete($type, $id)) {
            $this->admin_model->save_routes(); // Updates Routes file
            if($this->input->post('return_url')) {
                redirect($this->input->post('return_url'));
            } else {
                $this->messages[] = array("type" => 'success', "content" => $type . " deleted successfully");
            }
        } else {
            $this->messages[] = array("type" => 'error', "content" => $type . " could not be deleted.");
        }
        $this->index();
    }

    public function deletesub($id)
    {
        if($this->admin_model->delete('sub_category', $id)) {
            $this->admin_model->save_routes(); // Updates Routes file
            if($this->input->post('return_url')) {
                redirect($this->input->post('return_url'));
            } else {
                $this->messages[] = array("type" => 'success', "content" => "Sub Category deleted successfully");
            }
        } else {
            $this->messages[] = array("type" => 'error', "content" => "Sub Category  could not be deleted.");
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

    protected function addCategory()
    {
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');
        $this->form_validation->set_rules('category_desc', 'Category Desc', '');
        if ($this->form_validation->run()) {
            $slug = $this->input->post('category_slug');
            $finalSlug = (strlen($slug)>0 ? $slug : $this->admin_model->slugify(set_value('category_name')));
            $category_data = array(
                'category_name' => set_value('category_name'),
                'category_slug' => $finalSlug,
                'category_desc' => set_value('category_desc')
            );
            $category_id = $this->admin_model->create_category($category_data);
            $this->admin_model->save_routes(); // Updates Routes file
            if($category_id > 0) {
                if($this->input->post('return_url')) {
                    redirect($this->input->post('return_url'));
                } else {
                    $this->messages[] = array("type" => 'success', "content" => "Category added successfully");
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }

    protected function addSubCategory()
    {
        $this->form_validation->set_rules('category_id', 'Parent Category', 'required');
        $this->form_validation->set_rules('sub_category_name', 'Category Name', 'required');
        $this->form_validation->set_rules('sub_category_desc', 'Category Desc', '');
        if ($this->form_validation->run()) {
            $slug = $this->input->post('sub_category_slug');
            $finalSlug = (strlen($slug)>0 ? $slug : $this->admin_model->slugify(set_value('sub_category_name')));
            $sub_category_data = array(
                'category_id' => set_value('category_id'),
                'sub_category_name' => set_value('sub_category_name'),
                'sub_category_slug' => $finalSlug,
                'sub_category_desc' => set_value('sub_category_desc')
            );
            $sub_category_id = $this->admin_model->create_sub_category($sub_category_data);
            $this->admin_model->save_routes(); // Updates Routes file
            if($sub_category_id > 0) {
                if($this->input->post('return_url')) {
                    redirect($this->input->post('return_url'));
                } else {
                    $this->messages[] = array("type" => 'success', "content" => "Sub Category added successfully");
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }

    protected function editCategory($id)
    {
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');
        $this->form_validation->set_rules('category_desc', 'Category Desc', '');
        if ($this->form_validation->run()) {
            $slug = $this->input->post('category_slug');
            $finalSlug = (strlen($slug)>0 ? $slug : $this->admin_model->slugify(set_value('category_name')));
            $category_data = array(
                'category_name' => set_value('category_name'),
                'category_slug' => $finalSlug,
                'category_desc' => set_value('category_desc')
            );
            $category_id = $this->admin_model->edit_category($id, $category_data);
            $this->admin_model->save_routes(); // Updates Routes file
            if($category_id > 0) {
                if($this->input->post('return_url')) {
                    redirect($this->input->post('return_url'));
                } else {
                    $this->messages[] = array("type" => 'success', "content" => "Category edited successfully");
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }

    protected function editSubCategory($id)
    {
        $this->form_validation->set_rules('category_id', 'Parent Category', 'required');
        $this->form_validation->set_rules('sub_category_name', 'Sub Category Name', 'required');
        $this->form_validation->set_rules('sub_category_desc', 'Sub Category Desc', '');
        if ($this->form_validation->run()) {
            $slug = $this->input->post('sub_category_slug');
            $finalSlug = (strlen($slug)>0 ? $slug : $this->admin_model->slugify(set_value('sub_category_name')));
            $sub_category_data = array(
                'sub_category_name' => set_value('sub_category_name'),
                'sub_category_slug' => $finalSlug,
                'sub_category_desc' => set_value('sub_category_desc')
            );
            $sub_category_id = $this->admin_model->edit_sub_category($id, $sub_category_data);
            $this->admin_model->save_routes(); // Updates Routes file
            if($sub_category_id > 0) {
                if($this->input->post('return_url')) {
                    redirect($this->input->post('return_url'));
                } else {
                    $this->messages[] = array("type" => 'success', "content" => "Sub Category edited successfully");
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }
}