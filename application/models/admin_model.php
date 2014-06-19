<?php

class Admin_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        setlocale(LC_ALL, 'en_US.UTF8');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function get_sites() {
        $sites = $this->db->query("SELECT * FROM sites ORDER BY site_name ASC");
        if($sites->num_rows() > 0) {
            return $sites->result_array();
        } else {
            return array();
        }
    }

    public function get_site_alt_desc($listing_id, $site_id) {
        $result = $this->db->query("SELECT listing_descs.listing_desc_value FROM listing_descs WHERE listing_id = $listing_id AND site_id = $site_id;");
        if($result->num_rows() == 1) {
            $row = $result->row_array();
            return $row['listing_desc_value'];
        } else {
            return false;
        }
    }

    public function get_site_alt_title($listing_id, $site_id) {
        $result = $this->db->query("SELECT listing_titles.listing_title_value FROM listing_titles WHERE listing_id = $listing_id AND site_id = $site_id;");
        if($result->num_rows() == 1) {
            $row = $result->row_array();
            return $row['listing_title_value'];
        } else {
            return false;
        }
    }

    public function create_listing_alt_desc($listing_alt_descs_data)
    {
        if($this->db->insert("listing_descs", $listing_alt_descs_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function create_listing_alt_title($listing_alt_titles_data)
    {
        if($this->db->insert("listing_titles", $listing_alt_titles_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update_listing_alt_desc($listing_id, $site_id, $listing_alt_descs_data)
    {
        $this->db->where('listing_id', $listing_id);
        $this->db->where('site_id', $site_id);
        if($this->db->update("listing_descs", $listing_alt_descs_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update_listing_alt_title($listing_id, $site_id, $listing_alt_titles_data)
    {
        $this->db->where('listing_id', $listing_id);
        $this->db->where('site_id', $site_id);
        if($this->db->update("listing_titles", $listing_alt_titles_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update_listing_tags($listing_id, $listing_tag_data)
    {
        $this->db->delete('listing_tags', array('listing_id' => $listing_id));
        if($this->db->insert_batch("listing_tags", $listing_tag_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update_page_tags($page_id, $page_tag_data)
    {
        $this->db->delete('landing_pages_tags', array('page_id' => $page_id));
        if($this->db->insert_batch("landing_pages_tags", $page_tag_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function create_listing_tag($listing_tag_data)
    {
        if(is_array($listing_tag_data)) {
            if($this->db->insert("listing_tags", $listing_tag_data)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function create_page_tag($page_tag_data)
    {
        if($this->db->insert("landing_pages_tags", $page_tag_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_sub_categories($category_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->order_by('sub_category_name DESC');
        $results = $this->db->get('sub_categories');
        if($results->num_rows() > 0) {
            return $results->result_array();
        } else {
            return array();
        }
    }

    public function get_sub_category($id) {
        $sub_categories = $this->db->query("SELECT * FROM sub_categories WHERE sub_categories.sub_category_id = ".$id." ORDER BY sub_categories.sub_category_name ASC");
        if($sub_categories->num_rows() == 1) {
            return $sub_categories->row();
        } else {
            return array();
        }
    }

    public function get_tags_by_listing($id) {
        $tag_list = array();
        $tags = $this->db->query("SELECT listing_tags.listing_id, tags.tag_id FROM listing_tags, tags WHERE listing_tags.tag_id = tags.tag_id AND listing_tags.listing_id = ".$id." AND tags.tag_status = 1 ORDER BY tags.tag_name ASC");
        if ($tags->num_rows() > 0) {
            $tag_records = $tags->result_array();
            foreach ($tag_records as $tag) {
                $tag_list[] = $tag['tag_id'];
            }
            return $tag_list;
        } else {
            return $tag_list;
        }
    }

    public function get_imgs_by_listing($id) {
        $img_list = array();
        $imgs = $this->db->query("SELECT listing_imgs.* FROM listing_imgs WHERE listing_imgs.listing_id = ".$id." ORDER BY listing_imgs.img_size ASC");
        if ($imgs->num_rows() > 0) {
            $img_records = $imgs->result_array();
            foreach ($img_records as $img) {
                $img_list[] = $img;
            }
            return $img_list;
        } else {
            return $img_list;
        }
    }

    public function get_categories_by_listing($field, $id) {
        $cat_id = 0;
        $cats = $this->db->query("SELECT listing_categories.* FROM listing_categories WHERE listing_id = ".$id);
        if ($cats->num_rows() > 0) {
            $cat_records = $cats->result_array();
            foreach ($cat_records as $cat) {
                $cat_id = $cat[$field];
            }
            return $cat_id;
        } else {
            return $cat_id;
        }
    }

    public function get_tags_by_page($id) {
        $tag_list = array();
        $tags = $this->db->query("SELECT landing_pages_tags.page_id, tags.tag_id FROM landing_pages_tags, tags WHERE landing_pages_tags.tag_id = tags.tag_id AND landing_pages_tags.page_id = ".$id." AND tags.tag_status = 1 ORDER BY tags.tag_name ASC");
        if ($tags->num_rows() > 0) {
            $tag_records = $tags->result_array();
            foreach ($tag_records as $tag) {
                $tag_list[] = $tag['tag_id'];
            }
            return $tag_list;
        } else {
            return $tag_list;
        }
    }

    public function get_listing($id) {
        $this->db->_protect_identifiers=false;
        $this->db->select('listings.*');
        $this->db->from('listings');
        $this->db->where('listings.listing_id', $id);
        $listings = $this->db->get();
        if($listings->num_rows() == 1) {
            $row = $listings->row();
            $row->tag_ids = $this->get_tags_by_listing($id);
            $row->imgs = $this->get_imgs_by_listing($id);
            $row->category_id = $this->get_categories_by_listing('category_id', $id);
            $row->sub_category_id = $this->get_categories_by_listing('sub_category_id', $id);
            return $row;
        } else {
            return array();
        }
    }

    public function get_listings() {
        $listings = $this->db->query("SELECT * FROM listings, listing_categories, categories WHERE listing_categories.listing_id = listings.listing_id AND listing_categories.category_id = categories.category_id ORDER BY listings.listing_featured DESC, listings.listing_affiliate DESC, listings.listing_created DESC");
        if($listings->num_rows() > 0) {
            return $listings->result_array();
        } else {
            return array();
        }
    }

    public function get_affiliate_listings() {
        $listings = $this->db->query("SELECT * FROM listings, listing_categories, categories WHERE listing_categories.listing_id = listings.listing_id AND listing_categories.category_id = categories.category_id AND listing_affiliate = 1 ORDER BY listings.listing_title ASC");
        if($listings->num_rows() > 0) {
            return $listings->result_array();
        } else {
            return array();
        }
    }

    public function get_chosen_listings() {
        $listings = $this->db->query("SELECT * FROM listings, listing_categories, categories WHERE listing_categories.listing_id = listings.listing_id AND listing_categories.category_id = categories.category_id AND listing_home_featured > 0 ORDER BY listings.listing_home_featured ASC");
        if($listings->num_rows() > 0) {
            return $listings->result_array();
        } else {
            return array();
        }
    }

    public function get_old_listing($older_than = '') {
        if($older_than) {
            $listings = $this->db->query("SELECT * FROM listings, listing_categories, categories WHERE listing_categories.listing_id = listings.listing_id AND listing_categories.category_id = categories.category_id AND listings.listing_status = 1 AND listings.listing_created < '$older_than' ORDER BY listing_created ASC LIMIT 0, 1;");
        } else {
            $listings = $this->db->query("SELECT * FROM listings, listing_categories, categories WHERE listing_categories.listing_id = listings.listing_id AND listing_categories.category_id = categories.category_id AND listings.listing_status = 1 ORDER BY listing_created ASC LIMIT 0, 1;");
        }
        if($listings->num_rows() == 1) {
            return $listings->row_array();
        } else {
            return array();
        }
    }

    public function get_expired_listing() {
        $listings = $this->db->query("SELECT * FROM listings, listing_categories, categories WHERE listing_categories.listing_id = listings.listing_id AND listing_categories.category_id = categories.category_id AND listing_expires < NOW() AND listings.listing_status = 1 ORDER BY listing_created ASC LIMIT 0, 1;");
        if($listings->num_rows() == 1) {
            return $listings->row_array();
        } else {
            return array();
        }
    }

    public function create_listing($listing_data)
    {
        if($this->db->insert("listings", $listing_data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function edit_listing($id, $listing_data)
    {
        $this->db->where('listing_id', $id);
        if($this->db->update("listings", $listing_data)) {
            return $id;
        } else {
            return false;
        }
    }

    public function get_category($id) {
        $categories = $this->db->query("SELECT * FROM categories WHERE categories.category_id = ".$id." ORDER BY categories.category_name ASC");
        if($categories->num_rows() == 1) {
            return $categories->row();
        } else {
            return array();
        }
    }

    public function get_categories()
    {
        $this->db->order_by('category_name ASC');
        $results = $this->db->get('categories');
        if($results->num_rows() > 0) {
            return $results->result_array();
        } else {
            return array();
        }
    }

    public function create_category($category_data)
    {
        if($this->db->insert("categories", $category_data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function edit_category($id, $category_data)
    {
        $this->db->where('category_id', $id);
        if($this->db->update("categories", $category_data)) {
            return $id;
        } else {
            return false;
        }
    }

    public function create_sub_category($sub_category_data)
    {
        if($this->db->insert("sub_categories", $sub_category_data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function edit_sub_category($id, $subcategory_data)
    {
        $this->db->where('sub_category_id', $id);
        if($this->db->update("sub_categories", $subcategory_data)) {
            return $id;
        } else {
            return false;
        }
    }

    public function create_listing_category($category_data)
    {
        if($this->db->insert("listing_categories", $category_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_listing_category($id, $category_data)
    {
        $this->db->where('listing_id', $id);
        if($this->db->update("listing_categories", $category_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_tag($id) {
        $tag = $this->db->query("SELECT * FROM tags WHERE tags.tag_id = ".$id." AND tag_status = 1 ORDER BY tags.tag_name ASC");
        if($tag->num_rows() == 1) {
            return $tag->row();
        } else {
            return array();
        }
    }

    public function get_tags()
    {
        $this->db->where('tag_status', 1);
        $this->db->order_by('tag_name ASC');
        $tags = $this->db->get('tags');
        if($tags->num_rows() > 0) {
            return $tags->result_array();
        } else {
            return array();
        }
    }

    public function create_tag($tag_data)
    {
        $this->db->where('tag_status', 1);
        $this->db->where('tags.tag_name', $tag_data['tag_name']);
        $undeleted = $this->db->get('tags');
        $this->db->where('tag_status', 0);
        $this->db->where('tags.tag_name', $tag_data['tag_name']);
        $deleted = $this->db->get('tags');
        if($undeleted->num_rows() == 1) {
            $row = $undeleted->row();
            return $row->tag_id;
        } else if($deleted->num_rows() == 1) {
            $row = $deleted->row();
            $this->edit_tag($row->tag_id, array('tag_status' => 1));
            return $row->tag_id;
        } else {
            $tag_data['tag_created'] = date('Y-m-d h:i:s');
            if($this->db->insert("tags", $tag_data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        }
    }

    public function edit_tag($id, $tag_data)
    {
        $this->db->where('tag_id', $id);
        if($this->db->update("tags", $tag_data)) {
            return $id;
        } else {
            return false;
        }
    }

    public function add_tag_to_listing($listing_id, $tag_id)
    {
        $tag_data = array(
            'listing_id' => $listing_id,
            'tag_id' => $tag_id
        );
        if($this->db->insert("listing_tags", $tag_data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function get_page($id) {
        $result = $this->db->query("SELECT * FROM landing_pages WHERE landing_pages.page_id = ".$id." AND page_status = 1 ORDER BY landing_pages.page_name ASC");
        if($result->num_rows() == 1) {
            $page = $result->row();
            $page->tag_ids = $this->get_tags_by_page($id);
            return $page;
        } else {
            return array();
        }
    }

    public function get_site($id) {
        $result = $this->db->query("SELECT * FROM sites WHERE sites.site_id = ".$id." AND site_status = 1 ORDER BY sites.site_name ASC");
        if($result->num_rows() == 1) {
            $site = $result->row();
            return $site;
        } else {
            return array();
        }
    }

    public function get_pages()
    {
        $this->db->where('page_status', 1);
        $this->db->order_by('last_updated DESC');
        $results = $this->db->get('landing_pages');
        if($results->num_rows() > 0) {
            return $results->result_array();
        } else {
            return array();
        }
    }

    public function create_page($page_data)
    {
        $this->db->where('page_status', 1);
        $this->db->where('landing_pages.page_name', $page_data['page_name']);
        $undeleted = $this->db->get('landing_pages');
        $this->db->where('page_status', 0);
        $this->db->where('landing_pages.page_name', $page_data['page_name']);
        $deleted = $this->db->get('landing_pages');
        if($undeleted->num_rows() == 1) {
            $row = $undeleted->row();
            return $row->page_id;
        } else if($deleted->num_rows() == 1) {
            $row = $deleted->row();
            $this->edit_page($row->page_id, array('page_status' => 1));
            return $row->page_id;
        } else {
            if($this->db->insert("landing_pages", $page_data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        }
    }

    public function create_site($site_data)
    {
        $this->db->where('site_status', 1);
        $this->db->where('sites.site_name', $site_data['site_name']);
        $undeleted = $this->db->get('sites');
        $this->db->where('site_status', 0);
        $this->db->where('sites.site_name', $site_data['site_name']);
        $deleted = $this->db->get('sites');
        if($undeleted->num_rows() == 1) {
            $row = $undeleted->row();
            return $row->site_id;
        } else if($deleted->num_rows() == 1) {
            $row = $deleted->row();
            $this->edit_page($row->site_id, array('site_status' => 1));
            return $row->site_id;
        } else {
            if($this->db->insert("sites", $site_data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        }
    }

    public function edit_page($id, $page_data)
    {
        $this->db->where('page_id', $id);
        if($this->db->update("landing_pages", $page_data)) {
            return $id;
        } else {
            return false;
        }
    }

    public function edit_site($id, $site_data)
    {
        $this->db->where('site_id', $id);
        if($this->db->update("sites", $site_data)) {
            return $id;
        } else {
            return false;
        }
    }

    public function add_tag_to_page($page_id, $tag_id)
    {
        $tag_data = array(
            'page_id' => $page_id,
            'tag_id' => $tag_id
        );
        if($this->db->insert("landing_page_tags", $tag_data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function get_user($id) {
        $users = $this->db->where("id", $id);
        $users = $this->db->get("accounts");

        if($users->num_rows() > 0) {
            return $users->row();
        } else {
            return array();
        }
    }

    public function get_users() {
        $users = $this->db->order_by("created_on", "DESC");
        $users = $this->db->get("accounts");

        if($users->num_rows() > 0) {
            return $users->result_array();
        } else {
            return array();
        }
    }

    public function delete($type, $id) {
        switch($type) {
            case "listing":
                if( ($this->db->delete('listings', array('listing_id' => $id))) &&
                    ($this->db->delete('listing_categories', array('listing_id' => $id))) &&
                    ($this->db->delete('listing_descs', array('listing_id' => $id))) &&
                    ($this->db->delete('listing_imgs', array('listing_id' => $id))) &&
                    ($this->db->delete('listing_tags', array('listing_id' => $id))) &&
                    ($this->db->delete('listing_titles', array('listing_id' => $id)))
                ) {
                    return true;
                }
                break;
            case "user":
                if($this->db->delete('accounts', array('id' => $id))) {
                    return true;
                }
                break;
            case "category":
                if($this->db->delete('categories', array('category_id' => $id))) {
                    return true;
                }
                break;
            case "sub_category":
                if($this->db->delete('sub_categories', array('sub_category_id' => $id))) {
                    return true;
                }
                break;
            case "tag":
                $this->db->where('tag_id', $id);
                if($this->db->update('tags', array('tag_status' => 0))) {
                    return true;
                }
                break;
            case "page":
                $this->db->where('page_id', $id);
                if($this->db->update('landing_pages', array('page_status' => 0))) {
                    return true;
                }
                break;
            case "site":
                $this->db->where('site_id', $id);
                if($this->db->update('sites', array('site_status' => 0))) {
                    return true;
                }
                break;
        }
        return false;
    }

    function slugify($str, $find_and_replace = array('&' => 'and', 'amp;' => 'and'), $delimiter = '-') {
        if( is_array($find_and_replace) ) {
            $find = array_keys($find_and_replace);
            $replace = array_values($find_and_replace);
            $str = str_replace($find, $replace, $str);
            $str = str_replace('andand', 'and', $str);
        }
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    public function create_img($field, $imgData)
    {
        $images = $this->get_imgs_by_listing($imgData['listing_id']);

        $config['upload_path'] = realpath(FCPATG . '/includes/images/listings/');
        $config['allowed_types'] = '*';
        $config['overwrite'] = true;
        $config['max_width']  = '520';
        $config['max_height']  = '520';
        $config['file_name'] = $imgData['img_uri'].'.'.$imgData['img_ext'];

        $this->load->library('upload', $config);
        print_r($imgData);

        if ($this->upload->do_upload($field)) {
            die(print_r($imgData));
            if($this->check_for_image($images, $imgData['img_size'])) {
                if($this->db->insert("listing_imgs", $imgData)) {
                    return true;
                }
            } else {
               return $this->update_img($imgData['listing_id'], $field, $imgData);
            }
        } else {
            return false;
        }
    }

    protected function check_for_image($images, $size)
    {
        foreach($images as $image) {
            if($image['img_size'] == $size) {
                return false;
            }
        }
        return true;
    }

    public function update_img($id, $field, $imgData)
    {
        $this->load->library('upload');

        $config['upload_path'] = realpath(BASEPATH . '/../includes/images/listings/');
        $config['allowed_types'] = '*';
        $config['overwrite'] = true;
        $config['max_width']  = '520';
        $config['max_height']  = '520';
        $config['file_name'] = $imgData['img_uri'].'.'.$imgData['img_ext'];

        $this->upload->initialize($config);
        if ($this->upload->do_upload($field)) {
            switch($field) {
                case "listing_sml_img":
                    $size = "115x115";
                    break;
                default:
                    $size = "520x520";
            }
            $this->db->where('img_size', $size);
            $this->db->where('listing_id', $id);
            if($this->db->update("listing_imgs", $imgData)) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function save_routes()
    {
        // this simply returns all the categories from my database
        $listings = $this->admin_model->get_listings();
        $categories = $this->admin_model->get_categories();
        $tags = $this->admin_model->get_tags();
        $pages = $this->admin_model->get_pages();

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
            foreach ($pages as $route) {
                $data[] = '$route["' . $route['page_slug'] . '"] = "home/page/' . $route['page_slug'] .'";';
                $data[] = '$route["' . $route['page_slug'] . '/(:any)"] = "home/page/' . $route['page_slug'] .'/$1";';
            }
            foreach ($listings as $route) {
                $data[] = '$route["'. $route['category_slug']. '/' . $route['listing_uri'] . '"] = "home/share/' . $route['listing_uri'] .'";';
                $data[] = '$route["'. $route['category_slug']. '/' . $route['listing_uri'] . '/(:any)"] = "home/share/' . $route['listing_uri'] .'/$1";';
            }

            $output = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
            $output .= '$route["default_controller"] = "home"; $route["404_override"] = ""; $route["s5k9d7f6jdn0"] = "s5k9d7f6jdn0"; $route["s5k9d7f6jdn0/(:any)"] = "s5k9d7f6jdn0/$1";';

            $output .= implode("\n", $data);

            $this->load->helper('file');
            write_file(APPPATH . "config/routes.php", $output);
        }
    }

    public function alter_homepage_listing($listings)
    {
        $this->db->where('listing_id', $listings[0]['listing_id']);
        unset($listings[0]['listing_id']);
        if($this->db->update("listings", $listings[0])) {
            return true;
        } else {
            return false;
        }
    }

    public function update_hompage($listings)
    {
        $error = 0;
        foreach($listings as $listing) {
            $this->db->where('listing_id', $listing['listing_id']);
            unset($listing['listing_id']);
            if(!$this->db->update("listings", $listing)) {
                $error = 1;
            }
        }
        if($error) {
            return false;
        } else {
            return true;
        }
    }
}
