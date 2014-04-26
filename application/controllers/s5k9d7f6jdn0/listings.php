<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listings extends CI_Controller
{
    protected $messages = array();
    protected $form_messages;

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'Erkana_auth', 'form_validation'));
        $this->load->model('admin_model');
        $this->load->model('account');
        $this->breadcrumbs[] = array('name' => "Listings", 'url' => '/s5k9d7f6jdn0/listings/');
    }

    public function index()
    {
        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "View", 'url' => '/s5k9d7f6jdn0/listings/');

        $page = $this->getPageData();

        $page['title'] = 'Listings';
        $page['categories'] = $this->admin_model->get_categories();
        $page['tags'] = $this->admin_model->get_tags();
        $page['listings'] = $this->admin_model->get_listings();
        $page['content'] = $this->load->view('admin/listings', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function add()
    {
        if($this->input->post('listing_title')) {
            $this->addListing();
        }

        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "Add", 'url' => '/s5k9d7f6jdn0/listings/add/');

        $page = $this->getPageData();

        $page['title'] = 'Add Listing';
        $page['sites'] = $this->admin_model->get_sites();
        $page['categories'] = $this->admin_model->get_categories();
        $page['sub_categories'] = $this->admin_model->get_sub_categories(0);
        $page['tags'] = $this->admin_model->get_tags();
        $page['content'] = $this->load->view('admin/listings_form', $page, true);

        echo $this->load->view('admin/home', $page, true);
    }

    public function edit($id = null)
    {
        if($id != null) {
            if($this->input->post('listing_title')) {
                $this->editListing($id);
            }

            $this->erkana_auth->required();
            $this->breadcrumbs[] = array('name' => "Edit", 'url' => '/s5k9d7f6jdn0/listings/edit/');

            $page = $this->getPageData();

            $page['title'] = 'Edit Listing';
            $page['listing_record'] = $this->admin_model->get_listing($id);
            $page['sites'] = $this->admin_model->get_sites();
            $page['categories'] = $this->admin_model->get_categories();
            $page['sub_categories'] = $this->admin_model->get_sub_categories($page['listing_record']->category_id);
            $page['tags'] = $this->admin_model->get_tags();
            $page['content'] = $this->load->view('admin/listings_form', $page, true);

            echo $this->load->view('admin/home', $page, true);
        } else {
            $this->index();
        }
    }

    public function images($id = null)
    {
        if($id != null) {
            if($this->input->post('submitted')) {
                $this->imagesListing($id);
            }

            $this->erkana_auth->required();
            $this->breadcrumbs[] = array('name' => "Images", 'url' => '/s5k9d7f6jdn0/listings/images/');

            $page = $this->getPageData();

            $page['title'] = 'Listing Images';
            $page['listing_record'] = $this->admin_model->get_listing($id);
            $page['content'] = $this->load->view('admin/listings_images', $page, true);

            echo $this->load->view('admin/home', $page, true);
        } else {
            $this->index();
        }
    }

    public function delete($id)
    {
        if($this->admin_model->delete('listing', $id)) {
            if($this->input->post('return_url')) {
                redirect($this->input->post('return_url'));
            } else {
                $this->messages[] = array("type" => 'success', "content" => "Listing deleted successfully");
            }
        } else {
            $this->messages[] = array("type" => 'error', "content" => "Listing could not be deleted.");
        }
        $this->index();
    }

    public function check()
    {
        $this->erkana_auth->required();
        $this->breadcrumbs[] = array('name' => "Check", 'url' => '/s5k9d7f6jdn0/listings/check/');

        $page = $this->getPageData();

        $page['title'] = 'Check Listings';
        $page['expired'] = $this->admin_model->get_expired_listing();
        $page['oldest'] = $this->admin_model->get_old_listing();
        $page['content'] = $this->load->view('admin/check_listings', $page, true);

        echo $this->load->view('admin/home', $page, true);
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

    protected function addListing()
    {
        $this->form_validation->set_rules('listing_title', 'Listing Title', 'required');
        $this->form_validation->set_rules('listing_alt_title', 'Alternative Listing Title', 'required');
        $this->form_validation->set_rules('listing_url', 'Listing URL', 'required|is_unique[listings.listing_uri]');
        $this->form_validation->set_rules('listing_tracking_img', 'Listing Tracking Image', '');
        $this->form_validation->set_rules('listing_affiliate', 'Listing Affiliate', '');
        $this->form_validation->set_rules('listing_featured', 'Listing Featured', '');
        $this->form_validation->set_rules('listing_desc', 'Listing Description', 'required');
        $this->form_validation->set_rules('listing_alt_desc', 'Alternative Listing Description', 'required');
        $this->form_validation->set_rules('listing_notes', 'Listing Notes', '');
        $this->form_validation->set_rules('listing_category_id', 'Listing Category', 'required');
        $this->form_validation->set_rules('listing_sub_category_id', 'Listing Sub-Category', 'required');
        $this->form_validation->set_rules('listing_sml_img', 'Listing Image', '');
        $this->form_validation->set_rules('listing_expires', 'Listing Expiry', '');
        $this->form_validation->set_rules('listing_status', 'Listing Status', 'required');
        if ($this->form_validation->run()) {
            $listing_data = array(
                'listing_title' => set_value('listing_title'),
                'listing_alt_title' => set_value('listing_alt_title'),
                'listing_uri' =>  $this->admin_model->slugify(set_value('listing_title')),
                'listing_url' => set_value('listing_url'),
                'listing_affiliate' => set_value('listing_affiliate'),
                'listing_featured' => set_value('listing_featured'),
                'listing_desc' => set_value('listing_desc'),
                'listing_notes' => set_value('listing_notes'),
                'listing_alt_desc' => set_value('listing_alt_desc'),
                'listing_expires' => (set_value('listing_expires') ? set_value('listing_expires') : NULL),
                'listing_status' => set_value('listing_status')
            );
            $listing_id = $this->admin_model->create_listing($listing_data);
            if ($listing_id > 0) {
                $listing = $this->admin_model->get_listing($listing_id);
                $sites = $this->admin_model->get_sites();
                foreach ($sites as $site) {
                    $listing_alt_desc_data = array (
                        'site_id' => $site['site_id'],
                        'listing_id' => $listing_id,
                        'listing_desc_value' => mt_rand(1, 2)
                    );
                    $this->admin_model->create_listing_alt_desc($listing_alt_desc_data);
                    $listing_alt_title_data = array (
                        'site_id' => $site['site_id'],
                        'listing_id' => $listing_id,
                        'listing_title_value' => mt_rand(1, 2)
                    );
                    $this->admin_model->create_listing_alt_title($listing_alt_title_data);
                }

                $imageUri = $this->admin_model->slugify($listing->listing_title);
                $listing_sml_img_data = array(
                    'listing_id' => $listing_id,
                    'img_size' => '115x115',
                    'img_ext' => 'png',
                    'img_uri' => $imageUri . '-sml'
                );
                $this->admin_model->create_img('listing_sml_img', $listing_sml_img_data);

                $post_tags = $this->input->post('listing_tags');
                if (is_array($post_tags)) {
                    foreach ($post_tags as $tag) {
                        $listing_tag_data = array (
                            'tag_id' => $tag,
                            'listing_id' => $listing_id,
                            'tag_added' => date('Y-m-d h:i:s')
                        );
                        $this->admin_model->create_listing_tag($listing_tag_data);
                    }
                } else {
                    $listing_tag_data = $post_tags;
                    $this->admin_model->create_listing_tag($listing_tag_data);
                }

                $listing_category_data = array(
                    'listing_id' => $listing_id,
                    'category_id' => set_value('listing_category_id'),
                    'sub_category_id' => NULL
                );
                $this->admin_model->create_listing_category($listing_category_data);

                $this->admin_model->save_routes(); // Updates Routes file
                if($this->input->post('return_url')) {
                    redirect($this->input->post('return_url'));
                } else {
                    $this->messages[] = array("type" => 'success', "content" => "Listing added successfully");
                    redirect('/s5k9d7f6jdn0/listings/images/'.$listing_id);
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }

    protected function editListing($editId)
    {
        $this->form_validation->set_rules('listing_title', 'Listing Title', 'required');
        $this->form_validation->set_rules('listing_alt_title', 'Alternative Listing Title', 'required');
        $this->form_validation->set_rules('listing_url', 'Listing URL', 'required');
        $this->form_validation->set_rules('listing_tracking_img', 'Listing Tracking Image', '');
        $this->form_validation->set_rules('listing_affiliate', 'Listing Affiliate', '');
        $this->form_validation->set_rules('listing_featured', 'Listing Featured', '');
        $this->form_validation->set_rules('listing_desc', 'Listing Description', 'required');
        $this->form_validation->set_rules('listing_alt_desc','Alternative Listing Description', 'required');
        $this->form_validation->set_rules('listing_notes','Listing Notes', '');
        $this->form_validation->set_rules('listing_category_id', 'Listing Category', 'required');
        $this->form_validation->set_rules('listing_sub_category_id', 'Listing Sub-Category', 'required');
        $this->form_validation->set_rules('listing_sml_img', 'Listing Image', '');
        $this->form_validation->set_rules('listing_expires', 'Listing Expiry', '');
        $this->form_validation->set_rules('listing_status', 'Listing Status', 'required');
        if ($this->form_validation->run()) {
            $listing_data = array(
                'listing_title' => set_value('listing_title'),
                'listing_alt_title' => set_value('listing_alt_title'),
                'listing_uri' =>  $this->admin_model->slugify(set_value('listing_title')),
                'listing_url' => set_value('listing_url'),
                'listing_affiliate' => set_value('listing_affiliate'),
                'listing_featured' => set_value('listing_featured'),
                'listing_desc' => set_value('listing_desc'),
                'listing_alt_desc' => set_value('listing_alt_desc'),
                'listing_notes' => set_value('listing_notes'),
                'listing_expires' => (set_value('listing_expires') ? set_value('listing_expires') : NULL),
                'listing_created' => NULL,
                'listing_status' => set_value('listing_status')
            );
            $listing_id = $this->admin_model->edit_listing($editId, $listing_data);
            if ($listing_id > 0) {
                $listing = $this->admin_model->get_listing($listing_id);
                $imageUri = $this->admin_model->slugify($listing->listing_title);
                $listing_sml_img_data = array(
                    'listing_id' => $listing_id,
                    'img_size' => '115x115',
                    'img_ext' => 'png',
                    'img_uri' => $imageUri . '-sml'
                );
                $this->admin_model->create_img('listing_sml_img', $listing_sml_img_data);

                $tags = $this->input->post('listing_tags');
                $add_tags = $this->input->post('add_tags');
                if ($add_tags) {
                    foreach ($tags as $tag) {
                        $listing_tag_data[] = array (
                            'tag_id' => $tag,
                            'listing_id' => $listing_id,
                            'tag_added' => date('Y-m-d h:i:s')
                        );
                    }
                    $this->admin_model->update_listing_tags($listing_id, $listing_tag_data);
                }

                $listing_category_data = array(
                    'listing_id' => $listing_id,
                    'category_id' => set_value('listing_category_id'),
                    'sub_category_id' => set_value('listing_sub_category_id')
                );
                $this->admin_model->edit_listing_category($editId, $listing_category_data);

                $this->admin_model->save_routes(); // Updates Routes file
                if($this->input->post('return_url')) {
                    redirect($this->input->post('return_url'));
                } else {
                    $this->messages[] = array("type" => 'success', "content" => "Listing edited successfully");
                    redirect('/s5k9d7f6jdn0/listings/images/'.$listing_id);
                }
            } else {
                $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
            }
        } else {
            $this->form_messages = validation_errors('<h4 class="alert_error">','</h4>');
        }
    }
    protected function imagesListing($listing_id)
    {
        $listing = $this->admin_model->get_listing($listing_id);
        $imageUri = $this->admin_model->slugify($listing->listing_title);
        $listing_lrg_img_data = array (
            'listing_id' => $listing_id,
            'img_size' => '520x520',
            'img_ext' => 'png',
            'img_uri' => $imageUri . '-lrg'
        );
        $imageResult_lrg = $this->admin_model->create_img('listing_lrg_img', $listing_lrg_img_data);

        if ($imageResult_lrg) {
            $this->messages[] = array("type" => 'success', "content" => "Listing images updated successfully");
        } else {
            $this->messages[] = array("type" => 'error', "content" => "An error occured: Cause Unknown");
        }
    }
}
