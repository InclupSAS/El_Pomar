<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function el_pomar_register_news_post_type() {
    $labels = array(
        'name'                  => _x('Noticias', 'Post type general name', 'el_pomar'),
        'singular_name'         => _x('Noticia', 'Post type singular name', 'el_pomar'),
        'menu_name'             => _x('Noticias', 'Admin Menu text', 'el_pomar'),
        'name_admin_bar'        => _x('Noticia', 'Add New on Toolbar', 'el_pomar'),
        'add_new'               => __('Añadir Nueva', 'el_pomar'),
        'add_new_item'          => __('Añadir Nueva Noticia', 'el_pomar'),
        'new_item'              => __('Nueva Noticia', 'el_pomar'),
        'edit_item'             => __('Editar Noticia', 'el_pomar'),
        'view_item'             => __('Ver Noticia', 'el_pomar'),
        'all_items'             => __('Todas las Noticias', 'el_pomar'),
        'search_items'          => __('Buscar Noticias', 'el_pomar'),
        'parent_item_colon'     => __('Noticias Padre:', 'el_pomar'),
        'not_found'             => __('No se encontraron noticias.', 'el_pomar'),
        'not_found_in_trash'    => __('No se encontraron noticias en la papelera.', 'el_pomar'),
        'featured_image'        => _x('Imagen destacada', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'set_featured_image'    => _x('Establecer imagen destacada', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'remove_featured_image' => _x('Eliminar imagen destacada', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'use_featured_image'    => _x('Usar como imagen destacada', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'archives'              => _x('Archivos de noticias', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'el_pomar'),
        'insert_into_item'      => _x('Insertar en noticia', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'el_pomar'),
        'uploaded_to_this_item' => _x('Subido a esta noticia', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'el_pomar'),
        'filter_items_list'     => _x('Filtrar lista de noticias', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'el_pomar'),
        'items_list_navigation' => _x('Navegación de lista de noticias', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'el_pomar'),
        'items_list'            => _x('Lista de noticias', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'el_pomar'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'show_in_admin_bar'  => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'noticias'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('news', $args);
}

function el_pomar_add_news_metaboxes() {
    add_meta_box(
        'el_pomar_news_details',
        'Detalles de la Noticia',
        'el_pomar_news_details_callback',
        'news',
        'normal',
        'high'
    );
}

function el_pomar_news_details_callback($post) {
    wp_nonce_field('el_pomar_save_news_details', 'el_pomar_news_details_nonce');

    $news_url = get_post_meta($post->ID, '_el_pomar_news_url', true);
    $news_source = get_post_meta($post->ID, '_el_pomar_news_source', true);
    $news_source_url = get_post_meta($post->ID, '_el_pomar_news_source_url', true);
    $publication_date = get_post_meta($post->ID, '_el_pomar_publication_date', true);
    $audio_file = get_post_meta($post->ID, '_el_pomar_audio_file', true);
    $pdf_file = get_post_meta($post->ID, '_el_pomar_pdf_file', true);

    echo '<div id="el_pomar_news_details">';
    echo '<div class="inline-fields">';
    echo '<label for="el_pomar_news_url">URL de la Noticia:</label>';
    echo '<input type="text" id="el_pomar_news_url" name="el_pomar_news_url" value="' . esc_attr($news_url) . '">';

    echo '<label for="el_pomar_publication_date">Fecha de Publicación:</label>';
    echo '<input type="date" id="el_pomar_publication_date" name="el_pomar_publication_date" value="' . esc_attr($publication_date) . '">';
    echo '</div>';

    echo '<div class="inline-fields">';
    echo '<label for="el_pomar_news_source">Medio:</label>';
    echo '<input type="text" id="el_pomar_news_source" name="el_pomar_news_source" value="' . esc_attr($news_source) . '">';

    echo '<label for="el_pomar_news_source_url">URL del Medio:</label>';
    echo '<input type="text" id="el_pomar_news_source_url" name="el_pomar_news_source_url" value="' . esc_attr($news_source_url) . '">';
    echo '</div>';

    echo '<div class="inline-fields">';
    echo '<label for="el_pomar_audio_file">Archivo de Audio:</label>';
    echo '<input type="text" id="el_pomar_audio_file" name="el_pomar_audio_file" value="' . esc_attr($audio_file) . '">';
    echo '<button type="button" class="button" id="upload_audio_button">Subir Audio</button>';

    echo '<label for="el_pomar_pdf_file">Archivo PDF:</label>';
    echo '<input type="text" id="el_pomar_pdf_file" name="el_pomar_pdf_file" value="' . esc_attr($pdf_file) . '">';
    echo '<button type="button" class="button" id="upload_pdf_button">Subir PDF</button>';
    echo '</div>';
    echo '</div>';
}

function el_pomar_save_news_details($post_id) {
    if (!isset($_POST['el_pomar_news_details_nonce']) || !wp_verify_nonce($_POST['el_pomar_news_details_nonce'], 'el_pomar_save_news_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['el_pomar_news_url'])) {
        update_post_meta($post_id, '_el_pomar_news_url', esc_url_raw($_POST['el_pomar_news_url']));
    }

    if (isset($_POST['el_pomar_news_source'])) {
        update_post_meta($post_id, '_el_pomar_news_source', sanitize_text_field($_POST['el_pomar_news_source']));
    }

    if (isset($_POST['el_pomar_news_source_url'])) {
        update_post_meta($post_id, '_el_pomar_news_source_url', esc_url_raw($_POST['el_pomar_news_source_url']));
    }

    if (isset($_POST['el_pomar_publication_date'])) {
        update_post_meta($post_id, '_el_pomar_publication_date', sanitize_text_field($_POST['el_pomar_publication_date']));
    }

    if (isset($_POST['el_pomar_audio_file'])) {
        update_post_meta($post_id, '_el_pomar_audio_file', esc_url_raw($_POST['el_pomar_audio_file']));
    }

    if (isset($_POST['el_pomar_pdf_file'])) {
        update_post_meta($post_id, '_el_pomar_pdf_file', esc_url_raw($_POST['el_pomar_pdf_file']));
    }
}

function el_pomar_enqueue_admin_scripts($hook) {
    if ('post.php' !== $hook && 'post-new.php' !== $hook) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('el_pomar_admin_script', plugin_dir_url(__FILE__) . 'admin-script.js', array('jquery'), null, true);

    // Inline script to handle media uploads
    $script = <<<EOT
    jQuery(document).ready(function($) {
        $('#upload_audio_button').on('click', function(e) {
            e.preventDefault();
            var file_frame = wp.media.frames.file_frame = wp.media({
                title: 'Seleccionar o Subir Archivo de Audio',
                button: {
                    text: 'Usar este archivo'
                },
                multiple: false
            });

            file_frame.on('select', function() {
                var attachment = file_frame.state().get('selection').first().toJSON();
                $('#el_pomar_audio_file').val(attachment.url);
            });

            file_frame.open();
        });

        $('#upload_pdf_button').on('click', function(e) {
            e.preventDefault();
            var file_frame = wp.media.frames.file_frame = wp.media({
                title: 'Seleccionar o Subir Archivo PDF',
                button: {
                    text: 'Usar este archivo'
                },
                multiple: false
            });

            file_frame.on('select', function() {
                var attachment = file_frame.state().get('selection').first().toJSON();
                $('#el_pomar_pdf_file').val(attachment.url);
            });

            file_frame.open();
        });
    });
    EOT;

    wp_add_inline_script('el_pomar_admin_script', $script);
}
add_action('admin_enqueue_scripts', 'el_pomar_enqueue_admin_scripts');

add_action('init', 'el_pomar_register_news_post_type');
add_action('add_meta_boxes', 'el_pomar_add_news_metaboxes');
add_action('save_post', 'el_pomar_save_news_details');

function el_pomar_render_news_buttons() {
    $post_id = get_the_ID();
    $audio_file = get_post_meta($post_id, '_el_pomar_audio_file', true);
    $pdf_file = get_post_meta($post_id, '_el_pomar_pdf_file', true);
    $news_url = get_post_meta($post_id, '_el_pomar_news_url', true);

    // Depuración
    error_log('Audio File: ' . $audio_file);
    error_log('PDF File: ' . $pdf_file);
    error_log('News URL: ' . $news_url);

    ob_start();
    echo '<div class="el-pomar-news-buttons">';

    if ($audio_file) {
        echo '<div class="news-button">';
        echo '<audio controls>';
        echo '<source src="' . esc_url($audio_file) . '" type="audio/mpeg">';
        echo 'Tu navegador no soporta el elemento de audio.';
        echo '</audio>';
        echo '</div>';
    }

    if ($pdf_file) {
        echo '<div class="news-button">';
        echo '<a href="' . esc_url($pdf_file) . '" class="button" download>Descargar PDF</a>';
        echo '</div>';
    }

    if ($news_url) {
        echo '<div class="news-button">';
        echo '<a href="' . esc_url($news_url) . '" class="button" target="_blank">Ver Noticia</a>';
        echo '</div>';
    }

    echo '</div>';
    return ob_get_clean();
}

function el_pomar_news_buttons_shortcode() {
    return el_pomar_render_news_buttons();
}
add_shortcode('el_pomar_news_buttons', 'el_pomar_news_buttons_shortcode');