<?php

namespace Elias\Wpvfr\Views\Frontend;

class Frontend
{

    public function wpvfr_register_form_view(): string
    {
        $e = null;
        $e .= '<div class="wpvfr-popup-overlay wpvfr-login-register">';
        $e .= '<div class="wpvfr-popup-content">';
        $e .= '<button class="overlay-close">' . esc_html__('X', 'wpvfr') . '</button>';
        $e .= '<div class="wpvfr-login-register-inner">';
        $e .= '<div class="nav">';
        $e .= '<button class="tab btn login active">' . esc_html__('Login', 'wpvfr') . '</button>';
        $e .= '<button class="tab btn  register">' .
            esc_html__('Register', 'wpvfr')
            . '</button>';
        $e .= '</div>';
        $e .= '<div class="wpvfr-login-register-body">';

        //login form
        $e .= '<form class="active-form" id="wpvfr-login-form">';
        $e .= '<h2>' . esc_html__('Login', 'wpvfr') . '</h2>';
        $e .= '<p class="wpvfr-from-msg-status login"></p>';
        $e .= '<div class="input-group">';
        $e .= '<label class="label-text" for="username">' .
            esc_html__('Username', 'wpvfr') .
            '</label>';
        $e .= '<input
                                    class="form-control"
                                    id="username"
                                    type="text"
                                    name="username"
                                    placeholder="' . esc_attr__('username', 'wpvfr') . '">';
        $e .= '</div>';
        $e .= '<div class="input-group">';
        $e .= '<label class="label-text" for="username">' .
            esc_html__('Password', 'wpvfr') .
            '</label>';
        $e .= '<input
                                    class="form-control"
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="' . esc_attr__('password', 'wpvfr') . '">';

        $e .= '</div>';
        $e .= '<div class="input-group btn-box">';
        $e .= '<button id="wpvfr-login-submit" type="submit" class="btn login submit">' .
            esc_html__('Login', 'wpvfr') . '</button>';
        $e .= '</div>';
        $e .= '</form>';

        // register form
        $e .= '<form class="" id="wpvfr-register-form">';
        $e .= '<h2>' . esc_html__('Register', 'wpvfr') . '</h2>';
        $e .= '<p class="wpvfr-from-msg-status register"></p>';
        $e .= '<div class="input-group">';
        $e .= '<label class="label-text" for="display_name">' .
            esc_html__('Display Name', 'wpvfr') .
            '</label>';
        $e .= '<input      class="form-control"
                                                                                id="display_name"
                                                                                type="text"
                                                                                name="display_name"
                                                                                    placeholder="' . esc_attr__('Display name', 'wpvfr') . '">';
        $e .= '</div>';
        $e .= '<div class="input-group">';
        $e .= '<label class="label-text" for="username">' .
            esc_html__('Username', 'wpvfr') .
            '</label>';
        $e .= '<input class="form-control"
                                                            id="username"
                                                            type="text"
                                                            name="username"
                                                                placeholder="' . esc_attr__('username', 'wpvfr') . '">';
        $e .= '</div>';
        $e .= '<div class="input-group">';
        $e .= '<label class="label-text" for="email">' .
            esc_html__('Email', 'wpvfr') .
            '</label>';
        $e .= '<input      class="form-control"
                                                                                id="email"
                                                                                type="text"
                                                                                name="email"
                                                                                    placeholder="' . esc_attr__('Enter email', 'wpvfr') . '">';
        $e .= '</div>';
        $e .= '<div class="input-group">';
        $e .= '<label class="label-text" for="username">' .
            esc_html__('Password', 'wpvfr') .
            '</label>';
        $e .= '<input
                                                            class="form-control"
                                                            id="password"
                                                            type="password"
                                                            name="password"
                                                            placeholder="' . esc_attr__('password', 'wpvfr') . '">';

        $e .= '</div>';
        $e .= '<div class="input-group btn-box">';
        $e .= '<button id="wpvfr-register-submit" type="submit" class="btn register submit">' .
            esc_html__('Register', 'wpvfr') . '</button>';
        $e .= '</div>';
        $e .= '</form>';

        $e .= '</div>';
        $e .= '</div>';
        $e .= '</div>';
        $e .= '</div>';
        return $e;
    }

    public function wpvfr_request_form_view($board): string
    {
        $e = null;
        $e .= '<form id="wpvfr-add-feature-req-form" enctype="multipart/form-data">';
        $e .= '<h2>' . esc_html__('Suggest new feature', 'wpvfr') . '</h2>';
        $e .= '<p class="wpvfr-from-msg-status feature-req"></p>';
        $e .= '<div class="input-group">';
        $e .= '<input type="text" name="title" placeholder="' . esc_attr__('Title', 'wpvfr') . '" >';
        $e .= '</div>';
        $e .= '<div class="input-group">';
        $e .= '<textarea rows="9" name="description" id="description" placeholder="' . esc_html__('Why do you want this', 'wpvfr') . '" ></textarea>';
        $e .= '</div>';
        $e .= '<div class="input-group">';
        $e .= '<label for="logourl">' . esc_html__('Logo', 'wpvfr') . '
                </label>';
        $e .= '<div class="logowrap">';
        $e .= '<div class="logo-preview-wraper"></div>';
        $e .= '<span >' . esc_html__('Select Logo', 'wpvfr') . '</span>';
        $e .= '<input class="frb-req-selcet-logo" name="logo" class="logourlinput" type="file">';
        $e .= '</div>';
        $e .= '</div>';
        $e .= '<input type="hidden" name="board" value="' . esc_attr($board->id) . '" id="parent_board_id" />';
        $e .= '<div class="input-group">';
        $e .= '<button type="submit" class="btn">';
        $e .= '<span class="loader"></span>' . esc_html__('Suggest Feature', 'wpvfr');
        $e .= '</button>';
        $e .= '</div>';
        $e .= '</form>';

        return $e;
    }

    public function wpvfr_item_view($board, $item): string
    {
        global $wpdb;
        global $current_user;
        $votes_table = $wpdb->prefix . WPVFR_request_votes;
        $user_table = $wpdb->prefix . 'users';
        $comments_table = $wpdb->prefix . WPVFR_request_comments;

        if (is_user_logged_in() && $current_user->roles[0] == 'administrator') {
            $is_administrator = 'administrator';
        } else {
            $is_administrator = '';
        }

        $comments = array();
        if ($item->comments) {
            $comments = $wpdb->get_results("SELECT c.id,text, u.user_url as user_logo, u.display_name as user_name FROM $comments_table as c
LEFT JOIN 
	(SELECT *  FROM $user_table) as u
ON c.user = u.ID
WHERE c.request_id = " . $item->id);
        }

        $e = null;

        $status = strtolower(str_replace(' ', '-', $item->status));
        if ($item->status == 'inprogress') {
            $status_text = __("In Progress", "wpvfr");
        } elseif ($item->status == 'planned') {
            $status_text = __("Planned", "wpvfr");
        } elseif ($item->status == 'closed') {
            $status_text = __("Closed", "wpvfr");
        } else {
            $status_text = __("Shipped", "wpvfr");
        }
        if ($item->author == $current_user->ID) {
            $is_current_user_loggedin = __(' active', 'wpvfr');
        } else {
            $is_current_user_loggedin = '';
        }

        $checkUserVoted = $wpdb->get_results("SELECT * FROM $votes_table WHERE request_id=$item->id AND user=$current_user->ID");

        $e .= '<div class="wpvfr-request-item' . esc_attr($is_current_user_loggedin) . ' ' . esc_attr($is_administrator) . '" data-name="' . esc_attr($item->title) . '">';

        if ($item->author == $current_user->ID) {
            if ($current_user->roles[0] == 'subscriber') {
                $e .= '<span class="user-action"><a class="edit-feature-request" href="#" data-id="' . esc_attr($item->id) . '">' . esc_html__('Edit', 'wpvfr') . '</a>|<a id="delete-feature-request" href="#" data-id="' . esc_attr($item->id) . '">' . esc_html__('Delete', 'wpvfr') . '</a></span>';
            }
        }

        if (is_user_logged_in()) {
            $notLoggedin = ' ';
            if ($checkUserVoted) {
                $disabled = __(' removeVote ', 'wpvfr');
            } else {
                $disabled = __(' addVote ', 'wpvfr');
            }
        } else {
            $notLoggedin = ' id="wpvfr-login-register-popup" ';
            $disabled = '';
        }
        $e .= '<div ' . $notLoggedin . ' class="wpvfr-request-vote ' . esc_attr($disabled) . '" data-req-id="' . esc_attr($item->id) . '">';
        $e .= '<span class="wpvfr-request-vote-btn"></span>';

        $e .= '<input type="text" value="' . esc_attr("$item->votes") . '" class="wpvfr-request-vote-count" readonly/>';
        $e .= '</div>';
        $e .= '<div class="wpvfr-request-content">';
        $e .= '<h3>';
        $e .= esc_html($item->title);
        $e .= '</h3>';
        if ($item->status) {
            $e .= '<p class="status"><span class="' . esc_attr($status) . '">' . esc_html($status_text) . '</span></p>';
        }
        $e .= '<p class="description">' . esc_html($item->description) . '</p>';
        if ($item->logo) {
            $e .= '<div class="req-log-wraper">';
            $e .= '<img src="' . esc_url($item->logo) . '">';
            $e .= '</div>';
        }

        // comments show
        $e .= '<div class="wpvfr-comment-details ' . $item->id . '">';
        if (count($comments) > 0) {
            foreach ($comments as $comment) {
                $e .= '<div class="wpvfr-comment-wraper">';
                $e .= '<div class="comment-user">';
                $e .= '<div class="comment-user-logo">';
                $e .= '<img src="' . esc_url($comment->user_logo) . '">';
                $e .= '</div>';
                $e .= '<span>' . esc_html__($comment->user_name, 'wpvfr') . '</span>';
                $e .= '</div>';
                $e .= '<p>' . esc_html__($comment->text, 'wpvfr') . '</p>';
                $e .= '</div>';
            }
        }
        $e .= '<button class="btn">' . esc_html__('Add Comment', 'wpvfr') . '</button>';
        $e .= '</div>';

        $e .= '</div>';
        $e .= '<div class="wpvfr-request-comment-count" data-req-id="' . $item->id . '">';
        $e .= '<span class="comment-icon"></span>';
        $e .= '<span class="comment-number" data-comments="' . esc_attr($item->comments) . '">' . esc_html("$item->comments") . '</span>';
        $e .= '</div>';
        $e .= '</div>';
        return $e;
    }

    public  function wpvfr_request_comment($req_id): string
    {
        $e = null;
        $e .= '<form id="">';

        $e .= "</form>";
        return $e;
    }
}
