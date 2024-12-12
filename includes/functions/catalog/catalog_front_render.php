<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function Pomar_core_shortcode() {
    ob_start();
    ?>
    <div class="productsContainer">
        <nav class="nav-tabs">
            <a href="#El_Pomar" class="tab active" data-tab="tab-El_Pomar"><img src="<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/el_pomar.svg'; ?>" alt="El Pomar"> </a>
            <a href="#Mulai" class="tab" data-tab="tab-Mulai"><img src="<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/Mulai.svg'; ?>" alt="Mulai"></a>
            <a href="#Levelma" class="tab" data-tab="tab-Levelma"><img src="<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/levelma.svg'; ?>" alt="Levelma"></a>
        </nav>
        
        <div class="container">
            <div id="tab-El_Pomar" class="tab-content current" style="background-image: url('<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/bg-el-pomar.jpg'; ?>'">
                <?php Pomar_core_render_tab_content('el_pomar', 'el_pomar_category'); ?>
            </div>
            <div id="tab-Mulai" class="tab-content" style="background-image: url('<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/bg-mulai.jpg'; ?>'">
                <?php Pomar_core_render_tab_content('mulai', 'mulai_category'); ?>
            </div>
            <div id="tab-Levelma" class="tab-content" style="background-image: url('<?php echo plugin_dir_url(__FILE__) . '../../../assets/img/catalog/bg-levelma.jpg'; ?>'">
                <?php Pomar_core_render_tab_content('levelma', 'levelma_category'); ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('catalog_pomar', 'Pomar_core_shortcode');

function Pomar_core_render_tab_content($post_type, $taxonomy) {
    $categories = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
        'meta_key' => 'category-order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
    ));

    if (!empty($categories)) {
        echo '<div class="product_cat">';
        echo '<div class="accordion">';
        foreach ($categories as $index => $category) {
            $category_icon = get_term_meta($category->term_id, 'category-icon', true);
            $posts = get_posts(array(
                'post_type' => $post_type,
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'term_id',
                        'terms' => $category->term_id,
                    ),
                ),
            ));
            echo '<div class="accordion-item">';
            echo '<div class="accordion-header">';
            if ($category_icon) {
                echo '<img src="' . plugin_dir_url(__FILE__) . '../../../assets/img/catalog/categories/' . esc_attr($category_icon) . '" alt="' . esc_attr($category->name) . '" class="category-icon">';
            }
            echo '<div class="category-details">';
            echo '<span class="category-name">' . esc_html($category->name) . '</span>';
            echo '</div>';
            echo '<img src="' . plugin_dir_url(__FILE__) . '../../../assets/img/icons/' . ($index === 0 ? 'minus' : 'plus') . '.svg' . '" alt="Toggle Icon" class="toggle-icon">';
            echo '</div>';
            echo '<div class="accordion-content" style="display: ' . ($index === 0 ? 'block' : 'none') . ';">';
            if (!empty($posts)) {
                echo '<ul>';
                foreach ($posts as $post_index => $post) {
                    $post_url = home_url('/nuestras-marcas/#' . $taxonomy . '/' . $post->post_name);
                    echo '<li><a href="' . esc_url($post_url) . '" class="product-link ' . ($index === 0 && $post_index === 0 ? 'active' : '') . '" data-post-id="' . esc_attr($post->ID) . '" data-post-name="' . esc_attr($post->post_name) . '" data-post-title="' . esc_attr($post->post_title) . '" data-post-description="' . esc_attr(get_post_meta($post->ID, '_yoast_wpseo_metadesc', true)) . '" data-post-image="' . esc_url(get_the_post_thumbnail_url($post->ID, 'full')) . '">';
                    echo '<img src="' . plugin_dir_url(__FILE__) . '../../../assets/img/icons/right-arrow.svg' . '" alt="Right Arrow" class="product-icon">';
                    echo esc_html($post->post_title) . '</a></li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No hay productos disponibles.</p>';
            }
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';

        echo '<div class="product-image">';
        echo '<img src="" alt="" id="product-image">';
        echo '</div>';

        echo '<a href="#" id="product-url" class="buy-button" target="_blank">Comprar Producto</a>';

        echo '<h2 id="product-name"></h2>';
        echo '<div id="product-description"></div>';
        echo '<div id="product-benefits"></div>';
        echo '<div id="product-presentation" class="product-presentation"></div>';
    } else {
        echo '<p>No hay categorías disponibles.</p>';
    }
}

function Pomar_core_load_product_details() {
    if (!isset($_GET['post_id'])) {
        wp_send_json_error('Missing post_id', 400);
        return;
    }

    $post_id = intval($_GET['post_id']);
    $post = get_post($post_id);
    if (!$post) {
        wp_send_json_error('Invalid post_id', 400);
        return;
    }

    $post_name = $post->post_title; 
    $image = get_the_post_thumbnail_url($post_id, 'full');
    $url_tienda = get_post_meta($post_id, '_url_tienda', true);
    $benefits = get_post_meta($post_id, '_benefits', true);
    $presentaciones = get_post_meta($post_id, '_presentaciones', true);
    $post_content = apply_filters('the_content', $post->post_content);

    $benefits_list = '';
    if (!empty($benefits)) {
        foreach ($benefits as $benefit) {
            $benefits_list .= '<div class="info-item">';
            if (!empty($benefit['icon'])) {
                $benefits_list .= '<div class="info-icon"><img src="' . plugin_dir_url(__FILE__) . '../../../assets/img/catalog/icons/' . esc_attr($benefit['icon']) . '" alt="' . esc_attr($benefit['text']) . '"></div>';
            }
            $benefits_list .= '<div class="benefist-descrip">' . esc_html($benefit['text']) . '</div></div>';
        }
    }

    $presentaciones_list = '';
    $first_presentation_image = '';
    if (!empty($presentaciones)) {
        foreach ($presentaciones as $index => $presentacion) {
            if ($index === 0) {
                $first_presentation_image = esc_url($presentacion['image']);
            }
            $presentaciones_list .= '<div class="presentation-item" data-image="' . esc_url($presentacion['image']) . '">';
            if (!empty($presentacion['image'])) {
                $presentaciones_list .= '<div class="presentation-image"><img src="' . esc_url($presentacion['image']) . '" alt="Presentación"></div>';
            }
            $presentaciones_list .= '<div class="presentation-descrip">' . esc_html($presentacion['text']) . '</div></div>';
        }
    }

    wp_send_json(array(
        'name' => $post_name, 
        'image' => $first_presentation_image ?: $image,
        'url' => $url_tienda,
        'benefits' => $benefits_list,
        'presentaciones' => $presentaciones_list,
        'content' => $post_content,
    ));
}
add_action('wp_ajax_load_product_details', 'Pomar_core_load_product_details');
add_action('wp_ajax_nopriv_load_product_details', 'Pomar_core_load_product_details');