<?php

namespace Elias\Wpvfr;

class Assets{
    /**
    * constructor
    */

    public function __construct(){
        add_action('admin_enqueue_scripts', [$this, 'register']);
        // add_action('wp_enqueue_scripts', [$this, 'register'], 999);
    }

    /**
     * register styles/scripts 
     */
    public function register(){
        
        if(is_admin()){
            
            $this->register_scripts($this->get_admin_scripts());
            wp_localize_script( 'wpvfr_admin_script', 'ajax_obj', array(
                'ajaxurl' => admin_url('admin_ajax.php'),
                'nonce' => wp_create_nonce( WPVFR_NONCE )
            ) );
        } else {

        }
    }

    /**
     * register scripts 
     * @params $scripts 
     * @return void
     */
    public function register_scripts($scripts){
        foreach ($scripts as $handle => $script){
            $deps = $script['deps'] ?? false;
            $in_footer = $script['in_footer'] ?? false;
            $version = $script['version'] ?? WPVFR_VERSION;
            wp_enqueue_script($handle, $script['src'], $deps, $version, $in_footer);
        }
    }

    /**
     * register styles 
     * @params styles 
     * @return void
     */
    public function register_styles($styles){
         foreach ($styles as $handle => $style) {
            $deps = $style['deps'] ?? false;
            $version = $style['version'] ?? WPVFR_VERSION;

            wp_enqueue_style($handle, $style['src'], $deps, $version);
        }
    }

    /**
     * Get admin scripts 
     */
    public function get_admin_scripts(): array
    {

        return [
            'wpvfr_admin_scripts' => [
                'src' => WPVFR_ASSETS. "/admin/js/main.js",
                'deps' => ['jquery'], 
                'version' => time(),
                'in_footer' => true
            ]
            ];
    }
}