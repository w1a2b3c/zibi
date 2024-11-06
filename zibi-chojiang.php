<?php
/*
Plugin Name: 子比抽奖
Description: 子比抽奖插件 支持自定义奖品 自定义几率 自定义通知 
Author: 刀客源码网
Version:2.0.3
*/

if ( ! function_exists( 'RYtheme' ) ) {
/*
*主题核心变量 修改就爆炸！
*/
  function RYtheme( $option = '', $default = null ) {
    $options = get_option( 'RYtheme' ); // Attention: Set your unique id of the framework
    return ( isset( $options[$option] ) ) ? $options[$option] : $default;
  }
}
add_filter('use_block_editor_for_post', '__return_false');  

/*
*引入核心文件
*/
require_once plugin_dir_path(__FILE__) .'inc/ajax.php';
// require_once plugin_dir_path(__FILE__) .'inc/sever.php';
require_once plugin_dir_path(__FILE__) .'inc/codestar-framework/codestar-framework.php';
require_once plugin_dir_path(__FILE__) .'inc/options/admin-options.php';
/*
*创建抽奖自定义模板 修改就爆炸
*/
class PageTemplater {

	/**
	 * A reference to an instance of this class.
	 */
	private static $instance;

	/**
	 * The array of templates that this plugin tracks.
	 */
	protected $templates;

	/**
	 * Returns an instance of this class. 
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new PageTemplater();
		} 

		return self::$instance;

	} 

	/**
	 * Initializes the plugin by setting filters and administration functions.
	 */
	private function __construct() {

		$this->templates = array();


		// Add a filter to the attributes metabox to inject template into the cache.
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {

			// 4.6 and older
			add_filter(
				'page_attributes_dropdown_pages_args',
				array( $this, 'register_project_templates' )
			);

		} else {

			// Add a filter to the wp 4.7 version attributes metabox
			add_filter(
				'theme_page_templates', array( $this, 'add_new_template' )
			);

		}

		// Add a filter to the save post to inject out template into the page cache
		add_filter(
			'wp_insert_post_data', 
			array( $this, 'register_project_templates' ) 
		);


		// Add a filter to the template include to determine if the page has our 
		// template assigned and return it's path
		add_filter(
			'template_include', 
			array( $this, 'view_project_template') 
		);


		// Add your templates to this array.
		$this->templates = array(
			'page/chojiang.php' => '刀客源码-子比抽奖',
			
		);
			
	} 

	/**
	 * Adds our template to the page dropdown for v4.7+
	 *
	 */
	public function add_new_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );
		return $posts_templates;
	}

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doens't really exist.
	 */
	public function register_project_templates( $atts ) {

		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieve the cache list. 
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		} 

		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key , 'themes');

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->templates );

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;

	} 

	/**
	 * Checks if the template is assigned to the page
	 */
	public function view_project_template( $template ) {
		
		// Get global post
		global $post;

		// Return template if post is empty
		if ( ! $post ) {
			return $template;
		}

		// Return default template if we don't have a custom one defined
		if ( ! isset( $this->templates[get_post_meta( 
			$post->ID, '_wp_page_template', true 
		)] ) ) {
			return $template;
		} 

		$file = plugin_dir_path( __FILE__ ). get_post_meta( 
			$post->ID, '_wp_page_template', true
		);

		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file;
		}

		// Return template
		return $template;

	}

} 
add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );

/**
 * 注册插件固定管理链接
 */
add_filter( 'plugin_action_links', 'ttt_wpmdr_add_action_plugin', 10, 5 );

function ttt_wpmdr_add_action_plugin( $actions, $plugin_file ) 
{
   static $plugin;
   if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);
   if ($plugin == $plugin_file) {
      $site_link = array('support' => '<a href="/wp-admin/admin.php?page=RYtheme#tab=%e9%bb%98%e8%ae%a4%e9%85%8d%e7%bd%ae">设置</a>');
      $settings = array('settings' => '<a style="color: #FCB214;" href="https://www.dkewl.com" target="_blank">帮助</a>');
      $actions = array_merge($settings, $actions);
      $actions = array_merge($site_link, $actions);
   }
   return $actions;
}
/**
 * 注册插件数据库表格  修改弹幕就爆炸
 */
function zeke_chojiang()
{      
  global $wpdb; 
  $db_table_name = $wpdb->prefix . 'zeke_chojiang';  // 数据库名
  $charset_collate = $wpdb->get_charset_collate();
 
 //检查是否存在数据库表 
if($wpdb->get_var( "show tables like '$db_table_name'" ) != $db_table_name ) 
 {
       $sql = "CREATE TABLE $db_table_name (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `chojiang_user` varchar(2550) DEFAULT NULL COMMENT '奖品用户',
                    `chojiang_type` varchar(50) DEFAULT NULL COMMENT '奖品类型',
                    `chojiang_shu` int(11) DEFAULT 0 COMMENT '奖励数额',
                    `title` longtext DEFAULT NULL COMMENT '奖品标题',
                    `content` longtext DEFAULT NULL COMMENT '内容',  
                    `create_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '奖品时间',
                    `modified_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
                    PRIMARY KEY (`id`)
        ) $charset_collate;";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
   add_option( 'test_db_version', $test_db_version );
 }
} 
register_activation_hook( __FILE__, 'zeke_chojiang' );

//主题新安装通知  
add_action('admin_notices', 'ssss_admin_notice');
function ssss_admin_notice() {
	global $current_user ;
        $user_id = $current_user->ID;
	if ( ! get_user_meta($user_id, 'chojiang_notices_1') ) {
	           $con = '<div class="notice notice-success is-dismissible"><div id="authorization_form" style="max-width: 100%;" class="ajax-form" ">
            <div class="ok-icon"><svg t="1585712312243" class="icon" style="width: 1em; height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3845" data-spm-anchor-id="a313x.7781069.0.i0"><path d="M115.456 0h793.6a51.2 51.2 0 0 1 51.2 51.2v294.4a102.4 102.4 0 0 1-102.4 102.4h-691.2a102.4 102.4 0 0 1-102.4-102.4V51.2a51.2 51.2 0 0 1 51.2-51.2z m0 0" fill="#FF6B5A" p-id="3846"></path><path d="M256 13.056h95.744v402.432H256zM671.488 13.056h95.744v402.432h-95.744z" fill="#FFFFFF" p-id="3847"></path><path d="M89.856 586.752L512 1022.72l421.632-435.2z m0 0" fill="#6DC1E2" p-id="3848"></path><path d="M89.856 586.752l235.52-253.952h372.736l235.52 253.952z m0 0" fill="#ADD9EA" p-id="3849"></path><path d="M301.824 586.752L443.136 332.8h137.216l141.312 253.952z m0 0" fill="#E1F9FF" p-id="3850"></path><path d="M301.824 586.752l209.92 435.2 209.92-435.2z m0 0" fill="#9AE6F7" p-id="3851"></path></svg></div>
            <p style=" color: #d63638; font-size: 15px; "><svg class="icon" style="width: 1em;height: 1em;vertical-align: -.2em;fill: currentColor;overflow: hidden;font-size: 1.4em;" viewBox="0 0 1024 1024"><path d="M492.224 6.72c11.2-8.96 26.88-8.96 38.016 0l66.432 53.376c64 51.392 152.704 80.768 243.776 80.768 27.52 0 55.104-2.624 81.92-7.872a30.08 30.08 0 0 1 24.96 6.4 30.528 30.528 0 0 1 11.008 23.424V609.28c0 131.84-87.36 253.696-228.288 317.824L523.52 1021.248a30.08 30.08 0 0 1-24.96 0l-206.464-94.08C151.36 862.976 64 741.12 64 609.28V162.944a30.464 30.464 0 0 1 36.16-29.888 425.6 425.6 0 0 0 81.92 7.936c91.008 0 179.84-29.504 243.712-80.768z m19.008 62.528l-47.552 38.208c-75.52 60.8-175.616 94.144-281.6 94.144-19.2 0-38.464-1.024-57.472-3.328V609.28c0 107.84 73.92 208.512 192.768 262.72l193.856 88.384 193.92-88.384c118.912-54.208 192.64-154.88 192.64-262.72V198.272a507.072 507.072 0 0 1-57.344 3.328c-106.176 0-206.144-33.408-281.728-94.08l-47.488-38.272z m132.928 242.944c31.424 0 56.832 25.536 56.832 56.832H564.544v90.944h121.92a56.448 56.448 0 0 1-56.384 56.384H564.48v103.424h150.272a56.832 56.832 0 0 1-56.832 56.832H365.056a56.832 56.832 0 0 1-56.832-56.832h60.608v-144c0-33.92 27.52-61.44 61.44-61.44v205.312h71.68V369.024H324.8c0-31.424 25.472-56.832 56.832-56.832z" p-id="4799"></path></svg> 当前是体验模式 需要购买正版</p>
            <input type="hidden" ajax-name="action" value="admin_delete_aut">
            <a  href="https://www.zibll.com/forum-post/" class="but c-red ">购买正版</a>
            <div class="ajax-notice"></div></div>
            </div>';
         echo $con;
	}
}

            
            
add_action('admin_notices', 'example_admin_notice');
function example_admin_notice() {
	global $current_user ;
        $user_id = $current_user->ID;
	if ( ! get_user_meta($user_id, 'chojiang_notices_1') ) {
	            $con = '<div class="notice notice-success is-dismissible">
            <h2 style="color:#f73d3f;">请配置抽奖插件</h2>
            <p>您的网站还未完成插件功能配置，感谢你的支持 </p><p>【温馨提示：如你是子比群的个别 [大傻逼]请你立即卸载本插件】</p>
            <p><a class="button button-primary" style="margin: 2px;" href="' . admin_url('/admin.php?page=RYtheme#tab=%e9%bb%98%e8%ae%a4%e9%85%8d%e7%bd%ae') . '">立即设置</a><a target="_blank" class="button" style="margin: 2px;" href="https://www.zibll.com/forum-post/9356.html">查看官网教程</a><p>创建抽奖自定义模板 【子比抽奖】</p><a target="_blank" class="button" style="margin: 2px;" href="' . admin_url('/edit.php?post_type=page') . '">创建抽奖页面</a><a target="_blank" class="button" style="margin: 2px;" href="?example_nag_ignore=0">我知道了 关闭通知</a></p>
        </div>';
         echo $con;
	}
}

add_action('admin_init', 'example_nag_ignore');
function example_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['example_nag_ignore']) && '0' == $_GET['example_nag_ignore'] ) {
             add_user_meta($user_id, 'chojiang_notices_1', 'true', true);
	}
}

//后台申请审核
function chojiang_dmk() {
    add_submenu_page('users.php', '用户抽奖数据', '历史抽奖', 'administrator', 'chojiang_auth', 'zeke_chojiang_dmk');
}

function zeke_chojiang_dmk() {
    require plugin_dir_path(__FILE__) .'inc/options/dmk.php';
}

 add_action('admin_menu', 'chojiang_dmk');
 
 
 class CFS_chojiang
{
      public static function aut()
    {
        if ('1' == 1) {
            $con = '<div id="authorization_form" style="max-width: 100%;" class="ajax-form" ajax-url="' . esc_url(admin_url('admin-ajax.php')) . '">
            <div class="ok-icon"><svg t="1585712312243" class="icon" style="width: 1em; height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3845" data-spm-anchor-id="a313x.7781069.0.i0"><path d="M115.456 0h793.6a51.2 51.2 0 0 1 51.2 51.2v294.4a102.4 102.4 0 0 1-102.4 102.4h-691.2a102.4 102.4 0 0 1-102.4-102.4V51.2a51.2 51.2 0 0 1 51.2-51.2z m0 0" fill="#FF6B5A" p-id="3846"></path><path d="M256 13.056h95.744v402.432H256zM671.488 13.056h95.744v402.432h-95.744z" fill="#FFFFFF" p-id="3847"></path><path d="M89.856 586.752L512 1022.72l421.632-435.2z m0 0" fill="#6DC1E2" p-id="3848"></path><path d="M89.856 586.752l235.52-253.952h372.736l235.52 253.952z m0 0" fill="#ADD9EA" p-id="3849"></path><path d="M301.824 586.752L443.136 332.8h137.216l141.312 253.952z m0 0" fill="#E1F9FF" p-id="3850"></path><path d="M301.824 586.752l209.92 435.2 209.92-435.2z m0 0" fill="#9AE6F7" p-id="3851"></path></svg></div>
            <p style=" color: #d63638; font-size: 15px; "><svg class="icon" style="width: 1em;height: 1em;vertical-align: -.2em;fill: currentColor;overflow: hidden;font-size: 1.4em;" viewBox="0 0 1024 1024"><path d="M492.224 6.72c11.2-8.96 26.88-8.96 38.016 0l66.432 53.376c64 51.392 152.704 80.768 243.776 80.768 27.52 0 55.104-2.624 81.92-7.872a30.08 30.08 0 0 1 24.96 6.4 30.528 30.528 0 0 1 11.008 23.424V609.28c0 131.84-87.36 253.696-228.288 317.824L523.52 1021.248a30.08 30.08 0 0 1-24.96 0l-206.464-94.08C151.36 862.976 64 741.12 64 609.28V162.944a30.464 30.464 0 0 1 36.16-29.888 425.6 425.6 0 0 0 81.92 7.936c91.008 0 179.84-29.504 243.712-80.768z m19.008 62.528l-47.552 38.208c-75.52 60.8-175.616 94.144-281.6 94.144-19.2 0-38.464-1.024-57.472-3.328V609.28c0 107.84 73.92 208.512 192.768 262.72l193.856 88.384 193.92-88.384c118.912-54.208 192.64-154.88 192.64-262.72V198.272a507.072 507.072 0 0 1-57.344 3.328c-106.176 0-206.144-33.408-281.728-94.08l-47.488-38.272z m132.928 242.944c31.424 0 56.832 25.536 56.832 56.832H564.544v90.944h121.92a56.448 56.448 0 0 1-56.384 56.384H564.48v103.424h150.272a56.832 56.832 0 0 1-56.832 56.832H365.056a56.832 56.832 0 0 1-56.832-56.832h60.608v-144c0-33.92 27.52-61.44 61.44-61.44v205.312h71.68V369.024H324.8c0-31.424 25.472-56.832 56.832-56.832z" p-id="4799"></path></svg> 当前是体验模式 需要购买正版</p>
            <input type="hidden" ajax-name="action" value="admin_delete_aut">
            <a  href="https://www.zibll.com/forum-post/" class="but c-red ">购买正版</a>
            <div class="ajax-notice"></div>
            </div>';
        }
        if (!$a) {
            return array(
                'type'    => 'content',
                'content' => $con,
            );
        }
    }
   }
