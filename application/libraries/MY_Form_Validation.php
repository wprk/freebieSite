<?php

class MY_Form_validation extends CI_Form_validation {

    public function __construct() {
        parent::__construct();
    }

    /**
     * is_unique
     *
     * @access	public
     * @param	string
     * @param	field
     * @return	bool
     */
    public function is_unique($str, $field)
    {
        $CI =& get_instance();
        list($table, $column) = explode('.', $field, 2);

        $CI->form_validation->set_message('unique', 'The %s that you requested is unavailable.');

        $query = $CI->db->query("SELECT COUNT(*) AS dupe FROM $table WHERE $column = '$str'");
        $row = $query->row();
        return ($row->dupe > 0) ? FALSE : TRUE;
    }
}