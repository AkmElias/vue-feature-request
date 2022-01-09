<?php

namespace Elias\Wpvfr\Models;

class VueFeatureBoardModel {

    protected $_wpdb;
    protected $table;

    public function __construct(){
        global $wpdb;
        $this->_wpdb = $wpdb;
        $this->table = $wpdb->prefix. WPVFR_request_board;
    }

    /**
     * Insert data into vue feature board
     * @params $data
     * @return $rresult
     */

    public function wpvfr_insert_vue_feature_board($data){
      
        $result = $this->_wpdb->insert($this->table, $data);
        if($result){
            return $this->_wpdb->insert_id;
        } else {
            return false;
        }
    }

    /**
     * Get feature board by id
     * @params $id
     * @return feature board 
     */
    public function wpvfr_get_vue_feature_board_by_id($id) {
        return $this->_wpdb->get_row("SELECT * from $this->table WHERE id = $id");
    }

    /**
     * Get all vue feature boards
     * @params null
     * @return feature boards
     */
    public function wpvfr_get_all_boards(){
        return $this->_wpdb->get_results("SELECT * from $this->table", ARRAY_A);
    }

    /**
     * Update board sort_by 
     * @params null
     * @return result
     */
    public function wpvfr_update_feaure_board($data, $where){
        return $this->_wpdb->update($this->table, $data, $where);
    }

    /**
     * Delete feature board by id
     */
    public function wpvfr_delete_feature_board($where){
        return $this->_wpdb->delete($this->table, $where);
    }
}