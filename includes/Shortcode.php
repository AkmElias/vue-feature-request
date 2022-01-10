<?php

namespace Elias\Wpvfr;

use Elias\Wpvfr\Views\Frontend\Frontend;

class Shortcode
{

    protected $frontend;

    public function __construct()
    {
        add_shortcode("wpvfr-board", [$this, 'wpvfr_feature_request_board']);
        $this->frontend = new Frontend();
    }

    public function wpvfr_feature_request_board($atts = [], $e = '', $tag = ''): string
    {
        global $wpdb;
        $list_table = $wpdb->prefix . WPVFR_request_list;
        $comment_table = $wpdb->prefix . WPVFR_request_comments;
        $votes_table = $wpdb->prefix . WPVFR_request_votes;
        $atts = array_change_key_case((array)$atts, CASE_LOWER);

        $wpvfr_atts = shortcode_atts(
            array(
                'id' => ''
            ),
            $atts
        );

        if (!empty($wpvfr_atts['id'])) {
            //Get board
            $board = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . WPVFR_request_board . " WHERE id=" . $wpvfr_atts['id']);
            global $current_user;
            global $wp;

            // sort request by 
            $order_by = '';
            if ($board->sort_by == 'alphabetical') {
                $order_by = "title";
            } else if ($board->sort_by == 'comments') {
                $order_by = "comments DESC";
            } else if ($board->sort_by == 'upvotes') {
                $order_by = "votes DESC";
            } else if ($board->sort_by == 'random') {
                $order_by = "RAND()";
            } else {
                $order_by = "";
            }

            // var_dump($board, ' ', $order_by); 

            $query = "SELECT l.*, COALESCE(comments,0) as comments, COALESCE(votes, 0) as votes FROM wp_wpvfr_request_lists as l
LEFT JOIN 
	(SELECT * , COUNT(request_id) as comments FROM wp_wpvfr_request_comments GROUP BY request_id) as c
ON l.id = c.request_id 
LEFT JOIN
    (SELECT * , COUNT(user) as votes FROM wp_wpvfr_request_votes GROUP BY request_id) as v
    ON l.id = v.request_id
    WHERE l.board_id = ".$wpvfr_atts['id']." ORDER BY $order_by";


            // exit();
            $all_req = $wpdb->get_results(
                $query
            );

            // print_r($all_req);
            // exit();
            //UI starts 
            $e = '<div class="wpvfr">';

            // header section
            $e .= '<header class="flex justify-between items-center">';
            $e .= '<div class="header-left">';
            if (!empty($board->logo)) {
                $e .= '<img src="' . $board->logo . '" alt="">';
            }
            $e .= '<div class="header-left-content">';
            if (!empty($board->title)) {
                $e .= '<h1 ><a href="" class="text-2xl text-gray-700">' . esc_html($board->title) . '</a></h1>';
            } else {
                $e .= '<h1 class="text-2xl text-gray-700"><a href="" class="text-2xl text-gray-700">' . esc_html('Vue Feature Board') . '</a></h1>';
            }
            $e .= '</div>';
            $e .= '</div>';
            $e .= '<div>';
            $e .= '<div class="header-right">';
            $e .= '<ul>';
            if (!is_user_logged_in()) {
                $e .= '<div>';
                $e .= '<button class="btn simple login menu">' . esc_html('Login', 'wpvfr') . '</button>';
                $e .= '<span>' . esc_html('/', 'wpvfr') . '</span>';
                $e .= '<button class="btn simple register menu">' . esc_html('Register', 'wpvfr') . '</button>';
                $e .= '</div>';
            } else {
                $e .= '<li class="user-logout user-out">';
                $e .= '<a>';
                $e .= '<img width="32" height="32" src="' . get_avatar_url($current_user->ID) . '"/> ' . esc_html__('Hi, ', 'wpvfr') . esc_html($current_user->display_name) . ' <span class="downicon"></span>';
                $e .= '</a>';
                $e .= '<div class="user-logout-dropdown">';
                $e .= '<a href="' . site_url() . '/wp-admin/profile.php"><span class="user-icon"></span>' . esc_html__('Profile ', 'wpvfr') . '</a>';
                $e .= '<a class="user-logout" href="' . wp_logout_url(add_query_arg($wp->query_vars, home_url($wp->request))) . '">';
                $e .= '<span class="logout-power-icon"></span> ' . esc_html__('Logout', 'wpvfr');
                $e .= '</a>';
                $e .= '</div>';
                $e .= '</li>';
            }
            $e .= '</ul>';
            $e .= '</div>';
            $e .= "</div>";
            $e .= "</header>";

            // request feature section
            $e .= '<section class="wpvfr-feature-section">';
            $e .= '<div class="frb-req-header">';
            $e .= '<button class="frb-req-add-button">' . esc_html__('New Vue Feature Request', 'wpvfr') . '</button>';
            $e .= '<input type="text"  name="frb_req_search_input" placeholder="' . esc_attr__('Search feature..', 'wpvfr') . '" class="frb-req-search-input">';
            $e .= '</div>';

            //form section
            $e .= '<div id="frb-req-form-area" class="frb-req-form-area" style="display:none;">';
            if (!is_user_logged_in()) {
                $e .= '<div class="frb-req-not-login-section">';
                $e .= '<span>' . esc_html__('First Login to request feature.', 'wpvfr') . '</span>';
                $e .= '<button class="btn simple login menu">' . esc_html('Login', 'wpvfr') . '</button>';
                $e .= '</div>';
            } else {
                $e .= $this->frontend->wpvfr_request_form_view($board);
            }
            $e .= '</div>';
            $e .= "</section>";


            // feature request filter section
            $e .= '<div class="frb-req-filter-area">';
            $e .= '<p>(' . count($all_req) . ') ' . esc_html__('feature requests', 'wpvfr') . '</p> ';
            $e .= '<div class="right">';
            $e .= '<p>' . esc_html__('Sort By:', 'wpvfr') . '</p>';
            $e .= '<select data-id="' . esc_attr($board->id) . '" id="wpvfr-req-select-id">';
            if ($board->sort_by === 'votes') {
                $selected_vote = __('selected', 'wpvfr');
            } else {
                $selected_vote = '';
            }
            if ($board->sort_by === 'alphabetical') {
                $selected_alph = __('selected', 'wpvfr');
            } else {
                $selected_alph = '';
            }
            if ($board->sort_by === 'comments') {
                $selected_cmnt = __('selected', 'wpvfr');
            } else {
                $selected_cmnt = '';
            }
            if ($board->sort_by === 'random') {
                $selected_rnmd = __('selected', 'wpvfr');
            } else {
                $selected_rnmd = '';
            }
            $e .= '<option ' . esc_attr($selected_alph) . ' value="alphabetical">' . esc_html__('Alphabetical', 'wpvfr') . '</option>';
            $e .= '<option ' . esc_attr($selected_rnmd) . ' value="random">' . esc_html__('Random', 'wpvfr') . '</option>';
            $e .= '<option ' . esc_attr($selected_vote) . ' value="votes">' . esc_html__('Number of Upvotes', 'wpvfr') . '</option>';
            $e .= '<option ' . esc_attr($selected_cmnt) . ' value="comments">' . esc_html__('Number of Comments', 'wpvfr') . '</option>';
            $e .= '</select>';
            $e .= '</div>';
            $e .= '</div>';

            // feature request items

            $e .= '<div class="wpvfr-requests-list-body">';
            if (sizeof($all_req) <= 0) {
                $e .= '<p> Feature Requests (' . sizeof($all_req) . ') </p>';
            } else {
                foreach ($all_req as $item) {
                    $e .= $this->frontend->wpvfr_item_view($board, $item);
                }
            }
            $e .= '</div>';

            // login register form
            $e .= $this->frontend->wpvfr_register_form_view();

            $e .= "</div>";
        }

        return $e;
    }
}
