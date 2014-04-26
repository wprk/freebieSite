<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    protected $site;

    function __construct() {
        parent::__construct();
        $this->load->model('site_model');
        $this->site = $this->site_model->get_site();
    }

    public function index($category_slug = 'latest', $sub_category_slug = '')
	{
        $page['site'] = $this->site_model->get_site();
        if($category_slug != 'latest') {
            $this->category($category_slug, $sub_category_slug);
        }
        $category_id = 0;
        $page['category'] = array('category_id' => 0, 'category_name' => 'Latest Freebies', 'category_slug' => 'latest', 'category_desc' => 'Latest Freebies');
        $page['sub_category'] = array();
        $page['header'] = $this->load->view('sub_views/header', $page, true);

        $page['categories'] = $this->site_model->get_categories();
        $page['sub_categories'] = array();
        $page['landing_pages'] = $this->site_model->get_landing_pages();
        $page['sub_categories_html'] = $this->load->view('sub_views/sub_categories', $page, true);
        $page['listings'] = $this->site_model->get_listings();
        $page['listings_html'] = $this->load->view('sub_views/listings', $page, true);
        $page['footer'] = $this->load->view('sub_views/footer', array(), true);
        echo $this->load->view('home', $page, true);
	}

    public function category($category_slug = 'latest', $sub_category_slug = '')
    {
        $page['site'] = $this->site;

        $category = $this->site_model->get_category_from_slug($category_slug);
        $sub_category =  $this->site_model->get_sub_category_from_slug($sub_category_slug);
        $page['category_id'] = $category['category_id'];
        $page['sub_category_id'] = $sub_category['sub_category_id'];

        $page['category'] =  $category;
        $page['sub_category'] =  $sub_category;
        $page['header'] = $this->load->view('sub_views/header', $page, true);

        $page['categories'] = $this->site_model->get_categories();
        $page['sub_categories'] = $this->site_model->get_sub_categories($page['category_id']);
        $page['sub_categories_html'] = $this->load->view('sub_views/sub_categories', $page, true);
        if($page['sub_category_id']) {
            $page['listings'] = $this->site_model->get_sub_category_listings($page['sub_category_id']);
        } else {
            $page['listings'] = $this->site_model->get_category_listings($page['category_id']);
        }
        $page['listings_html'] = $this->load->view('sub_views/listings', $page, true);
        $page['footer'] = $this->load->view('sub_views/footer', array(), true);
        echo $this->load->view('category', $page, true);
    }

    public function tag($tag_slug)
    {
        $page['site'] = $this->site;

        $tag = $this->site_model->get_tag_from_slug($tag_slug);
        $tag_id = $tag['tag_id'];

        $page['tag'] =  $tag;
        $page['header'] = $this->load->view('sub_views/header', $page, true);

        $page['categories'] = $this->site_model->get_categories();
        $page['more_tags'] = $this->site_model->get_more_tags($tag_id);
        $page['sub_categories_html'] = $this->load->view('sub_views/sub_categories', $page, true);
        $page['listings'] = $this->site_model->get_tag_listings($tag_id);
        $page['listings_html'] = $this->load->view('sub_views/listings', $page, true);
        $page['footer'] = $this->load->view('sub_views/footer', array(), true);
        echo $this->load->view('tag', $page, true);
    }

    public function page($page_slug)
    {
        $pageData['site'] = $this->site;

        $page = $this->site_model->get_page_from_slug($page_slug);
        $pageData['page_id'] = $page['page_id'];

        $pageData['page'] = $page;
        $pageData['header'] = $this->load->view('sub_views/header', $pageData, true);

        $pageData['categories'] = $this->site_model->get_categories();
        $pageData['more_pages'] = $this->site_model->get_landing_pages();
        $pageData['sub_categories_html'] = $this->load->view('sub_views/sub_categories', $pageData, true);
        $pageData['listings'] = $this->site_model->get_page_listings($pageData['page_id']);
        $pageData['listings_html'] = $this->load->view('sub_views/listings', $pageData, true);
        $pageData['footer'] = $this->load->view('sub_views/footer', array(), true);
        echo $this->load->view('page', $pageData, true);
    }
    public function share($page_slug)
    {
        $pageData['site'] = $this->site;

        $listing = $this->site_model->get_listing_from_slug($page_slug);
        $pageData['listing_id'] = $listing['listing_id'];

        $pageData['listing'] = $this->site_model->get_listing($listing['listing_id']);
        $pageData['header'] = $this->load->view('sub_views/header', $pageData, true);

        $pageData['category'] = $this->site_model->get_category($pageData['listing']['category_id']);
        $pageData['categories'] = $this->site_model->get_categories();
        $pageData['sub_categories'] = $this->site_model->get_sub_categories($pageData['listing']['category_id']);
        $pageData['sub_category_id'] = 0;
        $pageData['sub_categories_html'] = $this->load->view('sub_views/sub_categories', $pageData, true);
        $pageData['listings'] = $this->site_model->get_related_listings($pageData['listing_id']);
        $pageData['related_listings_html'] = $this->load->view('sub_views/related_listings', $pageData, true);
        $pageData['footer'] = $this->load->view('sub_views/footer', array(), true);
        echo $this->load->view('share', $pageData, true);
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */