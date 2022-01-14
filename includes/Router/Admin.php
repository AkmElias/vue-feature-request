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
        add_action('wp_ajax_wpvfr_feature_board_doing',[$this->vueFeatureBoard,'handle_endpoints']);
    }
}