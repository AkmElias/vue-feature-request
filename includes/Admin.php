<?php

namespace Elias\Wpvfr;

class Admin {

    protected $adminview;

    public function __construct(){

        $this->wpvfr_register_admin_menu();
        $this->adminview = new \Elias\Wpvfr\Views\Admin\Admin();
    }

    public function wpvfr_register_admin_menu(){
        add_action( 'admin_menu', [$this, 'wpvfr_add_admin_menu']);
    }

    /**
     * add the main admin menu
     * add sub menu
     */
    public function wpvfr_add_admin_menu(){
        $capability = "manage_options";
        $slug = "vue-feature-request";


        add_menu_page( __('Vue Feature Request', 'vue-feature-request'), __('Vue Feature Request', 'vue-feature-request'), $capability, $slug, [$this, 'wpvfr_load_view'], 'dashicons-text', 65);

        add_submenu_page( $slug, __('Vue Feature Request Lists', 'vue-feature-request'), __('Vue Feature Request Lists', 'vue-feature-request'), $capability, $slug.'#/list', [$this, 'wpvfr_load_view'] );
    }

    public function wpvfr_load_view(){
        $this->adminview->wpvfr_admin_view_render();
    }
}