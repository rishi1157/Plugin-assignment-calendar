<?php 


function my_plugin_style()
{
    wp_enqueue_style('my_css', plugin_dir_path( __FILE__ ) . 'admin/css/style.css');
}
add_action('admin_enqueue_scripts', 'my_plugin_style');

