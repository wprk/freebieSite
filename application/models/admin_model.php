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

    public function create_listing_alt_desc($listing_alt_descs_data)
    {
        if($this->db->insert("listing_descs", $listing_alt_descs_data)) {
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

    public function get_listing($id) {
        $listings = $this->db->query("SELECT * FROM listings, listing_categories, categories WHERE listing_categories.listing_id = listings.listing_id AND listing_categories.category_id = categories.category_id AND listings.listing_id = ".$id." ORDER BY listings.listing_created DESC");
        if($listings->num_rows() == 1) {
            return $listings->row();
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

    public function get_sub_categories($category_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->order_by('sub_category_name ASC');
        $results = $this->db->get('sub_categories');
        if($results->num_rows() > 0) {
            return $results->result_array();
        } else {
            return array();
        }
    }

    public function get_tag($id) {
        $tag = $this->db->query("SELECT * FROM tags WHERE tags.tag_id = ".$id." ORDER BY tags.tag_name ASC");
        if($tag->num_rows() == 1) {
            return $tag->row();
        } else {
            return array();
        }
    }

    public function get_tags()
    {
        $this->db->order_by('tag_name ASC');
        $tags = $this->db->get('tags');
        if($tags->num_rows() > 0) {
            return $tags->result_array();
        } else {
            return array();
        }
    }

    public function get_tags_by_listing($id) {
        $tag_list = array();
        $tags = $this->db->query("SELECT listing_tags.listing_id, tags.tag_id FROM listing_tags, tags WHERE listing_tags.tag_id = tags.tag_id AND listing_tags.listing_id = ".$id." ORDER BY tags.tag_name ASC");
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

    public function delete($type, $id) {
        switch($type) {
            case "listing":
                if( ($this->db->delete('listing_categories', array('listing_id' => $id))) && ($this->db->delete('listings', array('listing_id' => $id))) ) {
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
        }
        return false;
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

    public function create_tag($tag_data)
    {
        $this->db->where('tags.tag_slug', $tag_data['tag_slug']);
        $results = $this->db->get('tags');
        if($results->num_rows() == 1) {
            $row = $results->row();
            return $row->tag_id;
        } else {
            if($this->db->insert("tags", $tag_data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
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

    function slugify($str, $find_and_replace = array('&' => 'and', 'amp;' => 'and'), $delimiter = '-') {
        if( !empty($find_and_replace) ) {
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
}
