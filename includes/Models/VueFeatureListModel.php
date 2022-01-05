<?php 

namespace Elias\Wpvfr\Models;

class VueFeatureListModel {

    protected $_wpdb;
    protected $table;

    public function __construct(){
        global $wpdb;
        $this->_wpdb = $wpdb;
        $this->table = $wpdb->prefix. WPVFR_request_list;
    }

    /**
     * Add vue feature request 
     * @params data 
     * @return insert_id 
     */
    public function wpvfr_add_vue_feature_req($data){
        $result = $this->_wpdb->insert($this->table, $data);
        if($result){
            return $this->_wpdb->insert_id;
        } else {
            return false;
        }
    }

    /**
     * Get Feature Req by id 
     * @params $id 
     * @return feature req.
     */
    public function wpvfr_get_vue_feature_req_by_id($id){
        return $this->_wpdb->get_row("SELECT * from $this->table WHERE id = $id");
    }

    /**
     * Get Feature reqs by board id 
     * @params board_id 
     * @return feature reqs
     */
    public function wpvfr_get_all_vue_feature_reqs_by_board_id($id){
        return $this->_wpdb->get_results("SELECT * from $this->table WHERE board_id = $id", ARRAY_A);
    }

    /**
     * Get all vue feature reqs
     * @params null 
     * @return all reqs
     */
    public function wpvfr_get_all_vue_feature_reqs(){
        return $this->_wpdb->get_results("SELECT * from $this->table", ARRAY_A);
    }
}