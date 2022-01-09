<?php

namespace Elias\Wpvfr\Router;

use Elias\Wpvfr\Controllers\VueFeatureBoard;

class Admin
{
    protected $vueFeatureBoard;
    public function __construct()
    {
        $this->vueFeatureBoard = new VueFeatureBoard();
        $this->wpvfr_admin_routes();
    }

    public function wpvfr_admin_routes(){
        add_action('wp_ajax_wpvfr_create_vue_feature_board',[$this->vueFeatureBoard,'wpvfr_create_vue_feature_board']);
        add_action('wp_ajax_wpvfr_get_all_vue_feature_board',[$this->vueFeatureBoard,'wpvfr_get_all_vue_feature_board']);
        add_action('wp_ajax_wpvfr_delete_feature_board', [$this->vueFeatureBoard, 'wpvfr_delete_feature_board']);
        add_action('wp_ajax_wpvfr_update_feaure_board', [$this->vueFeatureBoard, 'wpvfr_update_feaure_board']);
    }
}