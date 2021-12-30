<?php
/**
 * @package WPFR
 * @author AkmELias
 * @License GPLv2 or later
 * @wordpress plugin
 * 
 * Plugin Name:       Vue Feature Request 
 * Plugin Uri:        https://example.com/plugins/feature-request/
 * Description:       Handle the basic feature request
 * Version:           1.0.0
 * Requires at last:  5.2
 * Requires PHP:      7.2
 * Author:            Elias
 * Author URI:        https://akmelias.netlify.app/
 * License:           GPL v2 or later
 * Licence URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       vue-feature-request
 * Domain Path:       /languages
 */

defined('ABSPATH') or die('You have no access!!');


require_once __DIR__ . '/vendor/autoload.php';

class WP_Vue_Feature_Request{
    /**
     * version
     */
    const VERSION = '1.0.0';
    
    /**
     * plugin constatnts
     */
    private $plugin_constants;

    //constructor
    public function __construct(){
       $this->plugin_constants = $this->plugin_constants();
       register_activation_hook( __file__, [$this, 'activate'] );
       register_deactivation_hook( __file__, [$this, 'deactivate'] );
       add_action( 'plugins_loaded', [$this, 'init'] );

    }

    /**
     * plugin costatns
     * @since 1.0
     */
    public function plugin_constants(){
        define("WPVFR_VERSION", self::VERSION);
        define('WPVFR_PLUGIN_PATH', __FILE__);
        define('WPVFR_PLUGIN_URL', trailingslashit( plugin_dir_url(__FILE__) ));
        define('WPVFR_ASSETS', WPVFR_PLUGIN_URL . "assets");
        define('WPVFR_NONCE', 'wpvfr123456');
        define('WPVFR_request_board', 'wpvfr_request_boards');
        define("WPVFR_request_list", 'wpvfr_request_lists');
        define('WPVFR_request_comments', 'wpvfr_request_comments');
        define('WPVFR_rquest_votes', 'wpvfr_request_votes');
        define('WPVFR_request_comment_reply', 'wpvfr_request_comment_replies');
    }

   /**
    * self instance
    * @since 1.0.0
    */
    public static function instance(){
        static $instance = null;

        if(is_null($instance)){
            return $instance = new self();
        }
    }

    /**
     * activate plugin
     * @since 1.0.0
     */
    public function activate(){
        $installed = get_option( "wpfr_installed");
        if(!$installed){
            update_option( 'wpfr_installed', time() );
        }
        update_option('wpfr_installed', WPVFR_VERSION);

        $tables = new \Elias\Wpvfr\Tables();
        $tables->wpvfr_create_tables();
    }

    /**
     *deactivate plugin
     */
    public function deactivate(){
        flush_rewrite_rules();
    }

    /**
     * 
     * init plugin
     * 
     * @return void
     * 
     * @params NULL
     * 
     */
    public function init(){
        if(is_admin()){

            new \Elias\Wpvfr\Admin();
        }

        new Elias\Wpvfr\Assets();
        new Elias\Wpvfr\Router\Router();
    }
}

/**
 * 
 * initialize the plugin
 *
 */
function wpvfr(){
    return WP_Vue_Feature_Request::instance();
}

//bootstarp plugin
wpvfr();