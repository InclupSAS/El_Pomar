<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function el_pomar_register_recipes_post_type() {
    $labels = array(
        'name'                  => _x('Recetas', 'Post type general name', 'el_pomar'),
        'singular_name'         => _x('Receta', 'Post type singular name', 'el_pomar'),
        'menu_name'             => _x('Recetas', 'Admin Menu text', 'el_pomar'),
        'name_admin_bar'        => _x('Receta', 'Add New on Toolbar', 'el_pomar'),
        'add_new'               => __('Añadir Nueva', 'el_pomar'),
        'add_new_item'          => __('Añadir Nueva Receta', 'el_pomar'),
        'new_item'              => __('Nueva Receta', 'el_pomar'),
        'edit_item'             => __('Editar Receta', 'el_pomar'),
        'view_item'             => __('Ver Receta', 'el_pomar'),
        'all_items'             => __('Todas las Recetas', 'el_pomar'),
        'search_items'          => __('Buscar Recetas', 'el_pomar'),
        'parent_item_colon'     => __('Recetas Padre:', 'el_pomar'),
        'not_found'             => __('No se encontraron recetas.', 'el_pomar'),
        'not_found_in_trash'    => __('No se encontraron recetas en la papelera.', 'el_pomar'),
        'featured_image'        => _x('Imagen Destacada', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'set_featured_image'    => _x('Establecer imagen destacada', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'remove_featured_image' => _x('Eliminar imagen destacada', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'use_featured_image'    => _x('Usar como imagen destacada', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'el_pomar'),
        'archives'              => _x('Archivos de recetas', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'el_pomar'),
        'insert_into_item'      => _x('Insertar en receta', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'el_pomar'),
        'uploaded_to_this_item' => _x('Subido a esta receta', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'el_pomar'),
        'filter_items_list'     => _x('Filtrar lista de recetas', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'el_pomar'),
        'items_list_navigation' => _x('Navegación de lista de recetas', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'el_pomar'),
        'items_list'            => _x('Lista de recetas', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'el_pomar'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'show_in_admin_bar'  => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'recetas'), 
        'capability_type'    => 'post',
        'has_archive'        => 'recetas', 
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('recipes', $args);
}

function el_pomar_register_recipes_taxonomies() {
    $labels = array(
        'name'              => _x('Categorías de Recetas', 'taxonomy general name', 'el_pomar'),
        'singular_name'     => _x('Categoría de Recetas', 'taxonomy singular name', 'el_pomar'),
        'search_items'      => __('Buscar Categorías de Recetas', 'el_pomar'),
        'all_items'         => __('Todas las Categorías de Recetas', 'el_pomar'),
        'parent_item'       => __('Categoría Padre', 'el_pomar'),
        'parent_item_colon' => __('Categoría Padre:', 'el_pomar'),
        'edit_item'         => __('Editar Categoría de Recetas', 'el_pomar'),
        'update_item'       => __('Actualizar Categoría de Recetas', 'el_pomar'),
        'add_new_item'      => __('Añadir Nueva Categoría de Recetas', 'el_pomar'),
        'new_item_name'     => __('Nuevo Nombre de Categoría de Recetas', 'el_pomar'),
        'menu_name'         => __('Categorías de Recetas', 'el_pomar'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'recipe_category'),
    );

    register_taxonomy('recipe_category', array('recipes'), $args);

    $labels = array(
        'name'                       => _x('Etiquetas de Recetas', 'taxonomy general name', 'el_pomar'),
        'singular_name'              => _x('Etiqueta de Recetas', 'taxonomy singular name', 'el_pomar'),
        'search_items'               => __('Buscar Etiquetas de Recetas', 'el_pomar'),
        'popular_items'              => __('Etiquetas de Recetas Populares', 'el_pomar'),
        'all_items'                  => __('Todas las Etiquetas de Recetas', 'el_pomar'),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __('Editar Etiqueta de Recetas', 'el_pomar'),
        'update_item'                => __('Actualizar Etiqueta de Recetas', 'el_pomar'),
        'add_new_item'               => __('Añadir Nueva Etiqueta de Recetas', 'el_pomar'),
        'new_item_name'              => __('Nuevo Nombre de Etiqueta de Recetas', 'el_pomar'),
        'separate_items_with_commas' => __('Separar etiquetas con comas', 'el_pomar'),
        'add_or_remove_items'        => __('Añadir o eliminar etiquetas', 'el_pomar'),
        'choose_from_most_used'      => __('Elegir entre las más usadas', 'el_pomar'),
        'not_found'                  => __('No se encontraron etiquetas.', 'el_pomar'),
        'menu_name'                  => __('Etiquetas de Recetas', 'el_pomar'),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array('slug' => 'recipe_tags'),
    );

    register_taxonomy('recipe_tags', 'recipes', $args);
}

add_action('init', 'el_pomar_register_recipes_post_type');
add_action('init', 'el_pomar_register_recipes_taxonomies');


function el_pomar_add_recipes_metaboxes() {
    add_meta_box(
        'el_pomar_recipe_details',
        'Detalles de la Receta',
        'el_pomar_recipe_details_callback',
        'recipes',
        'normal',
        'high'
    );
}

function el_pomar_recipe_details_callback($post) {
    wp_nonce_field('el_pomar_save_recipe_details', 'el_pomar_recipe_details_nonce');

    $ingredients = get_post_meta($post->ID, '_el_pomar_ingredients', true);
    $difficulty = get_post_meta($post->ID, '_el_pomar_difficulty', true);
    $servings = get_post_meta($post->ID, '_el_pomar_servings', true);
    $prep_time = get_post_meta($post->ID, '_el_pomar_prep_time', true);
    $shop_link = get_post_meta($post->ID, '_el_pomar_shop_link', true);

    echo '<label for="el_pomar_ingredients">Ingredientes:</label>';
    echo '<div id="ingredients-wrapper" style="margin: 15px 0;">';
    if (!empty($ingredients)) {
        foreach ($ingredients as $ingredient) {
            echo '<div class="ingredient-item">';
            echo '<input type="text" name="ingredients[]" value="' . esc_attr($ingredient) . '" style="width: 80%;" placeholder="Ingrediente" />';
            echo '<button type="button" class="remove-ingredient">Eliminar</button>';
            echo '</div>';
        }
    }
    echo '</div>';
    echo '<button type="button" id="add-ingredient">Agregar Ingrediente</button>';

    echo '<label for="el_pomar_difficulty">Dificultad (1-5):</label>';
    echo '<input type="number" id="el_pomar_difficulty" name="el_pomar_difficulty" value="' . esc_attr($difficulty) . '" min="1" max="5">';

    echo '<label for="el_pomar_servings">Porciones:</label>';
    echo '<input type="text" id="el_pomar_servings" name="el_pomar_servings" value="' . esc_attr($servings) . '">';

    echo '<label for="el_pomar_prep_time">Tiempo de Preparación:</label>';
    echo '<input type="text" id="el_pomar_prep_time" name="el_pomar_prep_time" value="' . esc_attr($prep_time) . '">';

    echo '<label for="el_pomar_shop_link">Link de Tienda:</label>';
    echo '<input type="text" id="el_pomar_shop_link" name="el_pomar_shop_link" value="' . esc_attr($shop_link) . '">';

    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('add-ingredient').addEventListener('click', function() {
                let wrapper = document.getElementById('ingredients-wrapper');
                let newIngredient = document.createElement('div');
                newIngredient.classList.add('ingredient-item');
                newIngredient.innerHTML = `
                    <input type="text" name="ingredients[]" value="" style="width: 80%;" placeholder="Ingrediente" />
                    <button type="button" class="remove-ingredient">Eliminar</button>
                `;
                wrapper.appendChild(newIngredient);
            });

            document.getElementById('ingredients-wrapper').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-ingredient')) {
                    e.target.parentElement.remove();
                }
            });
        });
    </script>
    <?php
}

function el_pomar_save_recipe_details($post_id) {
    if (!isset($_POST['el_pomar_recipe_details_nonce']) || !wp_verify_nonce($_POST['el_pomar_recipe_details_nonce'], 'el_pomar_save_recipe_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['ingredients'])) {
        $ingredients = array_map('sanitize_text_field', $_POST['ingredients']);
        update_post_meta($post_id, '_el_pomar_ingredients', $ingredients);
    }

    if (isset($_POST['el_pomar_difficulty'])) {
        update_post_meta($post_id, '_el_pomar_difficulty', intval($_POST['el_pomar_difficulty']));
    }

    if (isset($_POST['el_pomar_servings'])) {
        update_post_meta($post_id, '_el_pomar_servings', sanitize_text_field($_POST['el_pomar_servings']));
    }

    if (isset($_POST['el_pomar_prep_time'])) {
        update_post_meta($post_id, '_el_pomar_prep_time', sanitize_text_field($_POST['el_pomar_prep_time']));
    }

    if (isset($_POST['el_pomar_shop_link'])) {
        update_post_meta($post_id, '_el_pomar_shop_link', esc_url_raw($_POST['el_pomar_shop_link']));
    }
}

add_action('add_meta_boxes', 'el_pomar_add_recipes_metaboxes');
add_action('save_post', 'el_pomar_save_recipe_details');