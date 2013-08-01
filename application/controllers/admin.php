<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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
        // $this->update_rss();
    }

    public function index()
	{
        $this->erkana_auth->required();
        $page = array();
        $page['user'] = $this->account->get($this->session->userdata('user_id'));
        $page['messages'] = $this->messages;
        $page['form_messages'] = $this->form_messages;
        $this->page_title = 'Dashboard';
        $page['content'] = $this->content(array('content_manager', 'add_listing'));
        $page['breadcrumbs'] = $this->breadcrumbs;
        $page['title'] = $this->page_title;
        echo $this->load->view('admin/home', $page, true);
	}

    private function blank($page)
    {
        $this->erkana_auth->required();
        $page['user'] = $this->account->get($this->session->userdata('user_id'));
        $page['messages'] = $this->messages;
        $page['form_messages'] = $this->form_messages;
        $page['breadcrumbs'] = $this->breadcrumbs;
        $page['title'] = $this->page_title;
        echo $this->load->view('admin/home', $page, true);
    }

    public function login()
    {
        $page = array();
        $page['messages'] = array();
        if($this->erkana_auth->validate_login(array('username', 'email'))) {
            redirect('/admin/');
        } else {
            foreach($this->erkana_auth->errors as $error) {
                $this->messages[] = array("type" => 'error', "content" => $error);
            }
            $page['messages'] = $this->messages;
            echo $this->load->view('admin/login', $page, true);
        }
    }

    public function logout()
    {
        $this->erkana_auth->logout();
        redirect('/admin/');
    }

    public function add($type)
    {
        $page = array();
        switch($type) {
            case "listings":
                $this->action('add', 'listing');
                $this->breadcrumbs[] = array('name' => "Listings", 'url' => '/admin/edit/listings');
                $this->breadcrumbs[] = array('name' => "Add Listing", 'url' => '');
                $this->page_title = 'Add New Listing';
                $page['content'] = $this->content(array('add_listing'));
            break;
            case "users":
                $this->action('add', 'user');
                $this->breadcrumbs[] = array('name' => "Users", 'url' => '/admin/edit/users');
                $this->breadcrumbs[] = array('name' => "Add User", 'url' => '');
                $this->page_title = 'Add New User';
                $page['content'] = $this->content(array('add_user'));
            break;
            case "categories":
                $this->action('add', 'category');
                $this->save_routes(); // Updates Routes file
                $this->breadcrumbs[] = array('name' => "Categories", 'url' => '/admin/edit/categories');
                $this->breadcrumbs[] = array('name' => "Add Category", 'url' => '');
                $this->page_title = 'Add New Category';
                $page['content'] = $this->content(array('add_category'));
                break;
            default:
                $page['content'] = '';
            break;
        }
        $this->blank($page);
    }

    public function edit($type, $id = '')
    {
        $page = array();
        switch($type) {
            case "listings":
                if($id > 0) {
                    $this->edit_id = $id;
                    if($this->input->post('submitted')) {
                        $this->action('edit', 'listing');
                    }
                    $this->breadcrumbs[] = array('name' => "Listings", 'url' => '/admin/edit/listings/');
                    $this->breadcrumbs[] = array('name' => "Edit", 'url' => '');
                    $this->page_title = 'Edit Listing';
                    $page['content'] = $this->content(array('edit_listing'));
                } else {
                    $this->breadcrumbs[] = array('name' => "Listings", 'url' => '');
                    $this->page_title = 'All Listings';
                    $page['content'] = $this->content(array('listings'));
                }
                break;
            case "users":
                if($id > 0) {
                    $this->edit_id = $id;
                    if($this->input->post('submitted')) {
                        $this->action('edit', 'user');
                    }
                    $this->breadcrumbs[] = array('name' => "Users", 'url' => '/admin/edit/users/');
                    $this->breadcrumbs[] = array('name' => "Edit", 'url' => '');
                    $this->page_title = 'Edit User';
                    $page['content'] = $this->content(array('edit_user'));
                } else {
                    $this->breadcrumbs[] = array('name' => "Users", 'url' => '');
                    $this->page_title = 'All Users';
                    $page['content'] = $this->content(array('users'));
                }
                break;
            case "categories":
                if($id > 0) {
                    $this->edit_id = $id;
                    if($this->input->post('submitted')) {
                        $this->action('edit', 'category');
                        $this->save_routes(); // Updates Routes file
                    }
                    $this->breadcrumbs[] = array('name' => "Categories", 'url' => '/admin/edit/categories/');
                    $this->breadcrumbs[] = array('name' => "Edit", 'url' => '');
                    $this->page_title = 'Edit Category';
                    $page['content'] = $this->content(array('edit_category'));
                } else {
                    $this->breadcrumbs[] = array('name' => "Categories", 'url' => '');
                    $this->page_title = 'All Categories';
                    $page['content'] = $this->content(array('categories'));
                }
                break;
            default:
                $page['content'] = '';
                break;
        }
        $this->blank($page);
    }

    public function check($type)
    {
        $page = array();
        switch($type) {
            case "listings":
                $this->breadcrumbs[] = array('name' => "Listings", 'url' => '/admin/edit/listings/');
                $this->breadcrumbs[] = array('name' => "Check Listing", 'url' => '');
                $this->page_title = 'Check Listing';
                $page['content'] = $this->content(array('check_listing'));
                break;
            default:
                $page['content'] = '';
                break;
        }
        $this->blank($page);
    }

    public function action($action = '',$type = '', $id = '')
    {
        switch($action) {
            case 'edit':
                $this->action_edit($type);
                break;
            case 'add':
                $this->action_add($type);
            break;
            case 'delete':
                $this->action_delete($type, $id);
            break;
            case 'get':
                if($type == "subcats") {
                    $page['sub_categories'] = $this->admin_model->get_sub_categories($id);
                    $this->load->view('admin/subcats', $page);
                }
                break;
            default:
                $page = array();
                $this->messages[] = array("type" => 'error', "content" => "An error occured: No Action Found");
        }
    }

    public function action_add($type = '')
    {
        $this->messages = array();
        switch($type) {
            case 'listing':
                $this->form_validation->set_rules('listing_title', 'Listing Title', 'required');
                $this->form_validation->set_rules('listing_uri', 'Listing Slug', 'required');
                $this->form_validation->set_rules('listing_url', 'Listing URL', 'required');
                $this->form_validation->set_rules('listing_tracking_img', 'Listing Tracking Image', '');
                $this->form_validation->set_rules('listing_affiliate', 'Listing Affiliate', '');
                $this->form_validation->set_rules('listing_featured', 'Listing Featured', '');
                $this->form_validation->set_rules('listing_desc', 'Listing Description', 'required');
                $this->form_validation->set_rules('listing_alt_desc', 'Alternative Listing Description', 'required');
                $this->form_validation->set_rules('listing_category_id', 'Listing Category', 'required');
                $this->form_validation->set_rules('listing_sub_category_id', 'Listing Sub-Category', 'required');
                $this->form_validation->set_rules('listing_tags', 'Listing Tags', 'required');
                $this->form_validation->set_rules('listing_expires', 'Listing Status', '');
                $this->form_validation->set_rules('listing_status', 'Listing Status', 'required');
                if ($this->form_validation->run()) {
                    $listing_data = array(
                        'listing_title' => set_value('listing_title'),
                        'listing_uri' =>  $this->admin_model->slugify(set_value('listing_uri')),
                        'listing_url' => set_value('listing_url'),
                        'listing_affiliate' => set_value('listing_affiliate'),
                        'listing_featured' => set_value('listing_featured'),
                        'listing_desc' => set_value('listing_desc'),
                        'listing_alt_desc' => set_value('listing_alt_desc'),
                        'listing_tags' => set_value('listing_tags'),
                        'listing_expires' => (set_value('listing_expires') ? set_value('listing_expires') : NULL),
                        'listing_status' => set_value('listing_status')
                    );
                    $listing_id = $this->admin_model->create_listing($listing_data);
                    if($listing_id > 0) {
                        $sites = $this->admin_model->get_sites();
                        foreach($sites as $site) {
                            $listing_alt_desc_data = array (
                                'site_id' => $site['site_id'],
                                'listing_id' => $listing_id,
                                'listing_desc_value' => mt_rand(1,2)
                            );
                            $this->admin_model->create_listing_alt_desc($listing_alt_desc_data);
                        }

                        $listing_category_data = array(
                            'listing_id' => $listing_id,
                            'category_id' => set_value('listing_category_id'),
                            'sub_category_id' => NULL
                        );
                        $this->admin_model->create_listing_category($listing_category_data);

                        if($this->input->post('return_url')) {
                            redirect($this->input->post('return_url'));
                        } else {
                            $this->messages[] = array("type" => 'success', "content" => "Listing added successfully");
                        }
                    } else {
                        $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
                    }
                } else {
                    $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
                }
                break;
            case 'user':
                if($this->erkana_auth->create_account($identifier = 'email')) {
                    if($this->input->post('return_url')) {
                        redirect($this->input->post('return_url'));
                    } else {
                        $this->messages[] = array("type" => 'success', "content" => "User added successfully");
                    }
                } else {
                    $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
                }
                break;
            case 'category':
                $this->form_validation->set_rules('category_name', 'Category Name', 'required');
                $this->form_validation->set_rules('category_slug', 'Category Slug', 'required');
                $this->form_validation->set_rules('category_desc', 'Category Desc', '');
                if ($this->form_validation->run()) {
                    $category_data = array(
                        'category_name' => set_value('category_name'),
                        'category_slug' => $this->admin_model->slugify(set_value('category_slug')),
                        'category_desc' => set_value('category_desc')
                    );
                    $category_id = $this->admin_model->create_category($category_data);
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
                break;
            case '':
                $page = array();
                $this->messages[] = array("type" => 'error', "content" => "An error occured: No Type Set");
                break;
        }
    }

    public function action_edit($type = '')
    {
        $this->messages = array();
        switch($type) {
            case 'listing':
                $this->form_validation->set_rules('listing_title', 'Listing Title', 'required');
                $this->form_validation->set_rules('listing_uri', 'Listing Slug', 'required');
                $this->form_validation->set_rules('listing_url', 'Listing URL', 'required');
                $this->form_validation->set_rules('listing_tracking_img', 'Listing Tracking Image', '');
                $this->form_validation->set_rules('listing_affiliate', 'Listing Affiliate', '');
                $this->form_validation->set_rules('listing_featured', 'Listing Featured', '');
                $this->form_validation->set_rules('listing_desc', 'Listing Description', 'required');
                $this->form_validation->set_rules('listing_alt_desc','Alternative Listing Description', 'required');
                $this->form_validation->set_rules('listing_category_id', 'Listing Category', 'required');
                $this->form_validation->set_rules('listing_sub_category_id', 'Listing Sub-Category', 'required');
                $this->form_validation->set_rules('listing_tags', 'Listing Tags', 'required');
                $this->form_validation->set_rules('listing_expires', 'Listing Status', '');
                $this->form_validation->set_rules('listing_status', 'Listing Status', 'required');
                if ($this->form_validation->run()) {
                    $listing_data = array(
                        'listing_title' => set_value('listing_title'),
                        'listing_uri' =>  $this->admin_model->slugify(set_value('listing_uri')),
                        'listing_url' => set_value('listing_url'),
                        'listing_affiliate' => set_value('listing_affiliate'),
                        'listing_featured' => set_value('listing_featured'),
                        'listing_desc' => set_value('listing_desc'),
                        'listing_alt_desc' => set_value('listing_alt_desc'),
                        'listing_tags' => set_value('listing_tags'),
                        'listing_expires' => (set_value('listing_expires') ? set_value('listing_expires') : NULL),
                        'listing_created' => NULL,
                        'listing_status' => set_value('listing_status')
                    );
                    $listing_id = $this->admin_model->edit_listing($this->edit_id, $listing_data);
                    if($listing_id > 0) {
                        $listing_category_data = array(
                            'listing_id' => $listing_id,
                            'category_id' => set_value('listing_category_id'),
                            'sub_category_id' => set_value('listing_sub_category_id')
                        );
                        $this->admin_model->edit_listing_category($this->edit_id, $listing_category_data);

                        if($this->input->post('return_url')) {
                            redirect($this->input->post('return_url'));
                        } else {
                            $this->messages[] = array("type" => 'success', "content" => "Listing edited successfully");
                        }
                    } else {
                        $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
                    }
                } else {
                    $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
                }
                break;
            case 'user':
                if($this->erkana_auth->edit_account($this->edit_id, $identifier = 'email')) {
                    if($this->input->post('return_url')) {
                        redirect($this->input->post('return_url'));
                    } else {
                        $this->messages[] = array("type" => 'success', "content" => "User edited successfully");
                    }
                } else {
                    $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
                }
                break;
            case 'category':
                $this->form_validation->set_rules('category_name', 'Category Name', 'required');
                $this->form_validation->set_rules('category_slug', 'Category Slug', 'required');
                $this->form_validation->set_rules('category_desc', 'Category Desc', '');
                if ($this->form_validation->run()) {
                    $category_data = array(
                        'category_name' => set_value('category_name'),
                        'category_slug' => $this->admin_model->slugify(set_value('category_slug')),
                        'category_desc' => set_value('category_desc')
                    );
                    $category_id = $this->admin_model->edit_category($this->edit_id, $category_data);
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
                break;
            case '':
                $page = array();
                $this->messages[] = array("type" => 'error', "content" => "An error occured: No Type Set");
                break;
        }
    }

    public function action_delete($type = '', $id)
    {
        $this->edit_id = $id;
        $this->messages = array();
        switch($type) {
            case 'listing':
                if($this->admin_model->delete($type, $this->edit_id)) {
                    if($this->input->post('return_url')) {
                        redirect($this->input->post('return_url'));
                    } else {
                        $this->messages[] = array("type" => 'success', "content" => "Litsing deleted successfully");
                    }
                } else {
                    $this->messages[] = array("type" => 'error', "content" => "Listing could not be deleted.");
                }
                $this->index();
                break;
            case 'user':
                if($this->admin_model->delete($type, $this->edit_id)) {
                    if($this->input->post('return_url')) {
                        redirect($this->input->post('return_url'));
                    } else {
                        $this->messages[] = array("type" => 'success', "content" => "User deleted successfully");
                    }
                } else {
                    $this->messages[] = array("type" => 'error', "content" => "User could not be deleted.");
                }
                $this->index();
                break;
            case 'category':
                if($this->admin_model->delete($type, $this->edit_id)) {
                    if($this->input->post('return_url')) {
                        redirect($this->input->post('return_url'));
                    } else {
                        $this->messages[] = array("type" => 'success', "content" => "Category deleted successfully");
                    }
                } else {
                    $this->messages[] = array("type" => 'error', "content" => "Category could not be deleted.");
                }
                $this->index();
                break;
            default:
                $page = array();
                $this->messages[] = array("type" => 'error', "content" => "An error occured: No Type Found");
                $this->index();
        }
    }

    private function content($contents) {
        $page = array();
        $page['content_manager'] = false;
        $page['listings'] = false;
        $page['add_listing'] = false;
        $page['edit_listing'] = false;
        $page['check_listing'] = false;
        $page['users'] = false;
        $page['add_user'] = false;
        $page['edit_user'] = false;
        $page['categories'] = false;
        $page['add_category'] = false;
        $page['edit_category'] = false;
        foreach($contents as $content) {
            switch($content) {
                case 'content_manager':
                    $page['content_manager'] = true;
                    $page['content_manager_html'] = $this->content_manager();
                    break;
                case 'listings':
                    $page['listings'] = true;
                    $page['listings_html'] = $this->listings();
                    break;
                case 'add_listing':
                    $page['add_listing'] = true;
                    $page['add_listing_html'] = $this->add_listing();
                    break;
                case 'edit_listing':
                    $page['edit_listing'] = true;
                    $page['edit_listing_html'] = $this->edit_listing($this->edit_id);
                    break;
                case 'check_listing':
                    $page['check_listing'] = true;
                    $page['check_listing_html'] = $this->check_listing();
                    break;
                case 'users':
                    $page['users'] = true;
                    $page['users_html'] = $this->users();
                    break;
                case 'add_user':
                    $page['add_user'] = true;
                    $page['add_user_html'] = $this->add_user();
                    break;
                case 'edit_user':
                    $page['edit_user'] = true;
                    $page['edit_user_html'] = $this->edit_user($this->edit_id);
                    break;
                case 'categories':
                    $page['categories'] = true;
                    $page['categories_html'] = $this->categories();
                    break;
                case 'add_category':
                    $page['add_category'] = true;
                    $page['add_category_html'] = $this->add_category();
                    break;
                case 'edit_category':
                    $page['edit_category'] = true;
                    $page['edit_category_html'] = $this->edit_category($this->edit_id);
                    break;
            }
        }
        return $this->load->view('admin/content', $page, true);
    }

    private function content_manager()
    {
        $page = array();
        $page['categories'] = $this->admin_model->get_categories();
        $page['listings'] = $this->admin_model->get_listings();
        $page['users'] = $this->admin_model->get_users();
        return $this->load->view('admin/content_manager', $page, true);
    }

    private function listings()
    {
        $page = array();
        $page['categories'] = $this->admin_model->get_categories();
        $page['listings'] = $this->admin_model->get_listings();
        return $this->load->view('admin/listings', $page, true);
    }

    private function add_listing()
    {
        $page = array();
        $page['sites'] = $this->admin_model->get_sites();
        $page['categories'] = $this->admin_model->get_categories();
        $page['sub_categories'] = $this->admin_model->get_sub_categories(0);
        return $this->load->view('admin/add_listing', $page, true);
    }

    private function edit_listing($id)
    {
        $page = array();
        $listing_record = $this->admin_model->get_listing($id);
        $page['listing_record'] = $listing_record;
        $page['sites'] = $this->admin_model->get_sites();
        $page['categories'] = $this->admin_model->get_categories();
        $page['sub_categories'] = $this->admin_model->get_sub_categories($listing_record->category_id);
        return $this->load->view('admin/edit_listing', $page, true);
    }

    private function check_listing()
    {
        $page = array();
        $page['expired'] = $this->admin_model->get_expired_listing();
        $page['oldest'] = $this->admin_model->get_old_listing();
        return $this->load->view('admin/check_listings', $page, true);
    }

    private function users()
    {
        $page = array();
        $page['users'] = $this->admin_model->get_users();
        return $this->load->view('admin/users', $page, true);
    }

    private function add_user()
    {
        $page = array();
        return $this->load->view('admin/add_user', $page, true);
    }

    private function edit_user($id)
    {
        $page = array();
        $page['user_record'] = $this->admin_model->get_user($id);
        return $this->load->view('admin/edit_user', $page, true);
    }

    private function categories()
    {
        $page = array();
        $page['categories'] = $this->admin_model->get_categories();
        return $this->load->view('admin/categories', $page, true);
    }

    private function add_category()
    {
        $page = array();
        return $this->load->view('admin/add_category', $page, true);
    }

    private function edit_category($id)
    {
        $page = array();
        $page['category_record'] = $this->admin_model->get_category($id);
        return $this->load->view('admin/edit_category', $page, true);
    }

    private function save_routes()
    {
        // this simply returns all the categories from my database
        $categories = $this->admin_model->get_categories();
        $tags = $this->admin_model->get_tags();

        // write out the PHP array to the file with help from the file helper
        if (!empty($categories)) {
            // for every page in the database, get the route using the recursive function - _get_route()
            foreach ($categories as $route) {
                $data[] = '$route["' . $route['category_slug'] . '"] = "home/category/' . $route['category_slug'] .'";';
                $data[] = '$route["' . $route['category_slug'] . '/(:any)"] = "home/category/' . $route['category_slug'] .'/$1";';
            }
            foreach ($tags as $route) {
                $data[] = '$route["' . $route['tag_slug'] . '"] = "home/tag/' . $route['tag_slug'] .'";';
                $data[] = '$route["' . $route['tag_slug'] . '/(:any)"] = "home/tag/' . $route['tag_slug'] .'/$1";';
            }

            $output = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
            $output .= '$route["default_controller"] = "home"; $route["404_override"] = ""; $route["admin"] = "admin"; $route["admin/(:any)"] = "admin/$1";';

            $output .= implode("\n", $data);

            $this->load->helper('file');
            write_file(APPPATH . "config/routes.php", $output);
        }
    }

    private function update_rss()
    {
        // this simply returns all the listing from my database
        $feeds = $this->admin_model->get_listings();

        if (!empty($feeds)) {
            foreach ($feeds as $feed) {
                $data[] = '<item><title>'.$feed['listing_title'].'</title>'.'<description>'.$feed['listing_desc'].'</description>'.'<link>/listing/'.$feed['listing_id'].'</link>'.'</item>';
            }

            $output = '<?xml version= "1.0"?><rss version= "2.0"><channel>';

            $output .= implode("\n", $data);

            $output .= '</channel></rss>';

            $this->load->helper('file');
            write_file(APPPATH . "cache/rss.xml", $output);
        }
    }

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
