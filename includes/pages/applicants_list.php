<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

// 1. Mover la definición de la función antes de su uso
if (!function_exists('el_pomar_download_csv_applicants')) {
    function el_pomar_download_csv_applicants() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'el_pomar_applicants';
        $applicants = $wpdb->get_results("SELECT * FROM $table_name");

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment;filename=postulaciones.csv');
        echo "\xEF\xBB\xBF"; // Añadir BOM para UTF-8

        $output = fopen('php://output', 'w');
        fputcsv($output, array('Nombres', 'Apellidos', 'Tipo de Documento', 'Número de Documento', 'Celular', 'Ciudad', 'Barrio', 'Correo Electrónico', 'Cargo', 'Hoja de vida', 'Fecha de postulacion'));

        foreach ($applicants as $applicant) {
            fputcsv($output, array(
                $applicant->first_name,
                $applicant->last_name,
                $applicant->document_type,
                $applicant->document_number,
                $applicant->phone,
                $applicant->city,
                $applicant->neighborhood,
                $applicant->email,
                $applicant->desired_position,
                $applicant->cv,
                $applicant->date
            ));
        }

        fclose($output);
        exit();
    }
}

// 2. Modificar el manejo del POST para usar add_action
add_action('admin_init', 'handle_csv_download_applicants');

function handle_csv_download_applicants() {
    if (isset($_POST['action']) && $_POST['action'] == 'download_csv_applicants') {
        el_pomar_download_csv_applicants();
    }
}

// 3. El resto del código de applicants_list.php permanece igual
function el_pomar_applicants_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'el_pomar_applicants';
    $jobs = get_posts(array('post_type' => 'jobs', 'numberposts' => -1));
    $selected_job = isset($_GET['job']) ? intval($_GET['job']) : 0;

    $query = "SELECT * FROM $table_name";
    if ($selected_job) {
        $query .= $wpdb->prepare(" WHERE post_id = %d", $selected_job);
    }
    $applicants = $wpdb->get_results($query);

    ?>
    <div id="el-pomar-applicants" class="wrap">
        <h1>Postulaciones</h1>
        <form method="get" action="">
            <input type="hidden" name="page" value="el_pomar_applicants">
            <select name="job">
                <option value="">Todos los Trabajos</option>
                <?php foreach ($jobs as $job) { ?>
                    <option value="<?php echo esc_attr($job->ID); ?>" <?php selected($selected_job, $job->ID); ?>>
                        <?php echo esc_html($job->post_title); ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>
        <form method="post" action="" class="downloadBTN">
            <input type="hidden" name="action" value="download_csv_applicants">
            <button type="submit">Descargar CSV</button>
        </form>
        <form method="post" action="" class="deleteBTN">
            <input type="hidden" name="action" value="delete_applicants">
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Tipo de Documento</th>
                        <th>Número de Documento</th>
                        <th>Celular</th>
                        <th>Ciudad</th>
                        <th>Barrio</th>
                        <th>Correo Electrónico</th>
                        <th>Cargo</th>
                        <th>Fecha</th>
                        <th>CV</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applicants as $applicant) { ?>
                        <tr>
                            <td><input type="checkbox" name="applicant_ids[]" value="<?php echo esc_attr($applicant->id); ?>"></td>
                            <td><?php echo esc_html($applicant->first_name); ?></td>
                            <td><?php echo esc_html($applicant->last_name); ?></td>
                            <td><?php echo esc_html($applicant->document_type); ?></td>
                            <td><?php echo esc_html($applicant->document_number); ?></td>
                            <td><?php echo esc_html($applicant->phone); ?></td>
                            <td><?php echo esc_html($applicant->city); ?></td>
                            <td><?php echo esc_html($applicant->neighborhood); ?></td>
                            <td><?php echo esc_html($applicant->email); ?></td>
                            <td><?php echo esc_html($applicant->desired_position); ?></td>
                            <td><?php echo esc_html($applicant->date); ?></td>
                            <td><a href="<?php echo esc_url($applicant->cv); ?>" target="_blank">Descargar</a></td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=el_pomar_applicants&action=delete_applicant&id=' . $applicant->id); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta postulación?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit">Eliminar Seleccionados</button>
        </form>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('select-all').addEventListener('click', function(event) {
            var checkboxes = document.querySelectorAll('input[name="applicant_ids[]"]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = event.target.checked;
            }
        });
    });
    </script>
    <?php
}

if (isset($_POST['action']) && $_POST['action'] == 'delete_applicants') {
    el_pomar_delete_applicants();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete_applicant' && isset($_GET['id'])) {
    el_pomar_delete_applicant(intval($_GET['id']));
}

if (!function_exists('el_pomar_delete_applicants')) {
    function el_pomar_delete_applicants() {
        if (isset($_POST['applicant_ids']) && is_array($_POST['applicant_ids'])) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'el_pomar_applicants';
            $applicant_ids = array_map('intval', $_POST['applicant_ids']);
            $ids = implode(',', $applicant_ids);

            foreach ($applicant_ids as $id) {
                el_pomar_delete_applicant($id);
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