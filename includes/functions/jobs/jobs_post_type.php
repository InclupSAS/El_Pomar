<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function el_pomar_register_jobs_post_type() {
    $labels = array(
        'name'                  => _x('Ofertas Laborales', 'Post type general name', 'el_pomar'),
        'singular_name'         => _x('Oferta Laboral', 'Post type singular name', 'el_pomar'),
        'menu_name'             => _x('Ofertas Laborales', 'Admin Menu text', 'el_pomar'),
        'name_admin_bar'        => _x('Oferta Laboral', 'Add New on Toolbar', 'el_pomar'),
        'add_new'               => __('Añadir Nueva', 'el_pomar'),
        'add_new_item'          => __('Añadir Nueva Oferta Laboral', 'el_pomar'),
        'new_item'              => __('Nueva Oferta Laboral', 'el_pomar'),
        'edit_item'             => __('Editar Oferta Laboral', 'el_pomar'),
        'view_item'             => __('Ver Oferta Laboral', 'el_pomar'),
        'all_items'             => __('Todas las Ofertas Laborales', 'el_pomar'),
        'search_items'          => __('Buscar Ofertas Laborales', 'el_pomar'),
        'parent_item_colon'     => __('Ofertas Laborales Padre:', 'el_pomar'),
        'not_found'             => __('No se encontraron ofertas laborales.', 'el_pomar'),
        'not_found_in_trash'    => __('No se encontraron ofertas laborales en la papelera.', 'el_pomar'),
        'featured_image'        => _x('Imagen destacada', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'set_featured_image'    => _x('Establecer imagen destacada', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'remove_featured_image' => _x('Eliminar imagen destacada', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'use_featured_image'    => _x('Usar como imagen destacada', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'archives'              => _x('Archivos de ofertas laborales', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'el_pomar'),
        'insert_into_item'      => _x('Insertar en oferta laboral', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'el_pomar'),
        'uploaded_to_this_item' => _x('Subido a esta oferta laboral', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'el_pomar'),
        'filter_items_list'     => _x('Filtrar lista de ofertas laborales', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'el_pomar'),
        'items_list_navigation' => _x('Navegación de lista de ofertas laborales', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'el_pomar'),
        'items_list'            => _x('Lista de ofertas laborales', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'el_pomar'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'jobs'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('jobs', $args);
}

function el_pomar_register_jobs_taxonomies() {
    $labels = array(
        'name'              => _x('Categorías de Ofertas Laborales', 'taxonomy general name', 'el_pomar'),
        'singular_name'     => _x('Categoría de Ofertas Laborales', 'taxonomy singular name', 'el_pomar'),
        'search_items'      => __('Buscar Categorías de Ofertas Laborales', 'el_pomar'),
        'all_items'         => __('Todas las Categorías de Ofertas Laborales', 'el_pomar'),
        'parent_item'       => __('Categoría Padre', 'el_pomar'),
        'parent_item_colon' => __('Categoría Padre:', 'el_pomar'),
        'edit_item'         => __('Editar Categoría de Ofertas Laborales', 'el_pomar'),
        'update_item'       => __('Actualizar Categoría de Ofertas Laborales', 'el_pomar'),
        'add_new_item'      => __('Añadir Nueva Categoría de Ofertas Laborales', 'el_pomar'),
        'new_item_name'     => __('Nuevo Nombre de Categoría de Ofertas Laborales', 'el_pomar'),
        'menu_name'         => __('Categorías de Ofertas Laborales', 'el_pomar'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'job_category'),
    );

    register_taxonomy('job_category', array('jobs'), $args);
}


function el_pomar_add_job_category_custom_fields() {
    $icons = glob(plugin_dir_path(__FILE__) . '../../../assets/img/jobs/categories/*.svg');
    ?>
    <div class="form-field term-group">
        <label for="EP-cat-icon">Icono de la Categoría</label>
        <select name="EP-cat-icon" id="EP-cat-icon" class="postform">
            <?php foreach ($icons as $icon) {
                $icon_filename = basename($icon);
                ?>
                <option value="<?php echo esc_attr($icon_filename); ?>"><?php echo esc_html($icon_filename); ?></option>
            <?php } ?>
        </select>
        <img src="" alt="" class="EP-cat-icon-preview" style="width: 40px; height: 40px; vertical-align: middle; background:black;" />
        <p class="description">Selecciona un icono SVG para la categoría</p>
    </div>
    <div class="form-field term-group">
        <label for="EP-cat-order">Orden de la Categoría</label>
        <input type="number" name="EP-cat-order" id="EP-cat-order" value="0" min="0" />
        <p class="description">Define el orden en que se mostrarán las categorías</p>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateIconPreview() {
                let icon = document.getElementById('EP-cat-icon').value;
                let img = document.querySelector('.EP-cat-icon-preview');
                if (icon) {
                    img.src = '<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/jobs/categories/'; ?>' + icon;
                } else {
                    img.src = '';
                }
            }
            document.getElementById('EP-cat-icon').addEventListener('change', updateIconPreview);
            updateIconPreview();
        });
    </script>
    <?php
}

add_action('job_category_add_form_fields', 'el_pomar_add_job_category_custom_fields', 10, 2);


function el_pomar_edit_job_category_custom_fields($term) {
    $EP_cat_icon = get_term_meta($term->term_id, 'EP-cat-icon', true);
    $EP_cat_order = get_term_meta($term->term_id, 'EP-cat-order', true);
    $icons = glob(plugin_dir_path(__FILE__) . '../../../assets/img/jobs/categories/*.svg');
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="EP-cat-icon">Icono de la Categoría</label></th>
        <td>
            <select name="EP-cat-icon" id="EP-cat-icon" class="postform">
                <?php foreach ($icons as $icon) {
                    $icon_filename = basename($icon);
                    ?>
                    <option value="<?php echo esc_attr($icon_filename); ?>" <?php selected($EP_cat_icon, $icon_filename); ?>><?php echo esc_html($icon_filename); ?></option>
                <?php } ?>
            </select>
            <img src="<?php if ($EP_cat_icon) { echo plugin_dir_url(__FILE__) . '../../../assets/img/jobs/categories/' . esc_attr($EP_cat_icon); } ?>" alt="" class="EP-cat-icon-preview" style="width: 40px; height: 40px; vertical-align: middle; background:black;" />
            <p class="description">Selecciona un icono SVG para la categoría</p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="EP-cat-order">Orden de la Categoría</label></th>
        <td>
            <input type="number" name="EP-cat-order" id="EP-cat-order" value="<?php echo esc_attr($EP_cat_order); ?>" min="0" />
            <p class="description">Define el orden en que se mostrarán las categorías</p>
        </td>
    </tr>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateIconPreview() {
                let icon = document.getElementById('EP-cat-icon').value;
                let img = document.querySelector('.EP-cat-icon-preview');
                if (icon) {
                    img.src = '<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/jobs/categories/'; ?>' + icon;
                } else {
                    img.src = '';
                }
            }
            document.getElementById('EP-cat-icon').addEventListener('change', updateIconPreview);
            updateIconPreview();
        });
    </script>
    <?php
}

add_action('job_category_edit_form_fields', 'el_pomar_edit_job_category_custom_fields', 10, 2);

function el_pomar_save_job_category_custom_fields($term_id) {
    if (isset($_POST['EP-cat-icon'])) {
        update_term_meta($term_id, 'EP-cat-icon', sanitize_text_field($_POST['EP-cat-icon']));
    }
    if (isset($_POST['EP-cat-order'])) {
        update_term_meta($term_id, 'EP-cat-order', sanitize_text_field($_POST['EP-cat-order']));
    }
}

add_action('created_job_category', 'el_pomar_save_job_category_custom_fields', 10, 2);
add_action('edited_job_category', 'el_pomar_save_job_category_custom_fields', 10, 2);

add_action('init', 'el_pomar_register_jobs_post_type');
add_action('init', 'el_pomar_register_jobs_taxonomies');

