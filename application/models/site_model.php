<?php

class Site_model extends CI_Model
{
    private $site_id;

    function __construct()
    {
        parent::__construct();
        $this->site_id = 1;
    }

    public function get_site()
    {
        $site_id = $this->site_id;
        $this->db->where('site_id', $site_id);
        $results = $this->db->get('sites');
        if($results->num_rows() == 1) {
            return $results->row_array();
        } else {
            return array();
        }
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

    public function get_category($id) {
        $categories = $this->db->query("SELECT * FROM categories WHERE categories.category_id = ".$id." ORDER BY categories.category_name ASC");
        if($categories->num_rows() == 1) {
            foreach($categories->result_array() as $row) {
                return $row;
            }
        } else {
            return array();
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

    public function get_listing_from_slug($listing_slug)
    {
        $this->db->where('listing_uri', $listing_slug);
        $results = $this->db->get('listings');
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
        $this->db->where('tag_status', 1);
        $results = $this->db->get('tags');
        if($results->num_rows() == 1) {
            foreach($results->result_array() as $row) {
                return $row;
            }
        } else {
            return false;
        }
    }

    public function get_page_from_slug($page_slug)
    {
        $this->db->where('page_status', 1);
        $this->db->where('page_slug', $page_slug);
        $results = $this->db->get('landing_pages');
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
        $this->db->where('sub_categories.category_id', $category_id);
        $this->db->order_by('sub_category_name ASC');
        $results = $this->db->get('sub_categories');
        if($results->num_rows() > 0) {
            return $results->result_array();
        } else {
            return array();
        }
    }

    public function get_more_tags($tag_id)
    {
        if($tag_id > 0) {
            $this->db->where('tag_id != ', $tag_id);
            $this->db->where('tag_status', 1);
            $this->db->order_by('RAND(), tag_name ASC');
            $this->db->limit(3);
            $tags = $this->db->get('tags');

            if($tags->num_rows() > 0) {
                return $tags->result_array();
            } else {
                return array('error' => 'failed');
            }
        } else {
            return array('error' => 'invalid_id');
        }
    }

    public function get_landing_pages()
    {
        $this->db->where('page_status', 1);
        $this->db->order_by('last_updated ASC');
        $results = $this->db->get('landing_pages');
        if($results->num_rows() > 0) {
            return $results->result_array();
        } else {
            return array();
        }
    }

    public function get_tags()
    {
        $this->db->where('tag_status', 1);
        $this->db->order_by('tag_name ASC');
        $results = $this->db->get('tags');
        if($results->num_rows() > 0) {
            return $results->result_array();
        } else {
            return array();
        }
    }

    public function get_listings_rand($exclude_id = 0)
    {
        if($exclude_id > 0) {
            $exclude_sql = 'AND listings.listing_id != '.$exclude_id.' ';
        } else {
            $exclude_sql = '';
        }
        $results = $this->db->query("SELECT * FROM listings, listing_tags, listing_imgs, listing_categories, categories WHERE listing_tags.listing_id = listings.listing_id AND listing_imgs.listing_id = listings.listing_id AND listing_imgs.img_size = '115x115' AND categories.category_id = listing_categories.category_id AND listings.listing_id = listing_categories.listing_id AND listing_status = 1 ".$exclude_sql."ORDER BY RAND()");
        return $this->convert_to_listings($results);
    }

    public function get_listings()
    {
        $this->db->_protect_identifiers=false;
        $this->db->select('listings.*, listing_imgs.*, categories.category_slug');
        $this->db->from('listings, listing_imgs, categories');
        $this->db->where('listings.listing_home_featured >', 0);
        $this->db->where('listings.listing_status', 1);
        $this->db->where('listing_categories.category_id = categories.category_id');
        $this->db->where('listing_imgs.listing_id = listings.listing_id');
        $this->db->where('listing_imgs.img_size', '115x115');
        $this->db->join('listing_descs', "listing_descs.site_id = $this->site_id AND listing_descs.listing_id = listings.listing_id", "left");
        $this->db->join('listing_titles', "listing_titles.site_id = $this->site_id AND listing_titles.listing_id = listings.listing_id", "left");
        $this->db->join('listing_categories', "listing_categories.listing_id = listings.listing_id", "left");
        $this->db->order_by('listing_home_featured ASC');
        $alistings = $this->db->get();
        $alistings_count = $alistings->num_rows();

        $this->db->_protect_identifiers=false;
        $this->db->select('listings.*, listing_imgs.*, categories.category_slug');
        $this->db->from('listings, listing_imgs, categories');
        $this->db->where('listings.listing_home_featured =', 0);
        $this->db->where('listings.listing_status', 1);
        $this->db->where('listing_categories.category_id = categories.category_id');
        $this->db->where('listing_imgs.listing_id = listings.listing_id');
        $this->db->where('listing_imgs.img_size', '115x115');
        $this->db->join('listing_descs', "listing_descs.site_id = $this->site_id AND listing_descs.listing_id = listings.listing_id", "left");
        $this->db->join('listing_titles', "listing_titles.site_id = $this->site_id AND listing_titles.listing_id = listings.listing_id", "left");
        $this->db->join('listing_categories', "listing_categories.listing_id = listings.listing_id", "left");
        $this->db->order_by('listing_created DESC');
        $blistings = $this->db->get();
        $blistings_count = $blistings->num_rows();

        if(($alistings_count == 0) && ($blistings_count == 0)) {
            return array();
        } else {

            if($blistings_count > 0) {
                $listing_types[] = 'blistings';
            }
            if($alistings_count > 0) {
                $listing_types[] = 'alistings';
            }
            for($i = 0; $i < 15; $i++) {
                foreach($listing_types as $type) {
                    $type_count = $type.'_count';
                    if ($$type_count > $i) {
                    $listing_row = $$type->row_array($i);
                        $listings[] = array(
                            'listing_id' => $listing_row['listing_id'],
                            'listing_title' => $this->get_listing_title($listing_row),
                            'listing_uri' => $listing_row['listing_uri'],
                            'listing_url' => $listing_row['listing_url'],
                            'listing_tracking_img' => $listing_row['listing_tracking_img'],
                            'listing_desc' => $this->get_listing_description($listing_row),
                            'listing_affiliate' => $listing_row['listing_affiliate'],
                            'listing_featured' => $listing_row['listing_featured'],
                            'listing_tags' => $this->get_listing_tags($listing_row),
                            'listing_expires' => $listing_row['listing_expires'],
                            'listing_created' => $listing_row['listing_created'],
                            'category_slug' => $listing_row['category_slug'],
                            'img_url' => $listing_row['img_uri'].'.'.$listing_row['img_ext']
                        );
                    }
                }
            }
            return $listings;
        }
    }

    public function get_related_listings($listing_id, $listing_count = 3) {
        $listing = $this->get_listing($listing_id);
        $exclude_id = $listing_id;
        if ($listing['sub_category_id'] > 0) {
            $sub_cat_listings = $this->get_sub_category_listings($listing['sub_category_id'], $exclude_id);
        } else {
            $sub_cat_listings = array();
        }
        $cat_listings = $this->get_category_listings($listing['category_id'], $exclude_id);
        if (count($sub_cat_listings) >= $listing_count) {
            return array_slice($sub_cat_listings, 0, $listing_count);
        } else if ((count($sub_cat_listings) + count($cat_listings)) >= $listing_count) {
            return array_slice(($sub_cat_listings + $cat_listings), 0, $listing_count);
        } else {
            return array_slice(($sub_cat_listings + $cat_listings + $this->get_listings_rand($exclude_id)), 0, $listing_count);
        }
    }

    public function get_listing($listing_id)
    {
        $results = $this->db->query("SELECT * FROM listings, listing_tags, listing_categories, categories, listing_imgs WHERE listing_categories.listing_id = listings.listing_id AND categories.category_id = listing_categories.category_id AND listing_tags.listing_id = listings.listing_id AND listing_imgs.listing_id = listings.listing_id AND listing_imgs.img_size = '115x115' AND listings.listing_id = '" . $listing_id . "' AND listing_status = 1 GROUP BY listings.listing_id ORDER BY listings.listing_featured DESC, listings.listing_affiliate DESC, listings.listing_created ASC");
        return $this->convert_to_listing($results, $listing_id);
    }

    public function get_category_listings($category_id, $exclude_id = 0)
    {
        if($exclude_id > 0) {
            $exclude_sql = 'AND listings.listing_id != '.$exclude_id.' ';
        } else {
            $exclude_sql = '';
        }
        $results = $this->db->query("SELECT * FROM listings, listing_categories, categories, listing_imgs WHERE listing_categories.listing_id = listings.listing_id AND listing_imgs.listing_id = listings.listing_id AND listing_imgs.img_size = '115x115' AND listing_categories.category_id = ".$category_id." AND categories.category_id = listing_categories.category_id AND listings.listing_status = 1 ".$exclude_sql."ORDER BY listings.listing_featured DESC, listings.listing_affiliate DESC, listings.listing_created ASC");
        return $this->convert_to_listings($results);
    }

    public function get_sub_category_listings($sub_category_id, $exclude_id = 0)
    {
        if($exclude_id > 0) {
            $exclude_sql = 'AND listings.listing_id != '.$exclude_id.' ';
        } else {
            $exclude_sql = '';
        }
        $results = $this->db->query("SELECT * FROM listings, listing_categories, categories, listing_imgs WHERE listing_categories.listing_id = listings.listing_id AND listing_imgs.listing_id = listings.listing_id AND listing_imgs.img_size = '115x115' AND sub_category_id = ".$sub_category_id." AND categories.category_id = listing_categories.category_id AND listings.listing_status = 1 ".$exclude_sql."ORDER BY listings.listing_featured DESC, listings.listing_affiliate DESC, listings.listing_created ASC");
        return $this->convert_to_listings($results);
    }

    public function get_tag_listings($tag_id)
    {
        if($tag_id > 0) {
            $results = $this->db->query("SELECT * FROM listings, listing_tags, listing_imgs, listing_categories, categories WHERE listing_tags.listing_id = listings.listing_id AND listing_imgs.listing_id = listings.listing_id AND listing_imgs.img_size = '115x115' AND tag_id = ".$tag_id." AND listing_status = 1 AND categories.category_id = listing_categories.category_id AND listings.listing_id = listing_categories.listing_id ORDER BY listings.listing_featured DESC, listings.listing_affiliate DESC, listings.listing_created ASC");
            return $this->convert_to_listings($results);
        }
    }

    public function get_page_listings($page_id)
    {
        $results = $this->db->query("SELECT * FROM listings, listing_tags, listing_imgs, listing_categories, categories WHERE listing_tags.listing_id = listings.listing_id AND listing_imgs.listing_id = listings.listing_id AND listing_imgs.img_size = '115x115' AND tag_id IN (SELECT landing_pages_tags.tag_id FROM landing_pages_tags WHERE page_id = ".$page_id.") AND categories.category_id = listing_categories.category_id AND listings.listing_id = listing_categories.listing_id AND listing_status = 1 GROUP BY listings.listing_id ORDER BY listings.listing_featured DESC, listings.listing_affiliate DESC, listings.listing_created ASC");
        return $this->convert_to_listings($results);
    }

    protected function convert_to_listings($results, $listing_id = 0)
    {
        if($results->num_rows() > 0) {
            foreach($results->result_array() as $listing_row) {
                $listing = array(
                    'listing_id' => $listing_row['listing_id'],
                    'listing_title' => $listing_row['listing_title'],
                    'listing_uri' => $listing_row['listing_uri'],
                    'listing_url' => $listing_row['listing_url'],
                    'listing_tracking_img' => $listing_row['listing_tracking_img'],
                    'listing_desc' => $this->get_listing_description($listing_row),
                    'listing_affiliate' => $listing_row['listing_affiliate'],
                    'listing_featured' => $listing_row['listing_featured'],
                    'listing_tags' => $this->get_listing_tags($listing_row),
                    'listing_expires' => $listing_row['listing_expires'],
                    'listing_created' => $listing_row['listing_created'],
                    'img_url' => $listing_row['img_uri'].'.'.$listing_row['img_ext'],
                    'category_slug' => $listing_row['category_slug']
                );
                if($listing_id > 0) {
                    $listing['category_id'] = $this->get_categories_by_listing('category_id', $listing_id);
                    $listing['sub_category_id'] = $this->get_categories_by_listing('sub_category_id', $listing_id);
                }
                $listings[] = $listing;
            }
            return $listings;
        } else {
            return array();
        }
    }

    protected function convert_to_listing($results, $listing_id = 0)
    {
        if($results->num_rows() > 0) {
            foreach($results->result_array() as $listing_row) {
                $listing = array(
                    'listing_id' => $listing_row['listing_id'],
                    'listing_title' => $listing_row['listing_title'],
                    'listing_uri' => $listing_row['listing_uri'],
                    'listing_url' => $listing_row['listing_url'],
                    'listing_tracking_img' => $listing_row['listing_tracking_img'],
                    'listing_desc' => $this->get_listing_description($listing_row),
                    'listing_affiliate' => $listing_row['listing_affiliate'],
                    'listing_featured' => $listing_row['listing_featured'],
                    'listing_tags' => $this->get_listing_tags($listing_row),
                    'listing_expires' => $listing_row['listing_expires'],
                    'listing_created' => $listing_row['listing_created'],
                    'img_url' => $listing_row['img_uri'].'.'.$listing_row['img_ext'],
                    'category_slug' => $listing_row['category_slug'],
                    'category_id' => $this->get_categories_by_listing('category_id', $listing_id),
                    'sub_category_id' => $this->get_categories_by_listing('sub_category_id', $listing_id)
                );
            }
            return $listing;
        } else {
            return array();
        }
    }

    private function get_listing_title($listing) {
        $this->db->select('listing_titles.listing_title_value');
        $this->db->where('listing_titles.listing_id', $listing['listing_id']);
        $this->db->where('listing_titles.site_id', $this->site_id);
        $result = $this->db->get('listing_titles');
        if ($result->num_rows() > 0) {
            $row = $result->row();
            $title_value = $row->listing_title_value;
        } else {
            return NULL;
        }
        return ($title_value == 2 ? $listing['listing_alt_title'] : $listing['listing_title']);
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

    private function get_listing_tags($listing, $limit = 3) {
        $result = $this->db->query("SELECT tags.* FROM tags, listing_tags WHERE listing_tags.listing_id = ".$listing['listing_id']." AND listing_tags.tag_id = tags.tag_id AND tags.tag_status = 1 LIMIT 0, ".$limit);
        if($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return array();
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
}