<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/**
 * ErkanaAuth
 *
 * An easy-to-use authentication framework for CodeIgniter
 *
 * @package		ErkanaAuth
 * @author		Michael Wales
 * @copyright	Copyright (c) 2010, Michael D. Wales
 * @license		http://creativecommons.org/licenses/BSD/
 */

// ------------------------------------------------------------------------

/**
 * Erkana Auth Account Class
 *
 * @package		ErkanaAuth
 * @subpackage	Models
 * @category	Authentication
 * @author		Michael Wales
 */

// ------------------------------------------------------------------------

class Account extends CI_Model {

    // The table storing user accounts
    var $table = 'accounts';

    function __construct() {
        parent::__construct();
    }


    /**
     * Get - Returns a single account object by id
     *
     * @access		public
     * @param		int
     * @return		mixed
     */
    function get($id) {
        $query = $this->db->get_where($this->table, array('id' => $id), 1, 0);

        if ($query->num_rows() === 1) {
            return $query->row();
        }

        return NULL;
    }


    /**
     * Get By - Returns a single account object by a WHERE clause
     *
     * @access		public
     * @param		array
     * @return		mixed
     */
    function get_by($where) {
        $query = $this->db->get_where($this->table, $where, 1, 0);

        if ($query->num_rows() === 1) {
            return $query->row();
        }

        return NULL;
    }


    /**
     * Create - Creates an account object
     *
     * @access		public
     * @param		array
     * @return		bool
     */
    function create($account) {
        return $this->db->insert($this->table, $account);
    }

    /**
     * Edit - Edits an account object
     *
     * @access		public
     * @param		int
     * @param		array
     * @return		bool
     */
    function edit($id, $account) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $account);
    }

    /**
     * Update - Updates an account object
     *
     * @access		public
     * @param		int
     * @param		array
     */
    function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

}

/* End of file account.php */
/* Location: ./application/models/account.php */