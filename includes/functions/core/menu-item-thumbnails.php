<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function el_pomar_add_menu_item_custom_fields($item_id, $item, $depth, $args) {
    $thumbnail_id = get_post_meta($item_id, '_menu_item_thumbnail_id', true);
    $thumbnail_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
    ?>
    <p class="description description-wide">
        <label for="edit-menu-item-thumbnail-<?php echo $item_id; ?>">
            <?php _e('Imagen destacada', 'el_pomar'); ?><br>
            <input type="hidden" class="widefat code edit-menu-item-thumbnail" name="menu-item-thumbnail[<?php echo $item_id; ?>]" id="edit-menu-item-thumbnail-<?php echo $item_id; ?>" value="<?php echo esc_attr($thumbnail_id); ?>">
            <button type="button" class="button upload-thumbnail-button" data-item-id="<?php echo $item_id; ?>"><?php _e('Subir Imagen', 'el_pomar'); ?></button>
            <button type="button" class="button remove-thumbnail-button" data-item-id="<?php echo $item_id; ?>"><?php _e('Eliminar Imagen', 'el_pomar'); ?></button>
        </label>
    </p>
    <div class="menu-item-thumbnail-preview" id="menu-item-thumbnail-preview-<?php echo $item_id; ?>">
        <?php if ($thumbnail_url) : ?>
            <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($item->title); ?>" style="max-width: 100%; height: auto;">
        <?php endif; ?>
    </div>
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'el_pomar_add_menu_item_custom_fields', 10, 4);


function el_pomar_save_menu_item_custom_fields($menu_id, $menu_item_db_id) {
    if (isset($_POST['menu-item-thumbnail'][$menu_item_db_id])) {
        $thumbnail_id = sanitize_text_field($_POST['menu-item-thumbnail'][$menu_item_db_id]);
        update_post_meta($menu_item_db_id, '_menu_item_thumbnail_id', $thumbnail_id);
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_thumbnail_id');
    }
}
add_action('wp_update_nav_menu_item', 'el_pomar_save_menu_item_custom_fields', 10, 2);


function el_pomar_enqueue_menu_item_custom_fields_scripts($hook) {
    if ($hook != 'nav-menus.php') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('el_pomar-menu-item-custom-fields', plugin_dir_url(__FILE__) . '../../../assets/js/admin/menu-item-custom-fields.js', array('jquery'), '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'el_pomar_enqueue_menu_item_custom_fields_scripts');


function el_pomar_display_menu_item_thumbnail($item_output, $item, $depth, $args) {
    if ($depth > 0) { 
        $thumbnail_id = get_post_meta($item->ID, '_menu_item_thumbnail_id', true);
        if ($thumbnail_id) {
            $thumbnail_url = wp_get_attachment_url($thumbnail_id);
            $item_output = '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr($item->title) . '" class="menu-item-thumbnail">' . $item_output;
        }
    }
    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'el_pomar_display_menu_item_thumbnail', 10, 4);