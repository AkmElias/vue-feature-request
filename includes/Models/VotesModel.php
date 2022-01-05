<?php

namespace Elias\Wpvfr\Models;

class VotesModel{

    protected $_wpdb;
    protected $table;

    public function __construct(){
        global $wpdb;
        $this->_wpdb = $wpdb;
        $this->table = $wpdb->prefix. WPVFR_request_votes;
    }

    /**
     * Insert votes
     * @params data 
     * @return insert_id
     */
    public function wpvfr_insert_votes($data)
    {
        $result =  $this->_wpdb->insert($this->table,$data);
        if($result){
            return  $this->_wpdb->insert_id;
        }else{
            return false;
        }
    }


    /**
     * Delete votes 
     * @params $where
     * @return void
     */
    public function wpvfr_delete_votes($where){
        return $this->_wpdb->delete($this->table, $where);
    }
}