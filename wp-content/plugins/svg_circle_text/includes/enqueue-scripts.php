<?php


function svg_circle_text_enqueue_scripts($ip)
{
    global $ip;

    wp_enqueue_style('svg-circle-text-style', str_replace('localhost', $ip, plugin_dir_url(__FILE__)) . '../style.css');
    wp_enqueue_script('svg-circle-text-script', str_replace('localhost', $ip, plugin_dir_url(__FILE__)) . '../main.js');

    $rotation_speed = get_option('svg_circle_text_rotation_speed', '20');
    $rotation_direction = get_option('svg_circle_text_rotation_direction', 'normal');
    $text_color = get_option('svg_circle_text_text_color', 'black');

    wp_add_inline_style('svg-circle-text-style', "@keyframes rotate { 0% { transform: rotate(0deg); } 50% { transform: rotate(" . ($rotation_direction == 'normal' ? '-180deg' : '180deg') . "); } 100% { transform: rotate(" . ($rotation_direction == 'normal' ? '-360deg' : '360deg') . "); } } .svg-container path, .svg-container text { animation: rotate {$rotation_speed}s linear infinite;} .svg-container text { fill: {$text_color}; }");
}   


add_action('wp_enqueue_scripts', 'svg_circle_text_enqueue_scripts');

