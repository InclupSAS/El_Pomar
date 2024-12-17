<?php
/**
 * Plugin Name: El Pomar
 * Plugin URI: https://inclup.com/
 * Description: Gestiona tu catalogo de productos, publica ofertas laborales, crea nuevas recetas y muestra las noticias de tu empresa.
 * Version: 2.4.6
 * Author: KerackDiaz
 * Author URI: https://github.com/KerackDiaz
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: El Pomar
 * Requires at least: 6.6.2
 * Requires PHP: 8.0
 * Requires WooCommerce: 9.0
 * Wordpress tested up to: 6.6.2
 * @package El_Pomar
 */

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!defined('EP_VERSION')) {
    define('EP_VERSION', '2.4.6');
}

if (!defined('EP_FILE')) {
    define('EP_FILE', __FILE__);
}

/** Define las constantes antes de usarlas */
define('EP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('EP_PLUGIN_DIR', plugin_dir_path(__FILE__));

if (!function_exists('is_plugin_active')) {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if (!class_exists('El_Pomar_Core')) {
    /**
     * Main Class start here
     */
    final class El_Pomar_Core {
        private static $instance = null;
    
        /**
         * Get plugin instance.
         * 
         * @return El_Pomar_Core
         * @static
         */
        public static function get_instance() {
            if (null === self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }
    
        /**
         * Constructor functions
         */
        private function __construct() {
            register_activation_hook(EP_FILE, array(__CLASS__, 'EP_activate'));
            register_deactivation_hook(EP_FILE, array(__CLASS__, 'EP_deactivate'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_styles'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
            add_action('wp_ajax_el_pomar_fetch_post_content', array($this, 'fetch_post_content'));
            add_action('wp_ajax_nopriv_el_pomar_fetch_post_content', array($this, 'fetch_post_content'));
            add_action('wp_ajax_el_pomar_handle_form_submission', 'el_pomar_handle_form_submission');
            add_action('wp_ajax_nopriv_el_pomar_handle_form_submission', 'el_pomar_handle_form_submission');
            add_action('wp_ajax_el_pomar_submit_application', 'el_pomar_register_applicant');
            add_action('wp_ajax_nopriv_el_pomar_submit_application', 'el_pomar_register_applicant');
            add_action('wp_enqueue_scripts', array($this, 'enqueue_custom_styles'));
            add_action('admin_footer', array($this, 'custom_admin_footer'));
            require_once EP_PLUGIN_DIR . 'includes/menu.php';
            require_once EP_PLUGIN_DIR . 'includes/pages/admin_page.php';
            include_once EP_PLUGIN_DIR . 'includes/pages/about.php';
            include_once EP_PLUGIN_DIR . 'includes/pages/home.php';
            include_once EP_PLUGIN_DIR . 'includes/pages/settings.php';
            include_once EP_PLUGIN_DIR . 'includes/pages/settings.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/catalog/catalog_post_type.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/catalog/catalog_front_render.php';
            include_once EP_PLUGIN_DIR . 'includes/pages/settings/catalog_settings.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/jobs/jobs_post_type.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/jobs/jobs_front_render.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/jobs/applicants.php'; 
            require_once EP_PLUGIN_DIR . 'includes/pages/applicants_list.php';
            require_once EP_PLUGIN_DIR . 'includes/pages/settings/jobs_settings.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/recipes/recipes_post_type.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/recipes/recipes_front_render.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/recipes/recipes_form_db.php';
            require_once EP_PLUGIN_DIR . 'includes/pages/recipes_form_list.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/news/news_post_type.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/core/menu-item-thumbnails.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/core/megamenu_front_render.php';
            require_once EP_PLUGIN_DIR . 'includes/pages/settings/global_settings.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/core/contact.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/core/product_redirect.php';
            require_once EP_PLUGIN_DIR . 'includes/functions/terms_and_Conditions/termsAndCondition_post_type.php';
        }

        /**
         * Función de activación del plugin
         */
        public static function EP_activate() {
            el_pomar_create_applicants_table();
            el_pomar_create_form_table();
        }

        /**
         * Función de desactivación del plugin
         */
        public static function EP_deactivate() {
            flush_rewrite_rules();
        }

        // Encolar el archivo CSS para el frontend
        public function enqueue_frontend_styles() {
            wp_enqueue_style('el_pomar-front-styles', plugin_dir_url(__FILE__) . 'assets/css/frontend/frontend-style.css');
            wp_enqueue_style('el_pomar-recipes-front-styles', plugin_dir_url(__FILE__) . 'assets/css/frontend/recipes-style.css');
            wp_enqueue_style('el_pomar-floating-button', plugin_dir_url(__FILE__) . 'assets/css/frontend/floating-button.css');
        }

        // Encolar el archivo CSS para el backend
        public function enqueue_admin_styles() {
            wp_enqueue_style('el_pomar-admin-styles', plugin_dir_url(__FILE__) . 'assets/css/admin/admin-style.css');
        }

        // Encolar los scripts para el backend
        public function enqueue_admin_scripts($hook) {
            echo "<script>console.log('Current hook: " . esc_js($hook) . "');</script>";
            wp_enqueue_script('el_pomar-core-tabs', plugin_dir_url(__FILE__) . 'assets/js/admin/admin-tabs.js', array(), '1.0.0', true);
            if ($hook === 'toplevel_page_el-pomar' || $hook === 'el-pomar_page_el-pomar-menu-settings') {
                wp_enqueue_script('el_pomar-global-settings', plugin_dir_url(__FILE__) . 'assets/js/admin/menu-settings.js', array('jquery'), '1.0.0', true);
            }
        }

        // Encolar los scripts para el frontend
        public function enqueue_frontend_scripts() {
            wp_enqueue_script('el_pomar_products', plugin_dir_url(__FILE__) . 'assets/js/frontend/products-frontend.js', array('jquery'), null, true);
            wp_enqueue_script('el_pomar-floating-button', plugin_dir_url(__FILE__) . 'assets/js/frontend/floating-button.js', array('jquery'), null, true);
            wp_enqueue_script('el_pomar-offert-functions', plugin_dir_url(__FILE__) . 'assets/js/frontend/offert-functions.js', ['jquery'], '1.0.0', true);
            wp_localize_script('el_pomar-offert-functions', 'el_pomar_core', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'plugin_url' => EP_PLUGIN_URL,
            ));
        }

        public function enqueue_custom_styles() {
            $custom_styles = get_option('el_pomar_custom_styles', '');
            if (!empty($custom_styles)) {
                wp_add_inline_style('el_pomar-front-styles', $custom_styles);
            }
        }

        // Función para manejar la solicitud AJAX de contenido de la oferta
        public function fetch_post_content() {
            if (!isset($_GET['post_id'])) {
                wp_send_json_error('No post ID provided');
            }

            $post_id = intval($_GET['post_id']);
            $post = get_post($post_id);

            if (!$post) {
                wp_send_json_error('Post not found');
            }

            wp_send_json_success(array(
                'content' => apply_filters('the_content', $post->post_content),
                'title' => $post->post_title,
                'button' => '<button id="apply-button" data-post-id="' . esc_attr($post_id) . '">Postularme</button>'
            ));
        }

        public function custom_admin_footer() {
            $screen = get_current_screen();
            $post_types = array('el_pomar', 'mulai', 'levelma', 'jobs', 'recipes', 'news');
    
            if (in_array($screen->post_type, $post_types)) {
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const wpFooter = document.getElementById("wpfooter");
                        if (wpFooter) {
                            const customFooter = \'<div class="footer" style="text-align: center; display: flex; flex-direction: row; align-items: center; align-content: center; flex-wrap: wrap; gap: 10px;">\' +
                                \'<hr style="width: 100%;">\' +
                                \'<p>Desarrollado por <a href="https://github.com/kerackdiaz" target="_blank" rel="nofollow">Kerack Diaz</a></p>\' +
                                \'<p>&copy; 2024 <a href="https://inclup.com/" target="_blank" rel="nofollow">Inclup S.A.S</a>. Todos los derechos reservados.</p>\' +
                                \'</div>\';
                            wpFooter.insertAdjacentHTML("afterbegin", customFooter);
                        }
                    });
                </script>';
            }
        }

    }

    El_Pomar_Core::get_instance();
}

