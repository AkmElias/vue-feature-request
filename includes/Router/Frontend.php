<?php

namespace Elias\Wpvfr\Router;

use Elias\Wpvfr\Controllers\VueFeatureBoard;
use Elias\Wpvfr\Controllers\VueFeatureList;
use Elias\Wpvfr\Controllers\User;
use Elias\Wpvfr\Controllers\Votes;

class Frontend
{
    protected $user;
    protected $feature_board;
    protected $feature_list;
    protected $votes_controller;
    public function __construct()
    {
        $this->user = new User();
        $this->feature_board = new VueFeatureBoard();
        $this->feature_list = new VueFeatureList();
        $this->votes_controller = new Votes();
        $this->wpvfr_routes();
    }

    public function wpvfr_routes(){
        add_action('wp_ajax_nopriv_wpvfr_user_register', [$this->user, 'wpvfr_user_register']);
        add_action('wp_ajax_nopriv_wpvfr_update_board_sort_by', [$this->feature_board, 'wpvfr_update_board_sort_by']);
        add_action('wp_ajax_wpvfr_update_board_sort_by', [$this->feature_board, 'wpvfr_update_board_sort_by']);
        add_action('wp_ajax_wpvfr_req_vote_handle', [$this->votes_controller, 'wpvfr_req_vote_handle']);
        add_action('wp_ajax_nopriv_wpvfr_user_login', [$this->user, 'wpvfr_user_login']);
        add_action('wp_ajax_wpvfr_add_vue_feature_req', [$this->feature_list, 'wpvfr_add_vue_feature_req']);
        add_action('wp_ajax_wpvfr_get_all_vue_feature_list', [$this->feature_list, 'wpvfr_get_all_vue_feature_list']);
        add_action('wp_ajax_wpvfr_get_all_vue_feature_reqs_by_board_id', [$this->feature_list, 'wpvfr_get_all_vue_feature_reqs_by_board_id']);
    }
}