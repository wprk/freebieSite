<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library(array('session', 'Erkana_auth'));
        $this->load->model('admin_model');
        $this->load->model('account');
    }

    public function index()
    {
        redirect('/s5k9d7f6jdn0/listings/');
    }

    public function fix_category_slug_names()
    {
        $this->erkana_auth->required();

        $categories = $this->admin_model->get_categories();
        foreach ($categories as $item) {
        $newSlug = $this->admin_model->slugify($item['category_name']);
//        print('<br />' . 'name: ' . $item['category_name']);
//        print('<br />' . $newSlug);
        $this->admin_model->edit_category($item['category_id'], array('category_slug' => $newSlug));
        }
        $this->admin_model->save_routes();
    }

    public function fix_subcategory_slug_names()
    {
        $this->erkana_auth->required();

        $subcats = $this->admin_model->get_sub_categories();
        foreach ($subcats as $item) {
            $newSlug = $this->admin_model->slugify($item['sub_category_name']);
//        print('<br />' . 'name: ' . $item['sub_category_name']);
//        print('<br />' . $newSlug);
        $this->admin_model->edit_sub_category($item['sub_category_id'], array('sub_category_slug' => $newSlug));
        }
        $this->admin_model->save_routes();
    }

    public function fix_tag_slug_names()
    {
        $this->erkana_auth->required();

        $tags = $this->admin_model->get_tags();
        foreach ($tags as $item) {
            $newSlug = $this->admin_model->slugify($item['tag_name']);
//        print('<br />' . 'name: ' . $item['tag_name']);
//        print('<br />' . $newSlug);
            $this->admin_model->edit_tag($item['tag_id'], array('tag_slug' => $newSlug));
        }
        $this->admin_model->save_routes();
    }

    public function fix_page_slug_names()
    {
        $this->erkana_auth->required();

        $pages = $this->admin_model->get_pages();
        foreach ($pages as $item) {
            $newSlug = $this->admin_model->slugify($item['page_name']);
//        print('<br />' . 'name: ' . $item['page_name']);
//        print('<br />' . $newSlug);
            $this->admin_model->edit_page($item['page_id'], array('page_slug' => $newSlug));
        }
        $this->admin_model->save_routes();
    }

    public function get_listings()
    {
        $this->erkana_auth->required();

        $pages = $this->admin_model->get_listings();
        die(print_r($pages));
    }
}