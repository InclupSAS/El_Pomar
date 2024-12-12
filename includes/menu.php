<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!function_exists('Pomar_core_menu')) {
    function Pomar_core_menu() {
        // Menú principal para la administración del plugin
        add_menu_page(
            'El Pomar',
            'El Pomar',
            'manage_options',
            'el-pomar',
            'Pomar_core_admin_page',
            plugin_dir_url(__FILE__) . '../assets/img/logo.svg',
            30
        );

        add_submenu_page(
            'el-pomar',
            'Configuraciones',
            'Configuraciones',
            'manage_options',
            'el-pomar-menu-settings',
            'el_pomar_global_settings_page'
        );

        add_submenu_page(
            'el-pomar',
            'Acerca del Plugin',
            'Acerca del Plugin',
            'manage_options',
            'el-pomar-about',
            'Pomar_core_about_page'
        );

        // Menú para productos
        add_menu_page(
            'Productos',
            'Productos',
            'manage_options',
            'productos',
            'Pomar_core_catalog_settings_page',
            'dashicons-products',
            31
        );
        add_submenu_page(
            'productos',
            'El Pomar',
            'El Pomar',
            'manage_options',
            'edit.php?post_type=el_pomar'
        );

        add_submenu_page(
            'productos',
            'Categorías El Pomar',
            'Categorías El Pomar',
            'manage_options',
            'edit-tags.php?taxonomy=el_pomar_category&post_type=el_pomar'
        );

        add_submenu_page(
            'productos',
            'Mulai',
            'Mulai',
            'manage_options',
            'edit.php?post_type=mulai'
        );

        add_submenu_page(
            'productos',
            'Categorías Mulai',
            'Categorías Mulai',
            'manage_options',
            'edit-tags.php?taxonomy=mulai_category&post_type=mulai'
        );

        add_submenu_page(
            'productos',
            'Levelma',
            'Levelma',
            'manage_options',
            'edit.php?post_type=levelma'
        );

        add_submenu_page(
            'productos',
            'Categorías Levelma',
            'Categorías Levelma',
            'manage_options',
            'edit-tags.php?taxonomy=levelma_category&post_type=levelma'
        );

        // Menú para ofertas laborales
        add_menu_page(
            'Ofertas Laborales',
            'Ofertas Laborales',
            'manage_options',
            'ofertas-laborales',
            'el_pomar_jobs_settings_page',
            'dashicons-id-alt',
            32
        );

        add_submenu_page(
            'ofertas-laborales',
            'Ofertas de Trabajo',
            'Ofertas de Trabajo',
            'manage_options',
            'edit.php?post_type=jobs'
        );

        add_submenu_page(
            'ofertas-laborales',
            'Cargos',
            'Cargos',
            'manage_options',
            'edit-tags.php?taxonomy=job_category&post_type=jobs'
        );

        add_submenu_page(
            'ofertas-laborales',
            'Postulantes',
            'Postulantes',
            'manage_options',
            'el_pomar_applicants',
            'el_pomar_applicants_page'
        );

        add_menu_page(
            'Recetas',
            'Recetas',
            'manage_options',
            'edit.php?post_type=recipes',
            '',
            'dashicons-carrot',
            33
        );
        
        add_submenu_page(
            'edit.php?post_type=recipes',
            'Categorías de Recetas',
            'Categorías de Recetas',
            'manage_options',
            'edit-tags.php?taxonomy=recipe_category&post_type=recipes'
        );
        
        add_submenu_page(
            'edit.php?post_type=recipes',
            'Etiquetas de Recetas',
            'Etiquetas de Recetas',
            'manage_options',
            'edit-tags.php?taxonomy=recipe_tags&post_type=recipes'
        );

        add_submenu_page(
            'edit.php?post_type=recipes',
            'Formulario de Descarga',
            'Formulario de Descarga',
            'manage_options',
            'recipes_form_list',
            'el_pomar_form_submissions_page'
        );

        // Menú para noticias
        add_menu_page(
            'Noticias',
            'Noticias',
            'manage_options',
            'edit.php?post_type=news',
            '',
            'dashicons-megaphone',
            34
        );
    }
    add_action('admin_menu', 'Pomar_core_menu');
}

