<?php
/*
Plugin Name: 子比抽奖
Description: 子比抽奖插件 支持自定义奖品 自定义几率 自定义通知 
Author: 泽客
Version:10
*/

$functions = array(
    'admin-options',
);

foreach ($functions as $function) {
    $path = 'inc/options/' . $function . '.php';
    require get_theme_file_path($path);
}

//使用Font Awesome 4
add_filter('csf_fa4', '__return_true');

function my_custom_icons($icons)
{
    $icons[] = array(
        'title' => '主题内置SVG图标',
        'icons' => array(
            'zibsvg-like',
            'zibsvg-view',
            'zibsvg-comment',
            'zibsvg-time',
            'zibsvg-search',
            'zibsvg-money',
            'zibsvg-right',
            'zibsvg-left',
            'zibsvg-reply',
            'zibsvg-circle',
            'zibsvg-close',
            'zibsvg-add',
            'zibsvg-add-ring',
            'zibsvg-post',
            'zibsvg-posts',
            'zibsvg-huo',
            'zibsvg-favorite',
            'zibsvg-menu',
            'zibsvg-d-qq',
            'zibsvg-d-weibo',
            'zibsvg-d-wechat',
            'zibsvg-d-email',
            'zibsvg-user',
            'zibsvg-theme',
            'zibsvg-signout',
            'zibsvg-set',
            'zibsvg-signup',
            'zibsvg-user_rp',
            'zibsvg-pan_baidu',
            'zibsvg-lanzou',
            'zibsvg-onedrive',
            'zibsvg-tianyi',
            'zibsvg-menu_2',
            'zibsvg-alipay',
            'zibsvg-baidu',
            'zibsvg-gitee',
            'zibsvg-comment-fill',
            'zibsvg-private',
            'zibsvg-hot-fill',
            'zibsvg-hot',
            'zibsvg-topping',
            'zibsvg-topic',
            'zibsvg-plate-fill',
            'zibsvg-extra-points',
            'zibsvg-deduct-points',
            'zibsvg-points',
            'zibsvg-tags',
            'zibsvg-user-auth',
            'zibsvg-vip_1',
            'zibsvg-vip_2',
            'zibsvg-qzone-color',
            'zibsvg-qq-color',
            'zibsvg-weibo-color',
            'zibsvg-poster-color',
            'zibsvg-copy-color',
            'zibsvg-user-color',
            'zibsvg-user-color-2',
            'zibsvg-add-color',
            'zibsvg-home-color',
            'zibsvg-money-color',
            'zibsvg-order-color',
            'zibsvg-gift-color',
            'zibsvg-security-color',
            'zibsvg-trend-color',
            'zibsvg-msg-color',
            'zibsvg-tag-color',
            'zibsvg-comment-color',
            'zibsvg-wallet-color',
            'zibsvg-money-color-2',
            'zibsvg-merchant-color',
            'zibsvg-points-color',
            'zibsvg-book-color',
            'zibsvg-ontop-color',
        ),
    );

    $icons = array_reverse($icons);
    return $icons;
}
add_filter('csf_field_icon_add_icons', 'my_custom_icons');

//定义文件夹
function csf_custom_csf_override()
{
    return 'inc/csf-framework';
}
add_filter('csf_override', 'csf_custom_csf_override');

//自定义css、js
function csf_add_custom_wp_enqueue()
{
    // Style
    wp_enqueue_style('csf_custom_css', plugin_dir_path( __FILE__ ) . '/inc/csf-framework/assets/css/style.min.css',array(), THEME_VERSION);
    // Script
    wp_enqueue_script('csf_custom_js', plugin_dir_path( __FILE__ ) . '/inc/csf-framework/assets/js/main.min.js', array('jquery'), THEME_VERSION);
}
add_action('csf_enqueue', 'csf_add_custom_wp_enqueue');

//获取主题设置链接
function zib_get_admin_csf_url($tab = '')
{
    $tab_array          = explode("/", $tab);
    $tab_array_sanitize = array();
    foreach ($tab_array as $tab_i) {
        $tab_array_sanitize[] = sanitize_title($tab_i);
    }
    $tab_attr = esc_attr(implode("/", $tab_array_sanitize));
    $url      = add_query_arg('page', 'RYtheme', admin_url('admin.php'));
    $url      = $tab ? $url . '#tab=' . $tab_attr : $url;
    return esc_url($url);
}

// 获取及设置主题配置参数
function _chojiang($name, $default = false, $subname = '')
{
    //声明静态变量，加速获取
    static $zib_get_option = null;
    if ($zib_get_option) {
        $options = $zib_get_option;
    } else {
        $zib_get_option = get_option('RYtheme');
    }
    if (isset($options[$name])) {
        if ($subname) {
            return isset($options[$name][$subname]) ? $options[$name][$subname] : $default;
        } else {
            return $options[$name];
        }
    }
    return $default;
}

function _spz($name, $value)
{
    $get_option        = get_option('RYtheme');
    $get_option        = is_array($get_option) ? $get_option : array();
    $get_option[$name] = $value;
    return update_option('RYtheme', $get_option);
}

//获取及设置压缩后的posts_meta
if (!function_exists('of_get_posts_meta')) {
    function of_get_posts_meta($name, $key, $default = false, $post_id = '')
    {
        global $post;
        $post_id  = $post_id ? $post_id : $post->ID;
        $get_mate = get_post_meta($post_id, $name, true);
        if (isset($get_mate[$key])) {
            return $get_mate[$key];
        }
        return $default;
    }
}

if (!function_exists('of_set_posts_meta')) {
    function of_set_posts_meta($post_id = '', $name, $key, $value)
    {
        if (!$name) {
            return false;
        }
        global $post;
        $post_id        = $post_id ? $post_id : $post->ID;
        $get_mate       = get_post_meta($post_id, $name, true);
        $get_mate       = (array) $get_mate;
        $get_mate[$key] = $value;
        return update_post_meta($post_id, $name, $get_mate);
    }
}



