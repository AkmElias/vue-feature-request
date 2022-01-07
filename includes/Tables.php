<?php

namespace Elias\Wpvfr;

class Tables{

    /**
     * @return tables
     */
    public function wpvfr_create_tables(){
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $wpvfr_users_table = $wpdb->prefix . "users";

        //vue feature request board table
        $wpvfr_request_board_table = $wpdb->prefix. WPVFR_request_board;
        $sql_request_board = "CREATE TABLE IF NOT EXISTS $wpvfr_request_board_table(
          id INT NOT NULL AUTO_INCREMENT,
          title TEXT NOT NULL,
          logo TEXT NOT NULL,
          sort_by TEXT NOT NULL,
          creatorId BIGINT(20) unsigned,
          visibility INT NOT NULL,
          FOREIGN KEY (creatorId) REFERENCES $wpvfr_users_table(id),
          PRIMARY KEY (id)
        ) $charset_collate;";

        //vue feature request list table
        $wpvfr_request_list_table = $wpdb->prefix. WPVFR_request_list;
        $sql_request_list = "CREATE TABLE IF NOT EXISTS $wpvfr_request_list_table(
            id INT NOT NULL AUTO_INCREMENT,
            author BIGINT(20) unsigned,
            board_id INT NOT NULL,
            title TEXT NOT NULL,
            description TEXT NOT NULL,
            logo TEXT NOT NULL,
            status TEXT NOT NULL,
            FOREIGN KEY (author) REFERENCES $wpvfr_users_table(id),
            FOREIGN KEY (board_id) REFERENCES $wpvfr_request_board_table(id),
            PRIMARY KEY (id)
        ) $charset_collate;";

        //vue feature request comments table
        $wpvfr_request_comment_table = $wpdb->prefix. WPVFR_request_comments;
        $sql_request_comments = "CREATE TABLE IF NOT EXISTS $wpvfr_request_comment_table(
            id INT NOT NULL AUTO_INCREMENT,
            user BIGINT(20) unsigned,
            request_id INT NOT NULL,
            text TEXT NOT NULL,
            FOREIGN KEY (user) REFERENCES $wpvfr_users_table(id),
            FOREIGN KEY (request_id) REFERENCES $wpvfr_request_list_table(id),
            PRIMARY KEY (id)
        ) $charset_collate;";

        //vue feature request votes tables
        $wpvfr_request_votes_table = $wpdb->prefix. WPVFR_request_votes;
        $sql_request_votes = "CREATE TABLE IF NOT EXISTS $wpvfr_request_votes_table(
            id INT NOT NULL AUTO_INCREMENT,
            user BIGINT(20) unsigned,
            request_id INT NOT NULL,
            FOREIGN KEY (user) REFERENCES $wpvfr_users_table(id),
            FOREIGN KEY (request_id) REFERENCES $wpvfr_request_list_table(id),
            PRIMARY KEY (id)
        )";

        //vue feature request comment reply table
        $wpvfr_request_comment_reply_table  = $wpdb->prefix. WPVFR_request_comment_reply;
        $sql_request_comment_reply = "CREATE TABLE IF NOT EXISTS $wpvfr_request_comment_reply_table(
            id INT NOT NULL AUTO_INCREMENT,
            user BIGINT(20) unsigned,
            comment_id INT NOT NULL,
            text TEXT NOT NULL,
            FOREIGN KEY (user) REFERENCES $wpvfr_users_table(id),
            FOREIGN KEY (comment_id) REFERENCES $wpvfr_request_comment_table(id),
            PRIMARY KEY (id)

        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql_request_board );
        dbDelta( $sql_request_list);
        dbDelta( $sql_request_comments);
        dbDelta( $sql_request_comment_reply);
        dbDelta( $sql_request_votes);
    }
}