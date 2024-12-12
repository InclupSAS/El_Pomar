<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!function_exists('el_pomar_create_form_table')) {
    function el_pomar_create_form_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'el_pomar_form_submissions';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            phone varchar(20) NOT NULL,
            email varchar(255) NOT NULL,
            recipe_id bigint(20) NOT NULL,
            submission_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    register_activation_hook(__FILE__, 'el_pomar_create_form_table');
}

if (!function_exists('el_pomar_handle_form_submission')) {
    function el_pomar_handle_form_submission() {
        if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['recipe_id'])) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'el_pomar_form_submissions';

            $name = sanitize_text_field($_POST['name']);
            $phone = sanitize_text_field($_POST['phone']);
            $email = sanitize_email($_POST['email']);
            $recipe_id = intval($_POST['recipe_id']);

            $result = $wpdb->insert(
                $table_name,
                array(
                    'name' => $name,
                    'phone' => $phone,
                    'email' => $email,
                    'recipe_id' => $recipe_id,
                    'submission_date' => current_time('mysql')
                )
            );

            if ($result === false) {
                wp_send_json_error(array('message' => $wpdb->last_error));
            }

            wp_send_json_success('Formulario enviado correctamente.');
        } else {
            wp_send_json_error('Faltan datos en el formulario.');
        }
    }
    add_action('wp_ajax_el_pomar_handle_form_submission', 'el_pomar_handle_form_submission');
    add_action('wp_ajax_nopriv_el_pomar_handle_form_submission', 'el_pomar_handle_form_submission');
}