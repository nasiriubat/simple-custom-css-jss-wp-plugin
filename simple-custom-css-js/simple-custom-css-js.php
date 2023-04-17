<?php
/*
 * Simple Custom CSS/JS
 * Plugin Name: Simple Custom CSS/JS
 * Plugin URI: https://github.com/nasiriubat/simple-custom-css-jss-wp-plugin
 * Description: Adds custom CSS and JS to your WordPress site
 * Version: 1.0.0
 * Author: Nasir Uddin Shuvo
 * Author URI: https://github.com/nasiriubat
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: classic-editor
 * Requires at least: 4.9
 * Requires PHP: 5.2.4
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

function custom_css_js_scripts()
{
    $custom_css = get_option('custom-css');
    $custom_js = get_option('custom-js');
    wp_enqueue_style('custom-css', plugin_dir_url(__FILE__) . 'css/custom.css');
    wp_enqueue_script('custom-js', plugin_dir_url(__FILE__) . 'js/custom.js');
    file_put_contents(plugin_dir_path(__FILE__) . 'css/custom.css', $custom_css);
    file_put_contents(plugin_dir_path(__FILE__) . 'js/custom.js', $custom_js);
    // wp_add_inline_style('custom-css', $custom_css);
    // wp_add_inline_script('custom-js', $custom_js);
}
add_action('wp_footer', 'custom_css_js_scripts');


//submenu

function custom_css_js_settings_page()
{
    add_submenu_page(
        'options-general.php', // parent menu slug
        'Custom CSS/JS Settings', // page title
        'Custom CSS/JS', // menu title
        'manage_options', // capability required to access the page
        'custom-css-js-settings', // menu slug
        'custom_css_js_settings_page_callback' // callback function that outputs the page content
    );
}
add_action('admin_menu', 'custom_css_js_settings_page');

//form
function custom_css_js_settings_page_callback()
{
?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields('custom-css-js-settings-group'); ?>
            <?php do_settings_sections('custom-css-js-settings-group'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="custom-css"><?php _e('Custom CSS', 'custom-css-js'); ?></label></th>
                    <td><textarea id="custom-css" name="custom-css" rows="10" cols="50"><?php echo esc_attr(get_option('custom-css')); ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row"><label for="custom-js"><?php _e('Custom JS', 'custom-css-js'); ?></label></th>
                    <td><textarea id="custom-js" name="custom-js" rows="10" cols="50"><?php echo esc_attr(get_option('custom-js')); ?></textarea></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

//register setting
function custom_css_js_register_settings()
{
    register_setting(
        'custom-css-js-settings-group', // option group
        'custom-css' // option name
    );
    register_setting(
        'custom-css-js-settings-group', // option group
        'custom-js' // option name
    );
}
add_action('admin_init', 'custom_css_js_register_settings');


?>