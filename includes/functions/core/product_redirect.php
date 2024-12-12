<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function pomar_redirect_single_product() {
    if (is_singular('el_pomar') || is_singular('mulai') || is_singular('levelma')) {
        global $post;
        $post_type = get_post_type($post);
        $post_type_slug = '';

        switch ($post_type) {
            case 'el_pomar':
                $post_type_slug = 'El_Pomar';
                break;
            case 'mulai':
                $post_type_slug = 'Mulai';
                break;
            case 'levelma':
                $post_type_slug = 'Levelma';
                break;
        }

        if ($post_type_slug) {
            $hash = '#' . $post_type_slug . '/' . $post->post_name;
            wp_redirect(home_url('/nuestras-marcas/' . $hash));
            exit();
        }
    }
}
add_action('template_redirect', 'pomar_redirect_single_product');