<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function el_pomar_register_settings() {
    register_setting('el_pomar_settings_group', 'el_pomar_main_menu');
    register_setting('el_pomar_settings_group', 'el_pomar_menu_interactions', 'el_pomar_sanitize_interactions');
    register_setting('el_pomar_settings_group', 'el_pomar_submenus', 'el_pomar_sanitize_submenus');
    register_setting('el_pomar_settings_group', 'el_pomar_custom_content', 'el_pomar_sanitize_custom_content');
    register_setting('el_pomar_settings_group', 'el_pomar_submenu_titles', 'el_pomar_sanitize_submenu_titles');
    register_setting('el_pomar_settings_group', 'el_pomar_custom_styles', 'wp_kses_post');
    register_setting('el_pomar_settings_group', 'el_pomar_terms_link');
    register_setting('el_pomar_settings_group', 'el_pomar_privacy_link');
    register_setting('el_pomar_settings_group', 'el_pomar_phone_number');
    register_setting('el_pomar_settings_group', 'el_pomar_whatsapp_number');

    add_settings_section(
        'el_pomar_settings_section',
        __('Configuración del Menú Principal', 'el_pomar'),
        'el_pomar_settings_section_callback',
        'el_pomar_settings'
    );

    add_settings_section(
        'el_pomar_contact_section',
        __('Números de Contacto', 'el_pomar'),
        'el_pomar_contact_section_callback',
        'el_pomar_settings'
    );

    add_settings_field(
        'el_pomar_main_menu',
        __('Seleccionar Menú Principal', 'el_pomar'),
        'el_pomar_main_menu_callback',
        'el_pomar_settings',
        'el_pomar_settings_section'
    );

    add_settings_field(
        'el_pomar_menu_interactions',
        __('Interacciones del Menú', 'el_pomar'),
        'el_pomar_menu_interactions_callback',
        'el_pomar_settings',
        'el_pomar_settings_section'
    );

    add_settings_field(
        'el_pomar_custom_styles',
        __('Estilos Personalizados', 'el_pomar'),
        'el_pomar_custom_styles_callback',
        'el_pomar_settings',
        'el_pomar_settings_section'
    );

    add_settings_field(
        'el_pomar_terms_link',
        __('URL Términos y Condiciones', 'el_pomar'),
        'el_pomar_terms_link_callback',
        'el_pomar_settings',
        'el_pomar_settings_section'
    );
    
    add_settings_field(
        'el_pomar_privacy_link',
        __('URL Tratamiento de Datos', 'el_pomar'),
        'el_pomar_privacy_link_callback',
        'el_pomar_settings',
        'el_pomar_settings_section'
    );

    add_settings_field(
        'el_pomar_phone_number',
        __('Número de Teléfono', 'el_pomar'),
        'el_pomar_phone_number_callback',
        'el_pomar_settings',
        'el_pomar_contact_section'
    );

    add_settings_field(
        'el_pomar_whatsapp_number',
        __('Número de WhatsApp', 'el_pomar'),
        'el_pomar_whatsapp_number_callback',
        'el_pomar_settings',
        'el_pomar_contact_section'
    );
}
add_action('admin_init', 'el_pomar_register_settings');

function el_pomar_settings_section_callback() {
    echo '<p>' . __('Selecciona el menú principal que se mostrará en el frontend y configura las interacciones de cada opción del menú.', 'el_pomar') . '</p>';
}

function el_pomar_contact_section_callback() {
    echo '<p>' . __('Configura los números de contacto que se mostrarán en tu sitio.', 'el_pomar') . '</p>';
}

function el_pomar_main_menu_callback() {
    $menus = wp_get_nav_menus();
    $selected_menu = get_option('el_pomar_main_menu');
    ?>
    <select name="el_pomar_main_menu" id="el_pomar_main_menu">
        <?php foreach ($menus as $menu) : ?>
            <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected($selected_menu, $menu->term_id); ?>>
                <?php echo esc_html($menu->name); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}

function el_pomar_menu_interactions_callback() {
    $selected_menu = get_option('el_pomar_main_menu');
    if (!$selected_menu) {
        echo '<p>' . __('Selecciona un menú principal primero.', 'el_pomar') . '</p>';
        return;
    }

    $menus = wp_get_nav_menus();
    $menu_items = wp_get_nav_menu_items($selected_menu);
    $menu_interactions = get_option('el_pomar_menu_interactions', array());
    $custom_content = get_option('el_pomar_custom_content', array());
    $submenus = get_option('el_pomar_submenus', array());
    $submenu_titles = get_option('el_pomar_submenu_titles', array());

    if ($menu_items) {
        echo '<table class="form-table">';
        foreach ($menu_items as $item) {
            $interaction = isset($menu_interactions[$item->ID]) ? $menu_interactions[$item->ID] : 'url';
            $megamenu_type = (isset($submenus[$item->ID]) && is_array($submenus[$item->ID]) && !empty(array_filter($submenus[$item->ID]))) ? 'submenus' : (isset($custom_content[$item->ID]) ? 'custom' : 'submenus');
            ?>
            <tr>
                <th scope="row"><?php echo esc_html($item->title); ?></th>
                <td>
                    <select name="el_pomar_menu_interactions[<?php echo esc_attr($item->ID); ?>]" class="menu-interaction-select" data-item-id="<?php echo esc_attr($item->ID); ?>">
                        <option value="url" <?php selected($interaction, 'url'); ?>><?php _e('URL', 'el_pomar'); ?></option>
                        <option value="megamenu" <?php selected($interaction, 'megamenu'); ?>><?php _e('Megamenú', 'el_pomar'); ?></option>
                    </select>
                    <div class="megamenu-options" id="megamenu-options-<?php echo esc_attr($item->ID); ?>" style="display: <?php echo $interaction === 'megamenu' ? 'block' : 'none'; ?>;">
                        <p>
                            <label>
                                <input type="radio" name="el_pomar_megamenu_type[<?php echo esc_attr($item->ID); ?>]" value="custom" <?php checked($megamenu_type, 'custom'); ?>>
                                <?php _e('Contenido personalizado', 'el_pomar'); ?>
                            </label>
                            <label>
                                <input type="radio" name="el_pomar_megamenu_type[<?php echo esc_attr($item->ID); ?>]" value="submenus" <?php checked($megamenu_type, 'submenus'); ?>>
                                <?php _e('Submenús', 'el_pomar'); ?>
                            </label>
                        </p>
                        <div class="custom-content" id="custom-content-<?php echo esc_attr($item->ID); ?>" style="display: <?php echo $megamenu_type === 'custom' ? 'block' : 'none'; ?>;">
                            <textarea name="el_pomar_custom_content[<?php echo esc_attr($item->ID); ?>]" rows="5" cols="50"><?php echo isset($custom_content[$item->ID]) ? esc_textarea($custom_content[$item->ID]) : ''; ?></textarea>
                        </div>
                        <div class="submenu-options" id="submenu-options-<?php echo esc_attr($item->ID); ?>" style="display: <?php echo $megamenu_type === 'submenus' ? 'block' : 'none'; ?>;">
                            <table class="form-table">
                                <tr>
                                    <th scope="row"><?php _e('Submenú 1', 'el_pomar'); ?></th>
                                    <td>
                                        <select name="el_pomar_submenus[<?php echo esc_attr($item->ID); ?>][submenu1]">
                                            <option value=""><?php _e('Seleccionar Menú', 'el_pomar'); ?></option>
                                            <?php foreach ($menus as $menu) : ?>
                                                <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected(isset($submenus[$item->ID]['submenu1']) ? $submenus[$item->ID]['submenu1'] : '', $menu->term_id); ?>>
                                                    <?php echo esc_html($menu->name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('Título del Submenú 1', 'el_pomar'); ?></th>
                                    <td>
                                        <input type="text" name="el_pomar_submenu_titles[<?php echo esc_attr($item->ID); ?>][submenu1]" value="<?php echo isset($submenu_titles[$item->ID]['submenu1']) ? esc_attr($submenu_titles[$item->ID]['submenu1']) : ''; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('Submenú 2', 'el_pomar'); ?></th>
                                    <td>
                                        <select name="el_pomar_submenus[<?php echo esc_attr($item->ID); ?>][submenu2]">
                                            <option value=""><?php _e('Seleccionar Menú', 'el_pomar'); ?></option>
                                            <?php foreach ($menus as $menu) : ?>
                                                <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected(isset($submenus[$item->ID]['submenu2']) ? $submenus[$item->ID]['submenu2'] : '', $menu->term_id); ?>>
                                                    <?php echo esc_html($menu->name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('Título del Submenú 2', 'el_pomar'); ?></th>
                                    <td>
                                        <input type="text" name="el_pomar_submenu_titles[<?php echo esc_attr($item->ID); ?>][submenu2]" value="<?php echo isset($submenu_titles[$item->ID]['submenu2']) ? esc_attr($submenu_titles[$item->ID]['submenu2']) : ''; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('Submenú 3', 'el_pomar'); ?></th>
                                    <td>
                                        <select name="el_pomar_submenus[<?php echo esc_attr($item->ID); ?>][submenu3]">
                                            <option value=""><?php _e('Seleccionar Menú', 'el_pomar'); ?></option>
                                            <?php foreach ($menus as $menu) : ?>
                                                <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected(isset($submenus[$item->ID]['submenu3']) ? $submenus[$item->ID]['submenu3'] : '', $menu->term_id); ?>>
                                                    <?php echo esc_html($menu->name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?php _e('Título del Submenú 3', 'el_pomar'); ?></th>
                                    <td>
                                        <input type="text" name="el_pomar_submenu_titles[<?php echo esc_attr($item->ID); ?>][submenu3]" value="<?php echo isset($submenu_titles[$item->ID]['submenu3']) ? esc_attr($submenu_titles[$item->ID]['submenu3']) : ''; ?>">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            <?php
        }
        echo '</table>';
    }
}

function el_pomar_custom_styles_callback() {
    $custom_styles = get_option('el_pomar_custom_styles', '');
    echo '<textarea name="el_pomar_custom_styles" rows="10" cols="50" class="large-text">' . esc_textarea($custom_styles) . '</textarea>';
    echo '<p>' . __('Agrega tus estilos CSS personalizados aquí. Estos estilos se aplicarán en el frontend.', 'el_pomar') . '</p>';
}

function el_pomar_terms_link_callback() {
    $option = get_option('el_pomar_terms_link');
    echo '<input type="url" name="el_pomar_terms_link" value="' . esc_attr($option) . '" class="regular-text">';
}

function el_pomar_privacy_link_callback() {
    $option = get_option('el_pomar_privacy_link');
    echo '<input type="url" name="el_pomar_privacy_link" value="' . esc_attr($option) . '" class="regular-text">';
}

function el_pomar_phone_number_callback() {
    $phone = get_option('el_pomar_phone_number');
    echo '<input type="tel" name="el_pomar_phone_number" value="' . esc_attr($phone) . '" class="regular-text">';
}

function el_pomar_whatsapp_number_callback() {
    $whatsapp = get_option('el_pomar_whatsapp_number');
    echo '<input type="tel" name="el_pomar_whatsapp_number" value="' . esc_attr($whatsapp) . '" class="regular-text">';
}

function el_pomar_sanitize_interactions($input) {
    $output = array();
    foreach ($input as $key => $value) {
        $output[$key] = sanitize_text_field($value);
    }
    return $output;
}

function el_pomar_sanitize_submenus($input) {
    $output = array();
    foreach ($input as $key => $value) {
        $output[$key] = array_map('sanitize_text_field', $value);
    }
    return $output;
}

function el_pomar_sanitize_custom_content($input) {
    $output = array();
    foreach ($input as $key => $value) {
        $output[$key] = wp_kses_post($value);
    }
    return $output;
}

function el_pomar_sanitize_submenu_titles($input) {
    $output = array();
    foreach ($input as $key => $value) {
        $output[$key] = array_map('sanitize_text_field', $value);
    }
    return $output;
}

function el_pomar_global_settings_page() {
    ?>
    <div class="wrap el-pomar-settings">
        <h1><?php _e('Configuraciones Globales', 'el_pomar'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('el_pomar_settings_group');
            do_settings_sections('el_pomar_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}