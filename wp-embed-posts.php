<?php

/**
 * Plugin Name: WP Embed Posts
 * Author: TJ Webb
 * Author URI: http://webb.tj/
 * Version: 1.0.0
 * Description: Embed Posts (or any post type) into the content of another post. Adds a TinyMCE button and quick code for embedding. Also adds a hook to allow developers to customize the output of the embed.
 * TODO:    Better Icon
 *          Docs
 */

class WPEmbedPosts{

    public static function activate(){
        if(false===get_option('wp_embed_post_enabled')){
            update_option('wp_embed_post_enabled', array('post'=>1, 'page'=>1));
        }
    }

    public static function add_mce_button(){
        if ( get_user_option('rich_editing') == 'true') {
            add_filter('mce_external_plugins', array('WPEmbedPosts', 'add_plugin'));
            add_filter('mce_buttons', array('WPEmbedPosts', 'register_button'));
        }
    }

    public static function add_plugin($plugin_array) {
        $plugin_array['wpembedposts'] = plugins_url('wp-embed-posts') . '/editor_plugin.js';
        return $plugin_array;
    }

    public static function register_button($buttons) {
        array_push($buttons, "separator", "wpembedposts");
        return $buttons;
    }

    public static function get_posts(){
        $enabled = '"' . implode('","', array_keys(get_option('wp_embed_post_enabled'))) . '"';
        global $wpdb, $wp_post_types;
        $sql = "SELECT ID, post_type, post_title FROM {$wpdb->prefix}posts
        WHERE post_status='publish' AND post_type IN ($enabled)
        ORDER BY post_type, post_date";
        $results = $wpdb->get_results($sql, ARRAY_A);
        $posts = false;
        if(!empty($results)){
            foreach($results as $record){
                $posts[ $wp_post_types[$record['post_type']]->labels->name ][$record['ID']] = $record['post_title'];
            }
        }
        return $posts;
    }

    public static function short_code($atts){
        extract(shortcode_atts(array('id'=>false), $atts));
        global $post;
        if($post->ID==$id)
            return;
        global $wp_embed_post_ids;
        if(is_array($wp_embed_post_ids))
            if(in_array($id, $wp_embed_post_ids))
                return;
        $wp_embed_post_ids[] = $id;
        if($id){
            $post_obj = get_post($id);
            $output = '<h2>' . $post_obj->post_title . '</h2>';
            $output .= apply_filters('the_content', $post_obj->post_content);
            $output = apply_filters('wpembed_content', $output, $post_obj, $post_obj->post_type);
            return $output;
        }
    }

    public static function settings_enabled_callback() {
        $post_types = get_post_types();
        $options = get_option('wp_embed_post_enabled');
        $banned_post_types = array('attachment', 'revision', 'nav_menu_item');
        foreach($post_types as $post_type){
            if(!in_array($post_type, $banned_post_types))
                echo '<input name="wp_embed_post_enabled['.$post_type.']" id="wp_embed_post_enabled-'.$post_type.'" type="checkbox" value="1" class="code" ' . checked( 1, $options[$post_type], false ) . ' /> ' . get_post_type_object($post_type)->labels->name . '<br>';
        }
    }

    public static function settings_enabled_section_callback() {
        echo '<p>Check off any post types that can be embeded into other post types.</p>';
    }

    public static function settings_enabled_init(){
        add_settings_section('wp_embed_post_enabled_setting_section',
            'Enable/disable which post types may be embeded',
            array('WPEmbedPosts', 'settings_enabled_section_callback'),
            'wp_embed_post_enabled');

        add_settings_field('wp_embed_post_enabled',
            'Enabled Post Types',
            array('WPEmbedPosts', 'settings_enabled_callback'),
            'wp_embed_post_enabled',
            'wp_embed_post_enabled_setting_section');

        register_setting('wp_embed_post_enabled','wp_embed_post_enabled');
    }

    public static function settings_enabled_submenu(){
        add_options_page('Embed Post Options', 'Embed Post Options', 'manage_options', 'wp_embed_post_enabled', array('WPEmbedPosts', 'settings_enabled_page'));
    }

    public static function settings_enabled_page(){
        ?>
        <div class="wrap">
            <h2><?php echo __('WP Embed Post Settings'); ?></h2>
            <form method="post" action="options.php"> 
                <?php if (current_user_can('manage_options')) { ?>
                    <?php settings_fields('wp_embed_post_enabled'); ?>
                    <?php do_settings_sections( 'wp_embed_post_enabled' ); ?>
                    <?php submit_button(); ?>
                <?php } ?>
            </form>
        </div>
        <?php
    }
}

add_action('init', array('WPEmbedPosts', 'add_mce_button'));
add_action('admin_init', array('WPEmbedPosts', 'settings_enabled_init'));
add_action('admin_menu', array('WPEmbedPosts', 'settings_enabled_submenu'));
add_shortcode('embedpost', array('WPEmbedPosts', 'short_code'));
register_activation_hook(__FILE__, array('WPEmbedPosts', 'activate'));

/*add_filter('wpembed_content', 'test_func', 10, 3);
function test_func($output, $post_obj, $post_type){
    return $output;
}*/