<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

class Modo_Debug {

    public static $instance = null;

    /**
     * get_instance
     *
     * @return Modo_Debug
     */
    public static function get_instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * __construct
     *
     * @return void
     */
    public function __construct() {

        // Show current template
        add_action('admin_bar_menu', [$this, 'show_current_template'], 100);

        // Show post metas
        add_action('add_meta_boxes', [$this, 'show_post_meta']);
    }


    /**
     * show_current_template
     *
     * @return void
     */
    public function show_current_template($admin_bar) {

        global $template;

        if ($template === null) {
            return;
        }

        $tempalte_tab = explode('/', $template);
        $template_name = end($tempalte_tab);

        $admin_bar->add_menu(array(
            'id'     => 'modo-show-current-template',
            'title'  => 'Template : ' . $template_name,
        ));

        $template_path = str_replace(WP_CONTENT_DIR, '', $template);
        $admin_bar->add_menu(array(
            'id'     => 'modo-show-current-template-path',
            'parent' => 'modo-show-current-template',
            'title'  => 'Chemin : ' . $template_path,
        ));
    }

    /**
     * show_post_meta
     *
     * @return void
     */
    public function show_post_meta() {
        add_meta_box('modo-post-meta', 'Post meta', [$this, 'show_post_meta_callback'], array_keys(get_post_types()), 'advanced', 'low' );
    }

    /**
     * show_post_meta_callback
     *
     * @return void
     */
    public function show_post_meta_callback() {

        global $post;

        if (empty($post) || !is_numeric($post->ID)) {
            return;
        }

        $metas = get_post_meta($post->ID);

        if (!empty($metas)) {
            echo '<table class="wp-list-table widefat fixed striped">';
            echo '<thead>';
            echo '<tr>';
            echo '<th width="33%">Key</th>';
            echo '<th width="67%">Value</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($metas as $meta_name => $meta_value) {

                $meta_value = $meta_value[0];

                echo '<tr>';
                echo '<td width="33%">' . $meta_name . '</td>';
                if (is_serialized($meta_value)) {
                    $array = unserialize($meta_value);
                    echo '<td width="67%"><pre>' . var_export($array, true) . '</pre></td>';
                } else {
                    echo '<td width="67%">' . $meta_value . '</td>';
                }
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
    }
}
