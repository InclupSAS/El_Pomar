<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function el_pomar_create_applicants_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'el_pomar_applicants';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        first_name varchar(255) NOT NULL,
        last_name varchar(255) NOT NULL,
        document_type varchar(10) NOT NULL,
        document_number varchar(50) NOT NULL,
        phone varchar(20) NOT NULL,
        city varchar(100) NOT NULL,
        neighborhood varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        desired_position varchar(255) NOT NULL,
        salary_expectation varchar(50) NOT NULL,
        why_join text NOT NULL,
        cv varchar(255) NOT NULL,
        terms tinyint(1) NOT NULL,
        post_id mediumint(9) NOT NULL,
        date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function el_pomar_register_applicant() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'el_pomar_applicants';

    $data = array(
        'first_name' => sanitize_text_field($_POST['first_name']),
        'last_name' => sanitize_text_field($_POST['last_name']),
        'document_type' => sanitize_text_field($_POST['document_type']),
        'document_number' => sanitize_text_field($_POST['document_number']),
        'phone' => sanitize_text_field($_POST['phone']),
        'city' => sanitize_text_field($_POST['city']),
        'neighborhood' => sanitize_text_field($_POST['neighborhood']),
        'email' => sanitize_email($_POST['email']),
        'desired_position' => sanitize_text_field($_POST['desired_position']),
        'salary_expectation' => sanitize_text_field($_POST['salary_expectation']),
        'why_join' => sanitize_textarea_field($_POST['why_join']),
        'cv' => sanitize_text_field($_FILES['cv']['name']),
        'terms' => intval($_POST['terms']),
        'post_id' => intval($_POST['post_id']),
        'date' => current_time('mysql')
    );

   
    $upload_dir = WP_PLUGIN_DIR . '/el_pomar/uploads';
    $date_folder = date('Y-m-d'); 
    $target_dir = $upload_dir . '/' . $date_folder;

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $file_extension = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
    $new_filename = $data['first_name'] . '_' . $data['last_name'] . '_' . time() . '.' . $file_extension;
    $target_file = $target_dir . '/' . $new_filename;

    if (move_uploaded_file($_FILES['cv']['tmp_name'], $target_file)) {
        $data['cv'] = plugin_dir_url(__FILE__) . 'uploads/' . $date_folder . '/' . $new_filename;
    } else {
        wp_send_json_error(array('message' => 'Error al subir el archivo.'));
    }

    $wpdb->insert($table_name, $data);

    if ($wpdb->last_error) {
        wp_send_json_error(array('message' => $wpdb->last_error));
    }

    el_pomar_send_emails($data);

    wp_send_json_success('Application submitted successfully');
}

function el_pomar_send_emails($data) {
    $use_custom_email = get_option('el_pomar_use_admin_email');
    $custom_email = get_option('el_pomar_custom_email');
    $admin_email = get_option('admin_email');
    
    $recipient_email = (!$use_custom_email) ? $admin_email : $custom_email;

    $subject_admin = 'Nueva postulación recibida';
    $message_admin = 'Se ha recibido una nueva postulación para el cargo de ' . $data['desired_position'] . ".\n\n";
    $message_admin .= "Detalles del postulante:\n";
    $message_admin .= "Nombres: " . $data['first_name'] . "\n";
    $message_admin .= "Apellidos: " . $data['last_name'] . "\n";
    $message_admin .= "Tipo de Documento: " . $data['document_type'] . "\n";
    $message_admin .= "No. Documento: " . $data['document_number'] . "\n";
    $message_admin .= "Celular: " . $data['phone'] . "\n";
    $message_admin .= "Ciudad: " . $data['city'] . "\n";
    $message_admin .= "Barrio: " . $data['neighborhood'] . "\n";
    $message_admin .= "Correo Electrónico: " . $data['email'] . "\n";
    $message_admin .= "Cargo que aspira: " . $data['desired_position'] . "\n";
    $message_admin .= "Aspiración salarial: " . $data['salary_expectation'] . "\n";
    $message_admin .= "¿Porqué te gustaría ser parte de nuestro equipo?: " . $data['why_join'] . "\n";
    $message_admin .= "Hoja de vida: " . $data['cv'] . "\n";

    wp_mail($recipient_email, $subject_admin, $message_admin);

    $subject_applicant = 'Confirmación de postulación';
    $email_body = get_option('el_pomar_email_body');
    $message_applicant = str_replace(
        array('{desired_position}', '{first_name}', '{last_name}', '{document_type}', '{document_number}', '{phone}', '{city}', '{neighborhood}', '{email}', '{salary_expectation}', '{why_join}'),
        array($data['desired_position'], $data['first_name'], $data['last_name'], $data['document_type'], $data['document_number'], $data['phone'], $data['city'], $data['neighborhood'], $data['email'], $data['salary_expectation'], $data['why_join']),
        $email_body
    );

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_option('blogname') . ' <' . $recipient_email . '>'
    );

    wp_mail($data['email'], $subject_applicant, $message_applicant, $headers);
}

function el_pomar_delete_old_files() {
    $retention_days = get_option('el_pomar_file_retention_days', 10);
    $upload_dir = WP_PLUGIN_DIR . '/el_pomar/uploads';
    $folders = glob($upload_dir . '/*', GLOB_ONLYDIR);

    foreach ($folders as $folder) {
        if (is_dir($folder)) {
            $folder_date = basename($folder);
            $folder_time = strtotime($folder_date); 
            if ($folder_time < strtotime('-' . $retention_days . ' days')) {
                array_map('unlink', glob("$folder/*.*"));
                rmdir($folder);
            }
        }
    }
}

if (!function_exists('el_pomar_delete_applicant')) {
    function el_pomar_delete_applicant($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'el_pomar_applicants';


        $applicant = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

        if ($applicant) {

            $cv_path = str_replace(plugin_dir_url(__FILE__), WP_PLUGIN_DIR . '/', $applicant->cv);
            if (file_exists($cv_path)) {
                unlink($cv_path);
            }
            $wpdb->delete($table_name, array('id' => $id));
        }
    }
}


if (!wp_next_scheduled('el_pomar_delete_old_files_event')) {
    wp_schedule_event(time(), 'daily', 'el_pomar_delete_old_files_event');
}

add_action('el_pomar_delete_old_files_event', 'el_pomar_delete_old_files');

add_action('wp_ajax_nopriv_el_pomar_submit_application', 'el_pomar_register_applicant');
add_action('wp_ajax_el_pomar_submit_application', 'el_pomar_register_applicant');