<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function el_pomar_register_catalog_post_types() {
    $labels_el_pomar = array(
        'name'                  => _x('El Pomar', 'Post type general name', 'el_pomar'),
        'singular_name'         => _x('El Pomar', 'Post type singular name', 'el_pomar'),
        'menu_name'             => _x('El Pomar', 'Admin Menu text', 'el_pomar'),
        'name_admin_bar'        => _x('El Pomar', 'Add New on Toolbar', 'el_pomar'),
        'add_new'               => __('Añadir Nuevo', 'el_pomar'),
        'add_new_item'          => __('Añadir Nuevo El Pomar', 'el_pomar'),
        'new_item'              => __('Nuevo El Pomar', 'el_pomar'),
        'edit_item'             => __('Editar El Pomar', 'el_pomar'),
        'view_item'             => __('Ver El Pomar', 'el_pomar'),
        'all_items'             => __('Todos los El Pomar', 'el_pomar'),
        'search_items'          => __('Buscar El Pomar', 'el_pomar'),
        'parent_item_colon'     => __('El Pomar Padre:', 'el_pomar'),
        'not_found'             => __('No se encontraron El Pomar.', 'el_pomar'),
        'not_found_in_trash'    => __('No se encontraron El Pomar en la papelera.', 'el_pomar'),
        'featured_image'        => _x('Imagen destacada', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'set_featured_image'    => _x('Establecer imagen destacada', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'remove_featured_image' => _x('Eliminar imagen destacada', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'use_featured_image'    => _x('Usar como imagen destacada', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'archives'              => _x('Archivos de El Pomar', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'el_pomar'),
        'insert_into_item'      => _x('Insertar en El Pomar', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'el_pomar'),
        'uploaded_to_this_item' => _x('Subido a este El Pomar', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'el_pomar'),
        'filter_items_list'     => _x('Filtrar lista de El Pomar', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'el_pomar'),
        'items_list_navigation' => _x('Navegación de lista de El Pomar', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'el_pomar'),
        'items_list'            => _x('Lista de El Pomar', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'el_pomar'),
    );

    $args_el_pomar = array(
        'labels'             => $labels_el_pomar,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'el_pomar'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('el_pomar', $args_el_pomar);

    $labels_mulai = array(
        'name'                  => _x('Mulai', 'Post type general name', 'el_pomar'),
        'singular_name'         => _x('Mulai', 'Post type singular name', 'el_pomar'),
        'menu_name'             => _x('Mulai', 'Admin Menu text', 'el_pomar'),
        'name_admin_bar'        => _x('Mulai', 'Add New on Toolbar', 'el_pomar'),
        'add_new'               => __('Añadir Nuevo', 'el_pomar'),
        'add_new_item'          => __('Añadir Nuevo Mulai', 'el_pomar'),
        'new_item'              => __('Nuevo Mulai', 'el_pomar'),
        'edit_item'             => __('Editar Mulai', 'el_pomar'),
        'view_item'             => __('Ver Mulai', 'el_pomar'),
        'all_items'             => __('Todos los Mulai', 'el_pomar'),
        'search_items'          => __('Buscar Mulai', 'el_pomar'),
        'parent_item_colon'     => __('Mulai Padre:', 'el_pomar'),
        'not_found'             => __('No se encontraron Mulai.', 'el_pomar'),
        'not_found_in_trash'    => __('No se encontraron Mulai en la papelera.', 'el_pomar'),
        'featured_image'        => _x('Imagen destacada', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'set_featured_image'    => _x('Establecer imagen destacada', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'remove_featured_image' => _x('Eliminar imagen destacada', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'use_featured_image'    => _x('Usar como imagen destacada', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'archives'              => _x('Archivos de Mulai', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'el_pomar'),
        'insert_into_item'      => _x('Insertar en Mulai', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'el_pomar'),
        'uploaded_to_this_item' => _x('Subido a este Mulai', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'el_pomar'),
        'filter_items_list'     => _x('Filtrar lista de Mulai', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'el_pomar'),
        'items_list_navigation' => _x('Navegación de lista de Mulai', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'el_pomar'),
        'items_list'            => _x('Lista de Mulai', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'el_pomar'),
    );

    $args_mulai = array(
        'labels'             => $labels_mulai,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'mulai'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('mulai', $args_mulai);

    $labels_levelma = array(
        'name'                  => _x('Levelma', 'Post type general name', 'el_pomar'),
        'singular_name'         => _x('Levelma', 'Post type singular name', 'el_pomar'),
        'menu_name'             => _x('Levelma', 'Admin Menu text', 'el_pomar'),
        'name_admin_bar'        => _x('Levelma', 'Add New on Toolbar', 'el_pomar'),
        'add_new'               => __('Añadir Nuevo', 'el_pomar'),
        'add_new_item'          => __('Añadir Nuevo Levelma', 'el_pomar'),
        'new_item'              => __('Nuevo Levelma', 'el_pomar'),
        'edit_item'             => __('Editar Levelma', 'el_pomar'),
        'view_item'             => __('Ver Levelma', 'el_pomar'),
        'all_items'             => __('Todos los Levelma', 'el_pomar'),
        'search_items'          => __('Buscar Levelma', 'el_pomar'),
        'parent_item_colon'     => __('Levelma Padre:', 'el_pomar'),
        'not_found'             => __('No se encontraron Levelma.', 'el_pomar'),
        'not_found_in_trash'    => __('No se encontraron Levelma en la papelera.', 'el_pomar'),
        'featured_image'        => _x('Imagen destacada', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'set_featured_image'    => _x('Establecer imagen destacada', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'remove_featured_image' => _x('Eliminar imagen destacada', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'use_featured_image'    => _x('Usar como imagen destacada', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'archives'              => _x('Archivos de Levelma', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'el_pomar'),
        'insert_into_item'      => _x('Insertar en Levelma', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'el_pomar'),
        'uploaded_to_this_item' => _x('Subido a este Levelma', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'el_pomar'),
        'filter_items_list'     => _x('Filtrar lista de Levelma', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'el_pomar'),
        'items_list_navigation' => _x('Navegación de lista de Levelma', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'el_pomar'),
        'items_list'            => _x('Lista de Levelma', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'el_pomar'),
    );

    $args_levelma = array(
        'labels'             => $labels_levelma,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'levelma'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('levelma', $args_levelma);
}

function el_pomar_register_catalog_taxonomies() {
    $labels_el_pomar_category = array(
        'name'              => _x('Categorías de El Pomar', 'taxonomy general name', 'el_pomar'),
        'singular_name'     => _x('Categoría de El Pomar', 'taxonomy singular name', 'el_pomar'),
        'search_items'      => __('Buscar Categorías de El Pomar', 'el_pomar'),
        'all_items'         => __('Todas las Categorías de El Pomar', 'el_pomar'),
        'parent_item'       => __('Categoría Padre', 'el_pomar'),
        'parent_item_colon' => __('Categoría Padre:', 'el_pomar'),
        'edit_item'         => __('Editar Categoría de El Pomar', 'el_pomar'),
        'update_item'       => __('Actualizar Categoría de El Pomar', 'el_pomar'),
        'add_new_item'      => __('Añadir Nueva Categoría de El Pomar', 'el_pomar'),
        'new_item_name'     => __('Nuevo Nombre de Categoría de El Pomar', 'el_pomar'),
        'menu_name'         => __('Categorías de El Pomar', 'el_pomar'),
    );

    $args_el_pomar_category = array(
        'hierarchical'      => true,
        'labels'            => $labels_el_pomar_category,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'el_pomar_category'),
    );

    register_taxonomy('el_pomar_category', array('el_pomar'), $args_el_pomar_category);

    $labels_mulai_category = array(
        'name'              => _x('Categorías de Mulai', 'taxonomy general name', 'el_pomar'),
        'singular_name'     => _x('Categoría de Mulai', 'taxonomy singular name', 'el_pomar'),
        'search_items'      => __('Buscar Categorías de Mulai', 'el_pomar'),
        'all_items'         => __('Todas las Categorías de Mulai', 'el_pomar'),
        'parent_item'       => __('Categoría Padre', 'el_pomar'),
        'parent_item_colon' => __('Categoría Padre:', 'el_pomar'),
        'edit_item'         => __('Editar Categoría de Mulai', 'el_pomar'),
        'update_item'       => __('Actualizar Categoría de Mulai', 'el_pomar'),
        'add_new_item'      => __('Añadir Nueva Categoría de Mulai', 'el_pomar'),
        'new_item_name'     => __('Nuevo Nombre de Categoría de Mulai', 'el_pomar'),
        'menu_name'         => __('Categorías de Mulai', 'el_pomar'),
    );

    $args_mulai_category = array(
        'hierarchical'      => true,
        'labels'            => $labels_mulai_category,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'mulai_category'),
    );

    register_taxonomy('mulai_category', array('mulai'), $args_mulai_category);

    $labels_levelma_category = array(
        'name'              => _x('Categorías de Levelma', 'taxonomy general name', 'el_pomar'),
        'singular_name'     => _x('Categoría de Levelma', 'taxonomy singular name', 'el_pomar'),
        'search_items'      => __('Buscar Categorías de Levelma', 'el_pomar'),
        'all_items'         => __('Todas las Categorías de Levelma', 'el_pomar'),
        'parent_item'       => __('Categoría Padre', 'el_pomar'),
        'parent_item_colon' => __('Categoría Padre:', 'el_pomar'),
        'edit_item'         => __('Editar Categoría de Levelma', 'el_pomar'),
        'update_item'       => __('Actualizar Categoría de Levelma', 'el_pomar'),
        'add_new_item'      => __('Añadir Nueva Categoría de Levelma', 'el_pomar'),
        'new_item_name'     => __('Nuevo Nombre de Categoría de Levelma', 'el_pomar'),
        'menu_name'         => __('Categorías de Levelma', 'el_pomar'),
    );

    $args_levelma_category = array(
        'hierarchical'      => true,
        'labels'            => $labels_levelma_category,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'levelma_category'),
    );

    register_taxonomy('levelma_category', array('levelma'), $args_levelma_category);
}

add_action('init', 'el_pomar_register_catalog_post_types');
add_action('init', 'el_pomar_register_catalog_taxonomies');


function Pomar_core_add_meta_boxes() {
    add_meta_box(
        'el_pomar_meta_box',
        'Detalles de El Pomar',
        'Pomar_core_render_meta_box',
        'el_pomar',
        'normal',
        'high'
    );

    add_meta_box(
        'mulai_meta_box',
        'Detalles de Mulai',
        'Pomar_core_render_meta_box',
        'mulai',
        'normal',
        'high'
    );

    add_meta_box(
        'levelma_meta_box',
        'Detalles de Levelma',
        'Pomar_core_render_meta_box',
        'levelma',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'Pomar_core_add_meta_boxes');


function Pomar_core_render_meta_box($post) {
    $benefits = get_post_meta($post->ID, '_benefits', true);
    $presentaciones = get_post_meta($post->ID, '_presentaciones', true);
    $url_tienda = get_post_meta($post->ID, '_url_tienda', true);

    $icons = glob(EP_PLUGIN_DIR . 'assets/img/catalog/icons/*.svg');
    $icon_url_base = plugin_dir_url(__FILE__) . '../../../assets/img/catalog/icons/';

    ?>
    <label for="url_tienda">URL Tienda:</label>
    <input type="url" id="url_tienda" name="url_tienda" value="<?php echo esc_attr($url_tienda); ?>" size="25" />
    <div id="benefits-wrapper" style="margin: 15px 0;">
    <label for="benefits" style="font-weight: 600; line-height: 30px;">Beneficios:</label>
       <?php
    if (!empty($benefits)) {
        foreach ($benefits as $index => $benefit) {
            ?>
            <div class="benefit-item">
                <select name="benefits[icon][]" class="benefit-icon-select" style="width: max-content; height:40px">
                    <?php foreach ($icons as $icon) {
                        $icon_name = basename($icon);
                        ?>
                        <option value="<?php echo esc_attr($icon_name); ?>" <?php selected($benefit['icon'], $icon_name); ?>>
                            <?php echo esc_html($icon_name); ?>
                        </option>
                    <?php } ?>
                </select>
                <img src="<?php echo esc_url($icon_url_base . esc_attr($benefit['icon'])); ?>" alt="<?php echo esc_attr($benefit['icon']); ?>" class="benefit-icon-preview" style="width: 50px; height: 50px; vertical-align: middle; filter: invert();" />
                <input type="text" name="benefits[text][]" value="<?php echo esc_attr($benefit['text']); ?>" style="width: 60%;" placeholder="Beneficio / copy" />
                <button type="button" class="remove-benefit">Eliminar</button>
            </div>
            <?php
        }
    }
    ?>
    </div>
    <button type="button" id="add-benefit">Agregar Beneficio</button>

    <div id="presentaciones-wrapper" style="margin: 15px 0;">
    <label for="presentaciones" style="font-weight: 600; line-height: 30px;">Presentaciones:</label>
       <?php
    if (!empty($presentaciones)) {
        foreach ($presentaciones as $index => $presentacion) {
            ?>
            <div class="presentacion-item">
                <div class="presentation-upload">
                    <img src="<?php echo esc_url($presentacion['image']); ?>" alt="Presentación" class="presentacion-image-preview" style="width: 50px; height: 50px; margin-right: 10px; display: <?php echo esc_url($presentacion['image']) ? 'inline' : 'none'; ?>;" />
                    <input type="file" name="presentaciones[image][]" accept="image/*" onchange="updateImagePreview(this)" style="display: none;" />
                    <button type="button" class="upload-image-button">Subir Imagen</button>
                </div>
                <input type="text" name="presentaciones[text][]" value="<?php echo esc_attr($presentacion['text']); ?>" style="width: 60%;" placeholder="Descripción" />
                <button type="button" class="remove-presentacion">Eliminar</button>
            </div>
            <?php
        }
    }
    ?>
    </div>
    <button type="button" id="add-presentacion">Agregar Presentación</button>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateIconPreview(selectElement) {
                let icon = selectElement.value;
                let img = selectElement.nextElementSibling;
                img.src = '<?php echo esc_url($icon_url_base); ?>' + icon;
            }

            document.querySelectorAll('.benefit-icon-select').forEach(function(selectElement) {
                selectElement.addEventListener('change', function() {
                    updateIconPreview(selectElement);
                });
                updateIconPreview(selectElement);
            });

            document.getElementById('add-benefit').addEventListener('click', function() {
                let wrapper = document.getElementById('benefits-wrapper');
                let newBenefit = document.createElement('div');
                newBenefit.classList.add('benefit-item');
                newBenefit.innerHTML = `
                    <select name="benefits[icon][]" class="benefit-icon-select" style="width: max-content; height:40px">
                    <?php foreach ($icons as $icon) {
                        $icon_name = basename($icon);
                        ?>
                        <option value="<?php echo esc_attr($icon_name); ?>">
                            <?php echo esc_html($icon_name); ?>
                        </option>
                    <?php } ?>
                </select>
                    <img src="<?php echo esc_url($icon_url_base . (!empty($icons) ? basename($icons[0]) : '')); ?>" alt="<?php echo !empty($icons) ? esc_attr(basename($icons[0])) : ''; ?>" class="benefit-icon-preview" style="width: 40px; height: 40px; vertical-align: middle; filter:invert(1)" />
                    <input type="text" name="benefits[text][]" value="" style="width: 75%;" placeholder="Beneficio / copy" />
                    <button type="button" class="remove-benefit">Eliminar</button>
                `;
                wrapper.appendChild(newBenefit);

                let selectElement = newBenefit.querySelector('.benefit-icon-select');
                selectElement.addEventListener('change', function() {
                    updateIconPreview(selectElement);
                });
            });

            document.getElementById('benefits-wrapper').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-benefit')) {
                    e.target.parentElement.remove();
                }
            });

            document.getElementById('add-presentacion').addEventListener('click', function() {
                let wrapper = document.getElementById('presentaciones-wrapper');
                let newPresentacion = document.createElement('div');
                newPresentacion.classList.add('presentacion-item');
                newPresentacion.innerHTML = `
                    <div class="presentation-upload">
                        <img src="" alt="Presentación" class="presentacion-image-preview" style="width: 50px; height: 50px; margin-right: 10px; display: none;" />
                        <input type="file" name="presentaciones[image][]" accept="image/*" onchange="updateImagePreview(this)" style="display: none;" />
                        <button type="button" class="upload-image-button">Subir Imagen</button>
                    </div>
                    <input type="text" name="presentaciones[text][]" value="" style="width: 75%;" placeholder="Descripción" />
                    <button type="button" class="remove-presentacion">Eliminar</button>
                `;
                wrapper.appendChild(newPresentacion);
            });

            document.getElementById('presentaciones-wrapper').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-presentacion')) {
                    e.target.parentElement.remove();
                } else if (e.target.classList.contains('upload-image-button')) {
                    let fileInput = e.target.previousElementSibling;
                    fileInput.click();
                }
            });
        });

        function updateImagePreview(input) {
            let file = input.files[0];
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = input.previousElementSibling;
                img.src = e.target.result;
                img.style.display = 'inline';
            }
            reader.readAsDataURL(file);
        }
    </script>
    <?php
}

function Pomar_core_save_post($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['url_tienda'])) {
        update_post_meta($post_id, '_url_tienda', sanitize_text_field($_POST['url_tienda']));
    }

    if (isset($_POST['benefits'])) {
        $benefits = array();
        foreach ($_POST['benefits']['icon'] as $index => $icon) {
            $benefits[] = array(
                'icon' => sanitize_text_field($icon),
                'text' => sanitize_text_field($_POST['benefits']['text'][$index])
            );
        }
        update_post_meta($post_id, '_benefits', $benefits);
    }

    if (isset($_POST['presentaciones'])) {
        $presentaciones = array();
        foreach ($_POST['presentaciones']['text'] as $index => $text) {
            $image = $_FILES['presentaciones']['name']['image'][$index];
            $upload = wp_upload_bits($image, null, file_get_contents($_FILES['presentaciones']['tmp_name']['image'][$index]));
            if (!$upload['error']) {
                $presentaciones[] = array(
                    'image' => $upload['url'],
                    'text' => sanitize_text_field($text)
                );
            }
        }
        update_post_meta($post_id, '_presentaciones', $presentaciones);
    }
}
add_action('save_post', 'Pomar_core_save_post');

function add_category_custom_fields($taxonomy) {
    $icons = glob(EP_PLUGIN_DIR . 'assets/img/catalog/categories/*.svg');
    ?>
    <div class="form-field term-group">
        <label for="category-icon">Icono de la Categoría</label>
        <select name="category-icon" id="category-icon" class="category-icon-select">
            <?php foreach ($icons as $icon) {
                $icon_filename = basename($icon); ?>
                <option value="<?php echo esc_attr($icon_filename); ?>">
                    <?php echo esc_html($icon_filename); ?>
                </option>
            <?php } ?>
        </select>
        <img src="" alt="" class="category-icon-preview" style="width: 40px; height: 40px; vertical-align: middle; background:black;" />
        <p class="description">Selecciona un icono SVG para la categoría</p>
    </div>
    <div class="form-field term-group">
        <label for="category-order">Orden de la Categoría</label>
        <input type="number" name="category-order" id="category-order" value="0" min="0" />
        <p class="description">Define el orden en que se mostrarán las categorías</p>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateIconPreview() {
                let icon = document.getElementById('category-icon').value;
                let img = document.querySelector('.category-icon-preview');
                if (icon) {
                    img.src = '<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/categories/'; ?>' + icon;
                } else {
                    img.src = '';
                }
            }
            document.getElementById('category-icon').addEventListener('change', updateIconPreview);
            updateIconPreview();
        });
    </script>
    <?php
}
add_action('el_pomar_category_add_form_fields', 'add_category_custom_fields');
add_action('mulai_category_add_form_fields', 'add_category_custom_fields');
add_action('levelma_category_add_form_fields', 'add_category_custom_fields');

function edit_category_custom_fields($term, $taxonomy) {
    $category_icon  = get_term_meta($term->term_id, 'category-icon', true);
    $category_order = get_term_meta($term->term_id, 'category-order', true);
    $icons = glob(EP_PLUGIN_DIR . 'assets/img/catalog/categories/*.svg');
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="category-icon">Icono de la Categoría</label></th>
        <td>
            <select name="category-icon" id="category-icon" class="category-icon-select">
                <?php foreach ($icons as $icon) {
                    $icon_filename = basename($icon);
                    ?>
                    <option value="<?php echo esc_attr($icon_filename); ?>" <?php selected($icon_filename, $category_icon); ?>>
                        <?php echo esc_html($icon_filename); ?>
                    </option>
                <?php } ?>
            </select>
            <img src="<?php if ($category_icon) { echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/categories/' . esc_attr($category_icon); } ?>" alt="" class="category-icon-preview" style="width: 40px; height: 40px; vertical-align: middle; background:black;" />
            <p class="description">Selecciona un icono SVG para la categoría</p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="category-order">Orden de la Categoría</label></th>
        <td>
            <input type="number" name="category-order" id="category-order" value="<?php echo esc_attr($category_order); ?>" min="0" />
            <p class="description">Define el orden en que se mostrarán las categorías</p>
        </td>
    </tr>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateIconPreview() {
                let icon = document.getElementById('category-icon').value;
                let img = document.querySelector('.category-icon-preview');
                if (icon) {
                    img.src = '<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/categories/'; ?>' + icon;
                } else {
                    img.src = '';
                }
            }
            document.getElementById('category-icon').addEventListener('change', updateIconPreview);
            updateIconPreview();
        });
    </script>
    <?php
}
add_action('el_pomar_category_edit_form_fields', 'edit_category_custom_fields', 10, 2);
add_action('mulai_category_edit_form_fields', 'edit_category_custom_fields', 10, 2);
add_action('levelma_category_edit_form_fields', 'edit_category_custom_fields', 10, 2);


function save_category_custom_fields($term_id) {
    if (isset($_POST['category-icon'])) {
        update_term_meta($term_id, 'category-icon', sanitize_text_field($_POST['category-icon']));
    }
    if (isset($_POST['category-order'])) {
        update_term_meta($term_id, 'category-order', intval($_POST['category-order']));
    }
}
add_action('created_el_pomar_category', 'save_category_custom_fields', 10, 2);
add_action('edited_el_pomar_category', 'save_category_custom_fields', 10, 2);
add_action('created_mulai_category', 'save_category_custom_fields', 10, 2);
add_action('edited_mulai_category', 'save_category_custom_fields', 10, 2);
add_action('created_levelma_category', 'save_category_custom_fields', 10, 2);
add_action('edited_levelma_category', 'save_category_custom_fields', 10, 2);