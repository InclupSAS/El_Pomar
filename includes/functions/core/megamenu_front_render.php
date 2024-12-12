<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function get_current_url() {
    global $wp;
    return home_url(add_query_arg(array(), $wp->request));
}

// Definir la clase El_Pomar_Walker_Nav_Menu
class El_Pomar_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = array()) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat($t, $depth);
        $classes = array('sub-menu');
        $class_names = join(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        $output .= "{$n}{$indent}<ul$class_names>{$n}";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        $output .= $indent . '<li' . $id . $class_names . '>';
        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
        $thumbnail_id = get_post_meta($item->ID, '_menu_item_thumbnail_id', true);
        $thumbnail_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= '<img src="' . esc_url(plugin_dir_url(__FILE__) . '../../../assets/img/icons/grey_arrow_right.svg') . '" alt="Icon" class="menu-item-icon" style="margin-right: 8px;">';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        if ($thumbnail_url) {
            $item_output .= '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr($title) . '" class="menu-item-thumbnail" style="display:none;">';
        }
        $item_output .= $args->after;
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// Función para renderizar el megamenú en el frontend
function el_pomar_render_megamenu() {
    ob_start();

    $main_menu_id = get_option('el_pomar_main_menu');
    if (!$main_menu_id) {
        echo '<p>No se ha seleccionado un menú principal.</p>';
        return ob_get_clean();
    }

    $menu_interactions = get_option('el_pomar_menu_interactions', array());
    $submenus = get_option('el_pomar_submenus', array());
    $custom_content = get_option('el_pomar_custom_content', array());
    $submenu_titles = get_option('el_pomar_submenu_titles', array());

    ?>
    <!-- Contenedor principal que tomará todo el ancho -->
    <div class="menu-wrapper">
        <!-- Contenedor interno para centrar el contenido -->
        <div class="menu-container">
            <nav class="main-menu" aria-label="Main Menu">
                <?php
                wp_nav_menu(array(
                    'menu' => $main_menu_id,
                    'container' => false,
                    'items_wrap' => '<ul class="menu-list">%3$s</ul>',
                    'walker' => new El_Pomar_Walker_Nav_Menu()
                ));
                ?>
            </nav>
        </div>
        <!-- Los megamenús fuera del contenedor centrado para que tomen todo el ancho -->
        <div class="megamenu-container">
            <?php
            // Obtener los elementos del menú principal
            $menu_items = wp_get_nav_menu_items($main_menu_id);
            if ($menu_items) {
                foreach ($menu_items as $item) {
                    $item_id = $item->ID;
                    $interaction = isset($menu_interactions[$item_id]) ? $menu_interactions[$item_id] : 'url';
                    if ($interaction === 'megamenu') :
                        $has_submenus = !empty(array_filter($submenus[$item_id] ?? []));
                        $has_custom_content = !empty($custom_content[$item_id]);
                        ?>
                        <div class="megamenu" id="megamenu-<?php echo esc_attr($item_id); ?>">
                            <div class="megamenu-content">
                                <?php if ($has_custom_content) : ?>
                                    <div class="EP-megamenu-block">
                                        <?php echo wp_kses_post($custom_content[$item_id]); ?>
                                    </div>
                                <?php elseif ($has_submenus) : ?>
                                    <?php foreach ($submenus[$item_id] as $submenu_key => $submenu_id) : ?>
                                        <?php if ($submenu_id) : ?>
                                            <div class="submenu" id="<?php echo esc_attr($submenu_key); ?>">
                                                <h3><?php echo esc_html(isset($submenu_titles[$item_id][$submenu_key]) ? $submenu_titles[$item_id][$submenu_key] : $submenu_key); ?></h3>
                                                <?php
                                                wp_nav_menu(array(
                                                    'menu' => $submenu_id,
                                                    'container' => false,
                                                    'items_wrap' => '<ul class="submenu-list">%3$s</ul>',
                                                    'walker' => new El_Pomar_Walker_Nav_Menu()
                                                ));
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <div class="thumbnail-menu" style="background-image:url('');"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif;
                }
            }
            ?>
        </div>
    </div>
    <?php

    return ob_get_clean();
}


function el_pomar_enqueue_megamenu_scripts() {
    wp_enqueue_script('el_pomar-megamenu-hover', plugin_dir_url(__FILE__) . '../../../assets/js/frontend/megamenu-hover.js', array('jquery'), '1.0.0', true);
    wp_enqueue_style('el_pomar-megamenu-style', plugin_dir_url(__FILE__) . '../../../assets/css/frontend/megamenu.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'el_pomar_enqueue_megamenu_scripts');


function el_pomar_megamenu_shortcode() {
    return el_pomar_render_megamenu();
}
add_shortcode('el_pomar_megamenu', 'el_pomar_megamenu_shortcode');

