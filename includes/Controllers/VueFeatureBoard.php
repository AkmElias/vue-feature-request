<?php

namespace Elias\Wpvfr\Controllers;

use Elias\Wpvfr\Models\VueFeatureBoardModel;

class VueFeatureBoard{
    protected $model;

    public function __construct(){
        global $wpdb;
        $this->model = new VueFeatureBoardModel();
    }

    public function handle_endpoints(){
        //check nonce, if it fails return
        if(!wp_verify_nonce($_POST['nonce'], 'aj-nonce')){
            error_log("nonce failed........");
            wp_send_json([
                "status" => 403,
                "nonce" => $_POST['nonce'],
                "success"=> false,
                "message" => "Something went wrong! Request not valid.",
                "data" => $_POST['sort_by']
            ]);
            wp_die();
        }

        $route = sanitize_text_field($_REQUEST['route']);


        $routes = array(
            'add_feature_board'    => 'addFeatureBoard',
            'get_all_feature_board' => 'getAllFeatureBoard',
            'update_feature_board' => 'updateFeatureBoard',
            'update_feature_board_sort_by' => 'updateFeatureBoardSortBy',
            'delete_feature_board' => 'deleteFeatureBoard'
            //            'update_global_currency_settings' => 'updateGlobalCurrencySettings',
//            'wpf_upload_image'                => 'handleFileUpload',
//            'get_recaptcha_settings'          => 'getRecaprchaSettings',
//            'save_recaptcha_settings'         => 'saveRecaptchaSettings',
//            'get_access_roles'                => 'getAccessRoles',
//            'set_access_roles'                => 'setAccessRoles'
        );

        if (isset($routes[$route])) {

            $this->{$routes[$route]}();
            return;
        }
    }

    public function addFeatureBoard(){
        //error data 
        $error = false;
        $errors = array();

        //get board data 
        $data = array();
        $data['title'] = sanitize_text_field($_POST['title']);
        $data['sort_by'] = sanitize_text_field($_POST['sort_by']);
        $data['visibility'] = sanitize_text_field($_POST['visibility']);
        $data['logo'] = sanitize_text_field($_POST['logo']);

         // board data validation
        if (empty($data['title'])) {
            //title is empty
            $error = true;
            $errors['title'] = 'Board Title is required.';
        }

        // board data validation
        if (empty($data['visibility'])) {
            //visibility is empty
            $error = true;
            $errors['visibility'] = 'Visibility is required.';
        }

        // board data validation
        if (!empty($data['visibility']) && ($data['visibility'] !== 'public' && $data['visibility'] !== 'private')) {
            //not public or private
            $error = true;
            $errors['visibility'] = 'Visibility value should be ("public" or "private").';
        }

        //check error and send response 
        if($error){
            wp_send_json_error( $errors );
            wp_die();
        }

        $data['creatorId'] = get_current_user_id();

        //Call the create function after all verifications
        $result = $this->model->wpvfr_insert_vue_feature_board($data);
        if($result) {
            error_log("resultttttt......");
            $data = $this->model->wpvfr_get_vue_feature_board_by_id($result);
            wp_send_json_success( $data, 201 );
            wp_die();
        }
    }

    public function getAllFeatureBoard(){

        $result = $this->model->wpvfr_get_all_boards();
        if(is_wp_error($result)){
            wp_send_json([
                'success' => false,
                'status' => 404,
                'message' => $result->get_error_message()
            ]);
            wp_die();
        }
        wp_send_json_success( $result, 200 ); 
        wp_die();

    }

    public function updateFeatureBoard(){

        //check error 
        $error = false;
        $errors = array();

        //get board data 
        $data = array();
        $where = array();
        $where['id'] = sanitize_text_field($_POST['board_id']);
        $data['title'] = sanitize_text_field($_POST['title']);
        $data['sort_by'] = sanitize_text_field($_POST['sort_by']);
        $data['visibility'] = sanitize_text_field($_POST['visibility']);
        $data['logo'] = sanitize_text_field($_POST['logo']);

        // board data validation
        if (empty($where['id'])) {
            //id is empty
            $error = true;
            $errors['board_id'] = 'Board not fountd.';
        }

        // check error and send response
        if ($error) {
            wp_send_json_error($errors, 403);
            wp_die();
        }

        $result = $this->model->wpvfr_update_feaure_board($data, $where);
        if($result){
            wp_send_json_success($result, 200);
        }else{
            wp_send_json(['success' => false]);
        }
        wp_die();

    }

    /**
     * Update bord's sort_by only
     */
    public function updateFeatureBoardSortBy(){

        //check error 
        $error = false;
        $errors = array();

        //get board data 
        $data = array();
        $where = array();
        $where['id'] = sanitize_text_field($_POST['board_id']);

        $data['sort_by'] = sanitize_text_field($_POST['sort_by']);

        // board data validation
        if (empty($where['id'])) {
            //id is empty
            $error = true;
            $errors['board_id'] = 'Board not fountd.';
        }

        // check error and send response
        if ($error) {
            wp_send_json_error($errors, 403);
            wp_die();
        }

        $result = $this->model->wpvfr_update_board_sort_by($data, $where);
        if($result){
            wp_send_json_success($result, 200);
        }else{
            wp_send_json(['success' => false]);
        }
        wp_die();

    }

    /**
     * Delete feature board by id
     */
    public function deleteFeatureBoard(){
        
        //get id
        $where = array();
        $id = sanitize_text_field($_POST['id']);
        $where['id'] = $id;
        $where['creatorId'] = get_current_user_id();

        $result = $this->model->wpvfr_delete_feature_board($where);
       
        if($result){
                wp_send_json_success();
        }else{
                wp_send_json(['success' => 'false']);
        }

        wp_die();
        
    }
}