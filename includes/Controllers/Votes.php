<?php

namespace Elias\Wpvfr\Controllers;

use Elias\Wpvfr\Models\VotesModel;

class Votes
{
    protected $model;
    public function __construct()
    {
        $this->model = new VotesModel();
    }
    public  function  wpvfr_req_vote_handle(){
        //check nonce, if it fails return
        if (!wp_verify_nonce($_POST['nonce'], 'aj-nonce')) {
            wp_send_json([
                'success' => false,
                'status' => 403,
                'message' => 'Something wrong! Not a valid request.'
            ]);
            wp_die();
        }
        // get data
        $data = array();
        $where = array();
        $request_id = sanitize_text_field($_POST['request_id']);
        $add_vote= sanitize_text_field($_POST['add_vote']);

        if(empty($request_id) || empty($add_vote)){
            wp_send_json_error();
            wp_die();
        }

        $data['request_id'] = $request_id;
        $data['user'] = get_current_user_id();

        $where['request_id'] = $request_id;
        $where['user'] = get_current_user_id();

        if($add_vote === 'true'){
            $result = $this->model->wpvfr_insert_votes($data);
            if($result){
                wp_send_json_success();
            }else{
                wp_send_json(['success' => 'false']);
            }
        }else {
            $result = $this->model->wpvfr_delete_votes($where);
            if($result){
                wp_send_json_success();
            }else{
                wp_send_json(['success' => 'false']);
            }
        }
        wp_die();
    }

}