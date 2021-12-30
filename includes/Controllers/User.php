<?php

namespace Elias\Wpvfr\Controllers;

class User{

    public function wpvfr_user_register()
    {
        //check nonce, if it fails return
        if (!wp_verify_nonce($_POST['nonce'], WPVFR_NONCE)) {
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

        // get user data for register
        $data = array();
        $data['user_login'] = sanitize_user($_POST['username']);
        $data['user_pass'] = sanitize_text_field($_POST['password']);
        $data['display_name'] = sanitize_text_field($_POST['display_name']);
        $data['user_email'] = sanitize_email($_POST['email']);

        // user data validation
        if (empty($data['display_name'])) {
            //display name empty
            $error = true;
            $errors['display_name'] = 'Enter a Display Name.';
        }

        if (empty($data['user_login'])) {
            //username name empty
            $error = true;
            $errors['username'] = 'Enter a username.';
        }

        if ($data['user_login'] == trim($data['user_login']) && strpos($data['user_login'], ' ') !== false) {
            //username contains space
            $error = true;
            $errors['username'] = 'Enter a valid username (without space).';
        }

        if (!is_email($data['user_email'])) {
            //email is not valid
            $error = true;
            $errors['email'] = 'Enter a valid email address!';
        }
        if (empty($data['user_pass'])) {
            //password empty
            $error = true;
            $errors['password'] = "Password can't blank.";
        }
        if (!empty($data['user_pass']) && !(strlen($data['user_pass']) > 3)) {
            //short password
            $error = true;
            $errors['password'] = "Password minimum 4 character long.";
        }

        // check error and send response
        if ($error) {
            wp_send_json_error($errors, 403);
            wp_die();
        }

        // register user
        $register_user = wp_insert_user($data);

        //check error in register
        if (is_wp_error($register_user)) {
            $error = $register_user->get_error_code();
            if($error === 'existing_user_login'){
                //username exist
                $errors['username'] = 'Username already exist! Try another username.';
            }
            if($error === 'existing_user_email'){
                //email exist
                $errors['email'] = 'Email already exist! Try another email.';
            }
            wp_send_json_error($errors, 409);
        } else {
            wp_send_json_success($register_user, 200);
        }
        wp_die();
    }

    public function wpvfr_user_login(){
        //check nonce, if it fails return
        if (!wp_verify_nonce($_POST['nonce'], WPVFR_NONCE)) {
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

        // get user data for register
        $data = array();
        $data['user_login'] = sanitize_user($_POST['username']);
        $data['user_password'] = sanitize_text_field($_POST['password']);

        if (empty($data['user_login'])) {
            //username name empty
            $error = true;
            $errors['username'] = 'Enter a username.';
        }
        if ($data['user_login'] == trim($data['user_login']) && strpos($data['user_login'], ' ') !== false) {
            //username contains space
            $error = true;
            $errors['username'] = 'Enter a valid username (without space).';
        }
        if (empty($data['user_password'])) {
            //password empty
            $error = true;
            $errors['password'] = "Password can't blank.";
        }
        if (!empty($data['user_password']) && !(strlen($data['user_password']) > 3)) {
            //short password
            $error = true;
            $errors['password'] = "Password minimum 4 character long.";
        }

        // check error and send response
        if ($error) {
            wp_send_json_error($errors, 403);
            wp_die();
        }

        // register user
        $login_user = wp_signon($data);

        //check error in register
        if (is_wp_error($login_user)) {
            $error = $login_user->get_error_code();
            if($error === 'invalid_username'){
                $errors['username']='Username incorrect. User not found.';
            }
            if($error === 'incorrect_password'){
                $errors['password']='Password incorrect.';
            }
            wp_send_json_error($errors, 409);
        } else {
            wp_send_json_success($login_user, 200);
        }
        wp_die();
    }
}