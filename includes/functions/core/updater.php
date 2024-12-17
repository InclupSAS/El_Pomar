<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

class El_Pomar_GitHub_Updater {
    private $file;
    private $plugin;
    private $basename;
    private $active;
    private $github_response;
    private $github_repo = 'El_Pomar';
    private $github_user = 'InclupSAS';
    private $access_token = '';

    public function __construct($file) {
        $this->file = $file;
        $this->initialize();
    }

    private function initialize() {
        if (is_admin()) {
            add_action('admin_init', array($this, 'set_plugin_properties'));
            add_filter('pre_set_site_transient_update_plugins', array($this, 'check_update'));
            add_filter('plugins_api', array($this, 'plugin_popup'), 10, 3);
            add_filter('upgrader_post_install', array($this, 'after_install'), 10, 3);
            add_action('admin_notices', array($this, 'show_update_notification'));
        }
    }

    public function set_plugin_properties() {
        if (!function_exists('get_plugin_data')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        $this->plugin = get_plugin_data($this->file);
        $this->basename = plugin_basename($this->file);
        $this->active = is_plugin_active($this->basename);
    }

    private function get_repository_info() {
        if (is_null($this->github_response)) {
            $request_uri = sprintf('https://api.github.com/repos/%s/%s/releases/latest', 
                $this->github_user, $this->github_repo);
            
            $args = array(
                'headers' => array(
                    'Accept' => 'application/vnd.github.v3+json',
                    'User-Agent' => 'WordPress/' . get_bloginfo('version')
                )
            );

            if ($this->access_token) {
                $args['headers']['Authorization'] = "Bearer {$this->access_token}";
            }

            $response = wp_remote_get($request_uri, $args);

            if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
                return false;
            }

            $response_data = json_decode(wp_remote_retrieve_body($response));

            if (json_last_error() === JSON_ERROR_NONE && is_object($response_data)) {
                $this->github_response = $response_data;
            }
        }
    }

    public function check_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }

        $this->get_repository_info();

        if (!empty($this->github_response)) {
            $version = ltrim($this->github_response->tag_name, 'vV');
            $current_version = isset($this->plugin['Version']) ? $this->plugin['Version'] : null;

            if ($current_version && version_compare($version, $current_version, '>')) {
                $plugin = array(
                    'url' => $this->plugin["PluginURI"],
                    'slug' => current(explode('/', $this->basename)),
                    'package' => $this->github_response->zipball_url,
                    'new_version' => $version,
                    'tested' => isset($this->plugin['Tested up to']) ? $this->plugin['Tested up to'] : ''
                );

                $transient->response[$this->basename] = (object) $plugin;
            }
        }

        return $transient;
    }

    public function plugin_popup($result, $action, $args) {
        if ($action !== 'plugin_information') {
            return $result;
        }

        if (!isset($args->slug) || $args->slug != current(explode('/', $this->basename))) {
            return $result;
        }

        $this->get_repository_info();

        if (!empty($this->github_response)) {
            return (object) array(
                'name'              => $this->plugin["Name"],
                'slug'              => $this->basename,
                'version'           => ltrim($this->github_response->tag_name, 'vV'),
                'author'            => $this->plugin["Author"],
                'author_profile'    => $this->plugin["AuthorURI"],
                'last_updated'      => $this->github_response->published_at,
                'homepage'          => $this->plugin["PluginURI"],
                'short_description' => $this->plugin["Description"],
                'sections'          => array(
                    'Description'   => $this->plugin["Description"],
                    'Updates'       => $this->github_response->body,
                    'Changelog'     => $this->github_response->body
                ),
                'download_link'     => $this->github_response->zipball_url,
                'requires'          => $this->plugin['Requires at least'],
                'tested'           => $this->plugin['Tested up to'],
                'requires_php'     => $this->plugin['Requires PHP']
            );
        }

        return $result;
    }

    public function after_install($response, $hook_extra, $result) {
        global $wp_filesystem;
        $install_directory = plugin_dir_path($this->file);
        
        if ($wp_filesystem->exists($install_directory)) {
            $wp_filesystem->delete($install_directory, true);
        }

        $wp_filesystem->move($result['destination'], $install_directory);
        $result['destination'] = $install_directory;

        if ($this->active) {
            activate_plugin($this->basename);
        }

        return $result;
    }

    public function show_update_notification() {
        if (!current_user_can('update_plugins')) {
            return;
        }

        $this->get_repository_info();

        if (!empty($this->github_response)) {
            $version = ltrim($this->github_response->tag_name, 'vV');
            if (isset($this->plugin['Version']) && version_compare($version, $this->plugin['Version'], '>')) {
                $update_url = wp_nonce_url(
                    add_query_arg(
                        array(
                            'action' => 'upgrade-plugin',
                            'plugin' => $this->basename
                        ),
                        admin_url('update.php')
                    ),
                    'upgrade-plugin_' . $this->basename
                );

                printf(
                    '<div class="notice notice-warning"><p>Hay una actualización disponible para %1$s. <a href="%2$s">Actualizar a la versión %3$s</a></p></div>',
                    esc_html($this->plugin['Name']),
                    esc_url($update_url),
                    esc_html($version)
                );
            }
        }
    }

    public function maybe_update_plugin() {
        $this->get_repository_info();

        if (!empty($this->github_response)) {
            $version = ltrim($this->github_response->tag_name, 'vV');
            if (isset($this->plugin['Version']) && version_compare($version, $this->plugin['Version'], '>')) {
                // Ejecutar la actualización del plugin
                $this->update_plugin();
            }
        }
    }

    private function update_plugin() {
        // Lógica para actualizar el plugin
    }
}

function initialize_el_pomar_updater() {
    $updater = new El_Pomar_GitHub_Updater(EP_FILE);
    $updater->maybe_update_plugin();
}
add_action('init', 'initialize_el_pomar_updater');