<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
	{
        redirect('/s5k9d7f6jdn0/listings/');
	}

//    public function fix_image_names() {
//        $listings = $this->admin_model->get_listings();
//        foreach ($listings as $listing) {
//            $img_url = $_SERVER['DOCUMENT_ROOT']."/includes/images/listings/".$listing['listing_id'].".png";
//            if (file_exists($img_url)) {
//                echo $listing['listing_id'].'<br />';
//                $new_url = $_SERVER['DOCUMENT_ROOT']."/includes/images/listings/".$this->admin_model->slugify($listing['listing_title'])."-sml".".png";
//                echo $new_url.'<br />';
//                rename($img_url, $new_url);
////                $img_data = array(
////                    'listing_id' => $listing['listing_id'],
////                    'img_size' => '115x115',
////                    'img_ext' => 'png',
////                    'img_uri' => $this->admin_model->slugify($listing['listing_title'])."-sml",
////                );
////                echo $this->admin_model->create_img($img_data);
//            }
//        }
//    }
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
