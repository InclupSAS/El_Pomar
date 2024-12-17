<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function create_terms_and_conditions_post_type() {
    $labels = array(
        'name'                  => _x('Términos y Condiciones', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('Término y Condición', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Términos y Condiciones', 'text_domain'),
        'name_admin_bar'        => __('Término y Condición', 'text_domain'),
        'archives'              => __('Archivo de Términos y Condiciones', 'text_domain'),
        'attributes'            => __('Atributos de Términos y Condiciones', 'text_domain'),
        'parent_item_colon'     => __('Término y Condición Padre:', 'text_domain'),
        'all_items'             => __('Todos los Términos y Condiciones', 'text_domain'),
        'add_new_item'          => __('Agregar Nuevo Término y Condición', 'text_domain'),
        'add_new'               => __('Agregar Nuevo', 'text_domain'),
        'new_item'              => __('Nuevo Término y Condición', 'text_domain'),
        'edit_item'             => __('Editar Término y Condición', 'text_domain'),
        'update_item'           => __('Actualizar Término y Condición', 'text_domain'),
        'view_item'             => __('Ver Término y Condición', 'text_domain'),
        'view_items'            => __('Ver Términos y Condiciones', 'text_domain'),
        'search_items'          => __('Buscar Término y Condición', 'text_domain'),
        'not_found'             => __('No encontrado', 'text_domain'),
        'not_found_in_trash'    => __('No encontrado en la papelera', 'text_domain'),
        'featured_image'        => __('Imagen destacada', 'text_domain'),
        'set_featured_image'    => __('Establecer imagen destacada', 'text_domain'),
        'remove_featured_image' => __('Eliminar imagen destacada', 'text_domain'),
        'use_featured_image'    => __('Usar como imagen destacada', 'text_domain'),
        'insert_into_item'      => __('Insertar en Término y Condición', 'text_domain'),
        'uploaded_to_this_item' => __('Subido a este Término y Condición', 'text_domain'),
        'items_list'            => __('Lista de Términos y Condiciones', 'text_domain'),
        'items_list_navigation' => __('Navegación de lista de Términos y Condiciones', 'text_domain'),
        'filter_items_list'     => __('Filtrar lista de Términos y Condiciones', 'text_domain'),
    );
    $args = array(
        'label'                 => __('Término y Condición', 'text_domain'),
        'description'           => __('Post Type para Términos y Condiciones', 'text_domain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type('terms_and_conditions', $args);
}
add_action('init', 'create_terms_and_conditions_post_type', 0);

function add_custom_meta_boxes() {
    add_meta_box(
        'terms_and_conditions_pdf',
        __('Subir PDF', 'text_domain'),
        'render_pdf_meta_box',
        'terms_and_conditions',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'add_custom_meta_boxes');

function render_pdf_meta_box($post) {
    wp_nonce_field('save_pdf_meta_box_data', 'pdf_meta_box_nonce');
    $value = get_post_meta($post->ID, '_terms_and_conditions_pdf', true);
    echo '<label for="terms_and_conditions_pdf">';
    _e('Archivo PDF:', 'text_domain');
    echo '</label><br>';
    echo '<input type="file" id="terms_and_conditions_pdf" name="terms_and_conditions_pdf" value="' . esc_attr($value) . '" size="25" />';
    if ($value) {
        echo '<p><a href="' . esc_url($value) . '" target="_blank">Ver PDF actual</a></p>';
    }
}

function save_pdf_meta_box_data($post_id) {
    if (!isset($_POST['pdf_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['pdf_meta_box_nonce'], 'save_pdf_meta_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (!isset($_FILES['terms_and_conditions_pdf'])) {
        return;
    }

    $file = $_FILES['terms_and_conditions_pdf'];
    $upload = wp_handle_upload($file, array('test_form' => false));

    if (isset($upload['url']) && !isset($upload['error'])) {
        update_post_meta($post_id, '_terms_and_conditions_pdf', $upload['url']);
    }
}
add_action('save_post', 'save_pdf_meta_box_data');