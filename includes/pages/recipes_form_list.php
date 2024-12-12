<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

// 1. Mover la definición de la función antes de su uso
if (!function_exists('el_pomar_download_csv_recipes')) {
    function el_pomar_download_csv_recipes() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'el_pomar_form_submissions';
        $submissions = $wpdb->get_results("SELECT * FROM $table_name");

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment;filename=interacciones_recetas.csv');
        echo "\xEF\xBB\xBF"; // Añadir BOM para UTF-8

        $output = fopen('php://output', 'w');
        fputcsv($output, array('Nombre', 'Teléfono', 'Email', 'Receta', 'Fecha de Envío'));

        foreach ($submissions as $submission) {
            fputcsv($output, array(
                $submission->name,
                $submission->phone,
                $submission->email,
                get_the_title($submission->recipe_id),
                $submission->submission_date
            ));
        }

        fclose($output);
        exit();
    }
}

// 2. Modificar el manejo del POST para usar add_action
add_action('admin_init', 'handle_csv_download');

function handle_csv_download() {
    if (isset($_POST['action']) && $_POST['action'] == 'download_csv_recipes') {
        el_pomar_download_csv_recipes();
    }
}

// 3. El resto del código de recipes_form_list.php permanece igual
function el_pomar_form_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'el_pomar_form_submissions';
    $recipes = get_posts(array('post_type' => 'recipes', 'numberposts' => -1));
    $selected_recipe = isset($_GET['recipe']) ? intval($_GET['recipe']) : 0;

    $query = "SELECT * FROM $table_name";
    if ($selected_recipe) {
        $query .= $wpdb->prepare(" WHERE recipe_id = %d", $selected_recipe);
    }
    $submissions = $wpdb->get_results($query);

    ?>
    <div id="el-pomar-form-submissions" class="wrap">
        <h1>Interacciones de Recetas</h1>
        <form method="get" action="">
            <input type="hidden" name="page" value="el_pomar_form_submissions">
            <select name="recipe">
                <option value="">Todas las Recetas</option>
                <?php foreach ($recipes as $recipe) { ?>
                    <option value="<?php echo esc_attr($recipe->ID); ?>" <?php selected($selected_recipe, $recipe->ID); ?>>
                        <?php echo esc_html($recipe->post_title); ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>
        <form method="post" action="" class="downloadBTN">
            <input type="hidden" name="action" value="download_csv_recipes">
            <button type="submit">Descargar CSV</button>
        </form>
        <form method="post" action="" class="deleteBTN">
            <input type="hidden" name="action" value="delete_submissions">
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Receta</th>
                        <th>Fecha de Envío</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission) { ?>
                        <tr>
                            <td><input type="checkbox" name="submission_ids[]" value="<?php echo esc_attr($submission->id); ?>"></td>
                            <td><?php echo esc_html($submission->name); ?></td>
                            <td><?php echo esc_html($submission->phone); ?></td>
                            <td><?php echo esc_html($submission->email); ?></td>
                            <td><?php echo esc_html(get_the_title($submission->recipe_id)); ?></td>
                            <td><?php echo esc_html($submission->submission_date); ?></td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=el_pomar_form_submissions&action=delete_submission&id=' . $submission->id); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta interacción?');">Eliminar</a>
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
            var checkboxes = document.querySelectorAll('input[name="submission_ids[]"]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = event.target.checked;
            }
        });
    });
    </script>
    <?php
}

if (isset($_POST['action']) && $_POST['action'] == 'delete_submissions') {
    el_pomar_delete_submissions();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete_submission' && isset($_GET['id'])) {
    el_pomar_delete_submission(intval($_GET['id']));
}

if (!function_exists('el_pomar_delete_submissions')) {
    function el_pomar_delete_submissions() {
        if (isset($_POST['submission_ids']) && is_array($_POST['submission_ids'])) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'el_pomar_form_submissions';
            $submission_ids = array_map('intval', $_POST['submission_ids']);
            $ids = implode(',', $submission_ids);

            foreach ($submission_ids as $id) {
                el_pomar_delete_submission($id);
            }
        }
    }
}

if (!function_exists('el_pomar_delete_submission')) {
    function el_pomar_delete_submission($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'el_pomar_form_submissions';

        $wpdb->delete($table_name, array('id' => $id));
    }
}