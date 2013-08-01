<?php

class Site_model extends CI_Model
{
    private $site_id;

    function __construct()
    {
        parent::__construct();
        $this->site_id = 1;
    }

    public function get_category_from_slug($category_slug)
    {
        $this->db->where('category_slug', $category_slug);
        $results = $this->db->get('categories');
        if($results->num_rows() == 1) {
            foreach($results->result_array() as $row) {
                return $row;
            }
        } else {
            return false;
        }
    }

    public function get_sub_category_from_slug($sub_category_slug)
    {
        $this->db->where('sub_category_slug', $sub_category_slug);
        $results = $this->db->get('sub_categories');
        if($results->num_rows() == 1) {
            foreach($results->result_array() as $row) {
                return $row;
            }
        } else {
            return false;
        }
    }

    public function get_tag_from_slug($tag_slug)
    {
        $this->db->where('tag_slug', $tag_slug);
        $results = $this->db->get('tags');
        if($results->num_rows() == 1) {
            foreach($results->result_array() as $row) {
                return $row;
            }
        } else {
            return false;
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

    public function get_tags()
    {
        $this->db->order_by('tag_name ASC');
        $results = $this->db->get('tags');
        if($results->num_rows() > 0) {
            return $results->result_array();
        } else {
            return array();
        }
    }

    public function get_listings()
    {
        $this->db->_protect_identifiers=false;
        $this->db->select('listings.*');
        $this->db->where('listing_affiliate', 1);
        $this->db->where('listing_status', 1);
        $this->db->join('listing_descs', "site_id = $this->site_id AND listing_descs.listing_id = listings.listing_id", "left");
        $this->db->order_by('listing_created', 'DESC');
        $alistings = $this->db->get('listings');
        $alistings_count = $alistings->num_rows();

        $this->db->_protect_identifiers=false;
        $this->db->select('listings.*');
        $this->db->where('listing_affiliate', 0);
        $this->db->where('listing_status', 1);
        $this->db->join('listing_descs', "site_id = $this->site_id AND listing_descs.listing_id = listings.listing_id", "left");
        $this->db->order_by('listing_created', 'DESC');
        $blistings = $this->db->get('listings');
        $blistings_count = $blistings->num_rows();

        if(($alistings_count == 0) && ($blistings_count == 0)) {
            return array();
        } else {
            if($alistings_count > 0) {
                $listing_types[] = 'alistings';
            }
            if($blistings_count > 0) {
                $listing_types[] = 'blistings';
            }
            for($i = 0; $i < 15; $i++) {
                foreach($listing_types as $type) {
                    $listing_row = $$type->row_array($i);
                        $listings[] = array(
                            'listing_id' => $listing_row['listing_id'],
                            'listing_title' => $listing_row['listing_title'],
                            'listing_url' => $listing_row['listing_url'],
                            'listing_tracking_img' => $listing_row['listing_tracking_img'],
                            'listing_desc' => $this->get_listing_description($listing_row),
                            'listing_tags' => $this->get_listing_tags($listing_row),
                            'listing_expires' => $listing_row['listing_expires'],
                            'listing_created' => $listing_row['listing_created']
                        );
                }
            }
            return $listings;
        }
    }

    public function get_category_listings($category_id)
    {
        $results = $this->db->query("SELECT * FROM listings, listing_categories WHERE listing_categories.listing_id = listings.listing_id AND category_id = ".$category_id." AND listing_status = 1 ORDER BY listings.listing_featured DESC, listings.listing_affiliate DESC, listings.listing_created ASC");
        if($results->num_rows() > 0) {
            foreach($results->result_array() as $listing_row) {
                $listings[] = array(
                    'listing_id' => $listing_row['listing_id'],
                    'listing_title' => $listing_row['listing_title'],
                    'listing_url' => $listing_row['listing_url'],
                    'listing_tracking_img' => $listing_row['listing_tracking_img'],
                    'listing_desc' => $this->get_listing_description($listing_row),
                    'listing_tags' => $this->get_listing_tags($listing_row),
                    'listing_expires' => $listing_row['listing_expires'],
                    'listing_created' => $listing_row['listing_created']
                );
            }
            return $listings;
        } else {
            return array();
        }
    }

    public function get_sub_category_listings($sub_category_id)
    {
        $results = $this->db->query("SELECT * FROM listings, listing_categories WHERE listing_categories.listing_id = listings.listing_id AND sub_category_id = ".$sub_category_id." AND listing_status = 1 ORDER BY listings.listing_featured DESC, listings.listing_affiliate DESC, listings.listing_created ASC");
        if($results->num_rows() > 0) {
            foreach($results->result_array() as $listing_row) {
                $listings[] = array(
                    'listing_id' => $listing_row['listing_id'],
                    'listing_title' => $listing_row['listing_title'],
                    'listing_url' => $listing_row['listing_url'],
                    'listing_tracking_img' => $listing_row['listing_tracking_img'],
                    'listing_desc' => $this->get_listing_description($listing_row),
                    'listing_tags' => $this->get_listing_tags($listing_row),
                    'listing_expires' => $listing_row['listing_expires'],
                    'listing_created' => $listing_row['listing_created']
                );
            }
            return $listings;
        } else {
            return array();
        }
    }

    public function get_tag_listings($tag_id)
    {
        $results = $this->db->query("SELECT * FROM listings, listing_tags WHERE listing_tags.listing_id = listings.listing_id AND tag_id = ".$tag_id." AND listing_status = 1 ORDER BY listings.listing_featured DESC, listings.listing_affiliate DESC, listings.listing_created ASC");
        if($results->num_rows() > 0) {
            foreach($results->result_array() as $listing_row) {
                $listings[] = array(
                    'listing_id' => $listing_row['listing_id'],
                    'listing_title' => $listing_row['listing_title'],
                    'listing_url' => $listing_row['listing_url'],
                    'listing_tracking_img' => $listing_row['listing_tracking_img'],
                    'listing_desc' => $this->get_listing_description($listing_row),
                    'listing_tags' => $this->get_listing_tags($listing_row),
                    'listing_expires' => $listing_row['listing_expires'],
                    'listing_created' => $listing_row['listing_created']
                );
            }
            return $listings;
        } else {
            return array();
        }
    }

    private function get_listing_description($listing) {
        $this->db->select('listing_descs.listing_desc_value');
        $this->db->where('listing_id', $listing['listing_id']);
        $this->db->where('site_id', $this->site_id);
        $result = $this->db->get('listing_descs');
        if ($result->num_rows() > 0) {
            $row = $result->row();
            $desc_value = $row->listing_desc_value;
        } else {
            return NULL;
        }
        return ($desc_value == 2 ? $listing['listing_alt_desc'] : $listing['listing_desc']);
    }

    private function get_listing_tags($listing) {
        $result = $this->db->query("SELECT tags.* FROM tags, listing_tags WHERE listing_tags.listing_id = ".$listing['listing_id']." AND listing_tags.tag_id = tags.tag_id");
        if($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return array();
        }
    }
}