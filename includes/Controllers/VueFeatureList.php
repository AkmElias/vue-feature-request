<?php

namespace Elias\Wpvfr\Controllers;

use Elias\Wpvfr\Models\VueFeatureListModel;

class VueFeatureList{
    protected $model;

    public function __construct(){
        $this->model = new VueFeatureListModel();
    }

     // feature add 
     public function wpvfr_add_vue_feature_req(){
        //check nonce, if it fails return
        if (!wp_verify_nonce($_POST['nonce'], 'aj-nonce')) {
           wp_send_json([
               'success' => false,
               'status' => 403,
               'message' => 'Something wrong! Not a valid request.'
           ]);
           wp_die();
        }

       //error data
       $error = false;
       $errors = array();

       // get feature data
       $data = array();
       $data["author"] = get_current_user_id();
       $data["board_id"] = (int)sanitize_text_field($_POST['board']);
       $data["title"] = sanitize_text_field($_POST['title']) ?? '';
       $data["description"] = sanitize_text_field($_POST['description']) ?? '';
       $data["status"] = "inprogress";

       //check filetype
       $fileInfo = wp_check_filetype(basename($_FILES['logo']['name']));
       $data["logo"] = !empty($fileInfo['ext']) ? $_FILES['logo'] :'';
     
        // feature data validation
        if (empty($data['title'])) {
           //title is empty
           $error = true;
           $errors['title'] = 'Request title is required.';
       }

       // feature data validation
       if (empty($data['description'])) {
           //description is empty
           $error = true;
           $errors['description'] = 'Description is required.';
       }

       //logo upload handle
       if(!empty($data['logo'])){
           if ( ! function_exists( 'wp_handle_upload' ) ) {
               require_once( ABSPATH . 'wp-admin/includes/file.php' );
           }
           $uploadedfile = $data['logo'];

           $upload_overrides = array(
               'test_form' => false
           );
           $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
           
           if ( $movefile && ! isset( $movefile['error'] ) ) {
              $data["logo"] = $movefile['url'];
           } else {
               $error= true;
               $errors['logo'] = $movefile['error'];
           }
       }

       // check error and send response
       if ($error) {
           $error = false;
           wp_send_json_error($errors, 403);
           wp_die();
       }

       // handle add to database
       $result = $this->model->wpvfr_add_vue_feature_req($data);
        if($result){
            $data = $this->model->wpvfr_get_vue_feature_req_by_id($result);
            wp_send_json_success($data);
        }else{
            // insert faild
            wp_send_json_error(['error' => "Insert Faild"], 403);
        }
        wp_die();
        }

    // get all feature list
    public function wpvfr_get_all_vue_feature_list(){
        //check nonce, if it fails return
        if (!wp_verify_nonce($_POST['nonce'], 'aj-nonce')) {
            wp_send_json([
                'success' => false,
                'status' => 403,
                'message' => 'Something wrong! Not a valid request.'
            ]);
            wp_die();
        }

        $result = $this->model->wpvfr_get_all_vue_feature_reqs();
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

    //Get all request by board id 
    public function wpvfr_get_all_vue_feature_reqs_by_board_id(){
         //check nonce, if it fails return
        if (!wp_verify_nonce($_POST['nonce'], 'aj-nonce')) {
           wp_send_json([
               'success' => false,
               'status' => 403,
               'message' => 'Something wrong! Not a valid request.'
           ]);
           wp_die();
        }

        $board_id = isset($_POST['board_id']) ? $_POST['board_id'] : '';

        if($board_id == 'all') {
            $result = $this->model->wpvfr_get_all_Vue_feature_reqs();
            if(is_wp_error($result)){
                wp_send_json([
                    'success' => false,
                    'status' => 404,
                    'message' => $result->get_error_message(),
                    'data' => []
                ]);
                wp_die();
            }
        } else {
            $result = $this->model->wpvfr_get_all_vue_feature_reqs_by_board_id($board_id);
            if(is_wp_error( $result ) || $result === NULL) {
                wp_send_json([
                    'success' => false,
                    'status' => 404,
                    'data' => []
                ]);
                wp_die();
            }
        }
        wp_send_json_success( $result, 200 );
        die();
    }

}
