<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function Pomar_core_catalog_settings_page() {
    ?>
    <div>
        <p>Carga, elimina o descarga los iconos de categorías o beneficios del portafolio de productos El Pomar.</p>

        <h3>Iconos de Categorías</h3>
        <div class="icon-grid">
            <?php
            $categories_icons = glob(EP_PLUGIN_DIR . 'assets/img/catalog/categories/*.svg');
            foreach ($categories_icons as $icon) : ?>
                <div class="icon-item">
                    <img src="<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/categories/' . basename($icon); ?>" alt="<?php echo basename($icon); ?>" style="background:black;">
                    <p><?php echo basename($icon); ?></p>
                    <div class="icon-actions">
                        <a href="<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/categories/' . basename($icon); ?>" download>Descargar</a>
                        <a href="#" class="delete-icon" data-icon="<?php echo urlencode(basename($icon)); ?>" data-type="categories">Eliminar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h3>Iconos Beneficios</h3>
        <div class="icon-grid">
            <?php
            $icons = glob(EP_PLUGIN_DIR . 'assets/img/catalog/icons/*.svg');
            foreach ($icons as $icon) : ?>
                <div class="icon-item">
                    <img src="<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/icons/' . basename($icon); ?>" alt="<?php echo basename($icon); ?>" style="filter:invert(1);">
                    <p><?php echo basename($icon); ?></p>
                    <div class="icon-actions">
                        <a href="<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/icons/' . basename($icon); ?>" download>Descargar</a>
                        <a href="#" class="delete-icon" data-icon="<?php echo urlencode(basename($icon)); ?>" data-type="icons">Eliminar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h3>Agregar Nuevo Icono</h3>
        <form id="upload-icon-form" method="post" enctype="multipart/form-data">
            <label for="icon-type">Tipo de Icono:</label>
            <select name="icon-type" id="icon-type">
                <option value="categories">Categorías</option>
                <option value="icons">Beneficios</option>
            </select>
            <br><br>
            <label for="icon-file">Seleccionar Icono (SVG):</label>
            <input type="file" name="icon-file" id="icon-file" accept=".svg">
            <br><br>
            <input type="submit" name="upload-icon" value="Subir Icono">
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejar la eliminación de iconos
            document.querySelectorAll('.delete-icon').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var iconName = this.getAttribute('data-icon');
                    var iconType = this.getAttribute('data-type');
                    var data = new FormData();
                    data.append('action', 'delete_catalog_icon');
                    data.append('icon_name', iconName);
                    data.append('icon_type', iconType);

                    fetch(ajaxurl, {
                        method: 'POST',
                        body: data,
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            location.reload();
                        } else {
                            alert('Error al eliminar el icono.');
                        }
                    });
                });
            });

            // Manejar la subida de iconos
            document.getElementById('upload-icon-form').addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                formData.append('action', 'upload_catalog_icon');

                fetch(ajaxurl, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        location.reload();
                    } else {
                        alert('Error al subir el icono.');
                    }
                });
            });
        });
    </script>
    <?php
}

add_action('wp_ajax_delete_catalog_icon', 'el_pomar_delete_catalog_icon');
function el_pomar_delete_catalog_icon() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error('No tienes permisos para realizar esta acción.');
    }

    if (isset($_POST['icon_name']) && isset($_POST['icon_type'])) {
        $icon_name = sanitize_text_field($_POST['icon_name']);
        $icon_type = sanitize_text_field($_POST['icon_type']);
        $delete_dir = ($icon_type === 'categories') ? EP_PLUGIN_DIR . 'assets/img/catalog/categories/' : EP_PLUGIN_DIR . 'assets/img/catalog/icons/';
        $delete_path = $delete_dir . $icon_name;

        if (file_exists($delete_path)) {
            unlink($delete_path);
            wp_send_json_success();
        } else {
            wp_send_json_error('El icono no existe.');
        }
    } else {
        wp_send_json_error('Nombre del icono o tipo no proporcionado.');
    }
}

add_action('wp_ajax_upload_catalog_icon', 'el_pomar_upload_catalog_icon');
function el_pomar_upload_catalog_icon() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error('No tienes permisos para realizar esta acción.');
    }

    if (!empty($_FILES['icon-file']['name']) && isset($_POST['icon-type'])) {
        $icon_type = sanitize_text_field($_POST['icon-type']);
        $upload_dir = ($icon_type === 'categories') ? EP_PLUGIN_DIR . 'assets/img/catalog/categories/' : EP_PLUGIN_DIR . 'assets/img/catalog/icons/';
        $uploaded_file = $_FILES['icon-file'];
        $uploaded_file_name = basename($uploaded_file['name']);
        $uploaded_file_path = $upload_dir . $uploaded_file_name;

        if (move_uploaded_file($uploaded_file['tmp_name'], $uploaded_file_path)) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Error al mover el archivo subido.');
        }
    } else {
        wp_send_json_error('No se seleccionó ningún archivo o tipo de icono.');
    }
}

add_action('admin_menu', function() {
    add_menu_page('Configuración del Catálogo', 'Configuración del Catálogo', 'manage_options', 'el-pomar-catalog-settings', 'Pomar_core_catalog_settings_page');
});