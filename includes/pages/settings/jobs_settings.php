<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function el_pomar_jobs_settings_page() {
    ?>
    <form method="post" action="options.php">
        <?php
        settings_fields('el_pomar_jobs_settings_group');
        do_settings_sections('el_pomar_jobs_settings');
        submit_button();
        ?>
    </form>

    <h3>Iconos de Categorías</h3>
    <div class="icon-grid">
        <?php
        $categories_icons = glob(EP_PLUGIN_DIR . 'assets/img/jobs/categories/*.svg');
        foreach ($categories_icons as $icon) : ?>
            <div class="icon-item">
                <img src="<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/jobs/categories/' . basename($icon); ?>" alt="<?php echo basename($icon); ?>" style="background:black;">
                <p><?php echo basename($icon); ?></p>
                <div class="icon-actions">
                    <a href="<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/jobs/categories/' . basename($icon); ?>" download>Descargar</a>
                    <a href="#" class="delete-icon" data-icon="<?php echo urlencode(basename($icon)); ?>">Eliminar</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h3>Agregar Nuevo Icono</h3>
    <form id="upload-icon-form" method="post" enctype="multipart/form-data">
        <label for="icon-file">Seleccionar Icono (SVG):</label>
        <input type="file" name="icon-file" id="icon-file" accept=".svg">
        <br><br>
        <input type="submit" name="upload-icon" value="Subir Icono">
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var useAdminEmailCheckbox = document.querySelector('input[name="el_pomar_use_admin_email"]');
            var customEmailContainer = document.getElementById('custom-email-container');

            function toggleCustomEmailContainer() {
                if (useAdminEmailCheckbox.checked) {
                    customEmailContainer.style.display = 'block';
                } else {
                    customEmailContainer.style.display = 'none';
                }
            }

            useAdminEmailCheckbox.addEventListener('change', toggleCustomEmailContainer);
            toggleCustomEmailContainer();

            function insertAtCursor(myField, myValue) {
                if (document.selection) {
                    myField.focus();
                    var sel = document.selection.createRange();
                    sel.text = myValue;
                } else if (myField.selectionStart || myField.selectionStart === 0) {
                    var startPos = myField.selectionStart;
                    var endPos = myField.selectionEnd;
                    myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);
                } else {
                    myField.value += myValue;
                }
            }

            var emailBodyField = document.querySelector('textarea[name="el_pomar_email_body"]');
            var variableButtons = document.querySelectorAll('.insert-variable-button');

            variableButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var variable = this.getAttribute('data-variable');
                    insertAtCursor(emailBodyField, variable);
                });
            });

            // Manejar la eliminación de iconos
            document.querySelectorAll('.delete-icon').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var iconName = this.getAttribute('data-icon');
                    var data = new FormData();
                    data.append('action', 'delete_icon');
                    data.append('icon_name', iconName);

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
                formData.append('action', 'upload_icon');

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

add_action('wp_ajax_delete_icon', 'el_pomar_delete_icon');
function el_pomar_delete_icon() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error('No tienes permisos para realizar esta acción.');
    }

    if (isset($_POST['icon_name'])) {
        $icon_name = sanitize_text_field($_POST['icon_name']);
        $delete_path = EP_PLUGIN_DIR . 'assets/img/jobs/categories/' . $icon_name;

        if (file_exists($delete_path)) {
            unlink($delete_path);
            wp_send_json_success();
        } else {
            wp_send_json_error('El icono no existe.');
        }
    } else {
        wp_send_json_error('Nombre del icono no proporcionado.');
    }
}

add_action('wp_ajax_upload_icon', 'el_pomar_upload_icon');
function el_pomar_upload_icon() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error('No tienes permisos para realizar esta acción.');
    }

    if (!empty($_FILES['icon-file']['name'])) {
        $upload_dir = EP_PLUGIN_DIR . 'assets/img/jobs/categories/';
        $uploaded_file = $_FILES['icon-file'];
        $uploaded_file_name = basename($uploaded_file['name']);
        $uploaded_file_path = $upload_dir . $uploaded_file_name;

        if (move_uploaded_file($uploaded_file['tmp_name'], $uploaded_file_path)) {
            wp_send_json_success();
        } else {
            wp_send_json_error('Error al mover el archivo subido.');
        }
    } else {
        wp_send_json_error('No se seleccionó ningún archivo.');
    }
}

class ElPomar_Jobs_Settings {
    public function __construct() {
        add_action('admin_init', array($this, 'register_el_pomar_jobs_settings'));
    }

    public function register_el_pomar_jobs_settings() {
        register_setting('el_pomar_jobs_settings_group', 'el_pomar_use_admin_email');
        register_setting('el_pomar_jobs_settings_group', 'el_pomar_custom_email');
        register_setting('el_pomar_jobs_settings_group', 'el_pomar_email_body');
        register_setting('el_pomar_jobs_settings_group', 'el_pomar_file_retention_days');

        add_settings_section('el_pomar_jobs_settings_section', 'Configuraciones de Ofertas Laborales', null, 'el_pomar_jobs_settings');

        add_settings_field('el_pomar_use_admin_email', '¿Quieres cambiar el correo de recepción de postulaciones?', array($this, 'el_pomar_use_admin_email_callback'), 'el_pomar_jobs_settings', 'el_pomar_jobs_settings_section');
        add_settings_field('el_pomar_custom_email', '', array($this, 'el_pomar_custom_email_callback'), 'el_pomar_jobs_settings', 'el_pomar_jobs_settings_section');
        add_settings_field('el_pomar_email_body', 'Este es el correo que recibe el postulante', array($this, 'el_pomar_email_body_callback'), 'el_pomar_jobs_settings', 'el_pomar_jobs_settings_section');
        add_settings_field('el_pomar_file_retention_days', 'Días de Retención de Archivos', array($this, 'el_pomar_file_retention_days_callback'), 'el_pomar_jobs_settings', 'el_pomar_jobs_settings_section');
    }

    public function el_pomar_use_admin_email_callback() {
        $option = get_option('el_pomar_use_admin_email');
        echo '<input type="checkbox" name="el_pomar_use_admin_email" value="1"' . checked(1, $option, false) . '>';
    }

    public function el_pomar_custom_email_callback() {
        $option = get_option('el_pomar_custom_email');
        echo '<div id="custom-email-container" style="display:none; margin-left: 10px;">';
        echo '<label for="el_pomar_custom_email"></label>';
        echo '<input type="email" name="el_pomar_custom_email" value="' . esc_attr($option) . '" class="regular-text">';
        echo '</div>';
    }

    public function el_pomar_email_body_callback() {
        $option = get_option('el_pomar_email_body', 'Gracias por postularte para el cargo de {desired_position}. Hemos recibido tu postulación y nos pondremos en contacto contigo pronto.');
        echo '<textarea name="el_pomar_email_body" rows="10" cols="50" class="large-text">' . esc_textarea($option) . '</textarea>';
        echo '<p>Variables disponibles:</p>';
        echo '<button type="button" class="insert-variable-button" data-variable="{desired_position}">Cargo</button>';
        echo '<button type="button" class="insert-variable-button" data-variable="{first_name}">Nombres</button>';
        echo '<button type="button" class="insert-variable-button" data-variable="{last_name}">Apellidos</button>';
        echo '<button type="button" class="insert-variable-button" data-variable="{document_type}">Tipo de Documento</button>';
        echo '<button type="button" class="insert-variable-button" data-variable="{document_number}">Número de Documento</button>';
        echo '<button type="button" class="insert-variable-button" data-variable="{phone}">Celular</button>';
        echo '<button type="button" class="insert-variable-button" data-variable="{city}">Ciudad</button>';
        echo '<button type="button" class="insert-variable-button" data-variable="{neighborhood}">Barrio</button>';
        echo '<button type="button" class="insert-variable-button" data-variable="{email}">Correo Electrónico</button>';
        echo '<button type="button" class="insert-variable-button" data-variable="{salary_expectation}">Aspiración Salarial</button>';
        echo '<button type="button" class="insert-variable-button" data-variable="{why_join}">¿Por qué te gustaría ser parte de nuestro equipo?</button>';
    }

    public function el_pomar_file_retention_days_callback() {
        $option = get_option('el_pomar_file_retention_days', 10);
        echo '<input type="number" name="el_pomar_file_retention_days" value="' . esc_attr($option) . '" class="small-text"> días';
    }
}

new ElPomar_Jobs_Settings();