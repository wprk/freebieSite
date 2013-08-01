<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('site_model');
    }

    public function index($category_slug = 'latest', $sub_category_slug = '')
	{
        if($category_slug != 'latest') {
            $this->category($category_slug, $sub_category_slug);
        }
        $category_id = 0;
        $page['category'] = array('category_id' => 0, 'category_name' => 'Latest Freebies', 'category_slug' => 'latest', 'category_desc' => 'Latest Freebies');
        $page['sub_category'] = array();
        $page['header'] = $this->load->view('sub_views/header', $page, true);

        $page['categories'] = $this->site_model->get_categories();
        $page['sub_categories'] = array();
        $page['sub_categories_html'] = $this->load->view('sub_views/sub_categories', $page, true);
        $page['listings'] = $this->site_model->get_listings();
        $page['listings_html'] = $this->load->view('sub_views/listings', $page, true);
        $page['footer'] = $this->load->view('sub_views/footer', array(), true);
        echo $this->load->view('home', $page, true);
	}

    public function category($category_slug = 'latest', $sub_category_slug = '')
    {
            $category = $this->site_model->get_category_from_slug($category_slug);
            $sub_category =  $this->site_model->get_sub_category_from_slug($sub_category_slug);
            $category_id = $category['category_id'];
            $sub_category_id = $sub_category['sub_category_id'];

            $page['category'] =  $category;
            $page['sub_category'] =  $sub_category;
            $page['header'] = $this->load->view('sub_views/header', $page, true);

            $page['categories'] = $this->site_model->get_categories();
            $page['sub_categories'] = $this->site_model->get_sub_categories($category_id);
            $page['sub_categories_html'] = $this->load->view('sub_views/sub_categories', $page, true);
            if($sub_category_id) {
                $page['listings'] = $this->site_model->get_sub_category_listings($sub_category_id);
            } else {
                $page['listings'] = $this->site_model->get_category_listings($category_id);
            }
            $page['listings_html'] = $this->load->view('sub_views/listings', $page, true);
            $page['footer'] = $this->load->view('sub_views/footer', array(), true);
            echo $this->load->view('category', $page, true);
    }

    public function tag($tag_slug)
    {
        $tag = $this->site_model->get_tag_from_slug($tag_slug);
        $tag_id = $tag['tag_id'];

        $page['tag'] =  $tag;
        $page['header'] = $this->load->view('sub_views/header', $page, true);

        $page['categories'] = $this->site_model->get_categories();
        $page['sub_categories_html'] = $this->load->view('sub_views/sub_categories', $page, true);
        $page['listings'] = $this->site_model->get_tag_listings($tag_id);
        $page['listings_html'] = $this->load->view('sub_views/listings', $page, true);
        $page['footer'] = $this->load->view('sub_views/footer', array(), true);
        echo $this->load->view('tag', $page, true);
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */