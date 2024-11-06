<?php if (! defined('ABSPATH')) {
	die;
}
if (class_exists('CSF')) {


    $prefix    = 'RYtheme';
    $imagepath = plugin_dir_path( __FILE__ ) . '/img/';
    $f_imgpath = plugin_dir_path( __FILE__ ) . '/inc/csf-framework/assets/images/';


    //开始构建
    CSF::createOptions($prefix, array(
        'menu_title'         => '子比抽奖',
        'menu_slug'          => 'RYtheme',
        'framework_title'    => '子比抽奖',
        'show_in_customizer' => true, //在wp-customize中也显示相同的选项
        'footer_text'        => '由泽客开发的子比抽奖项目',
        'footer_credit'      => '<i class="fa fa-fw fa-heart-o" aria-hidden="true"></i> ',
        'theme'              => 'light',
    ));

    CSF::createSection($prefix, array(
        'id'    => 'more',
        'title' => '默认&配置',
        'icon'  => 'fa fa-futbol-o',
    ));
    CSF::createSection($prefix, array(
        'id'    => 'chojiang',
        'title' => '奖品&概率',
        'icon'  => 'fa fa-fw fa-calendar-check-o',
    ));
    CSF::createSection($prefix, array(
        'id'    => 'post',
        'title' => '弹幕&历史',
        'icon'  => 'fa fa-fw fa-map-o',
    ));

         CSF::createSection($prefix, array(
        'parent'      => 'more',
        'title'       => '默认值配置',
        'icon'        => 'fa fa-cog',
        'description' => '',
        'fields'      => array(
               CFS_chojiang::aut(),
                              array(
                'content' => '<p>不允许修改或增加更多的列表不然有可能会报错 最佳配置方式应 修改名称和奖品图片</p>
                <li>当前是 体验版本功能页面都落后<code>1</code></li>
                <li>当前是 体验版本功能页面都落后<code>2</code></li>
                <li>当前是 体验版本功能页面都落后<code>3</code></li>
                <div style="color:#ff2153;"><i class="fa fa-fw fa-info-circle fa-fw"></i>如果你需要帮助可以前往zibll社区查看相关教程，请确保你的配置没有问题！</div>
                <a href="https://www.zibll.com/forums">教程设置</a> | <a href="https://www.zibll.com/forum-post/9356.html">使用教程</a>',
                'style'   => 'warning',
                'type'    => 'submessage',
            ),
                   array(
                      'id'          => 'chojiang_lx',
                      'type'        => 'select',
                      'title'       => '默认扣除类型',
                      'subtitle' => '扣除积分/余额',
                      
                      'options'     => array(
                        'zibl_choujiang_user_points'  => '积分',
                        'zibl_choujiang_user_balance'  => '余额',
                      ),
                      'default'     => 'zibl_choujiang_user_points'
                    ), 
                    array(
                      'id'      => 'chojiang_kochu',
                      'type'    => 'text',
                      'title'   => '抽奖扣除配置',
                        'subtitle' => '积分/余额抽奖金额 ',
                      'default' => '10'
                    ),
                     array(
                      'id'      => 'xx_xxhg',
                      'type'    => 'text',
                      'title'   => '谢谢惠顾提示语',
                      'default' => '哎呀运气真差~再接再厉'
                    ),
                    array(
                      'type'    => 'notice',
                      'style'   => 'success',
                      'content' => '前端抽奖奖品中奖提示配置',
                    ),
                      array(
                        'title' => '中奖语句前提示语',
                        'id'    => 'zjq',
                        'type'  => 'text',
                        'default' => '恭喜你获得'
                    ),
                 array(
                      'type'    => 'notice',
                      'style'   => 'success',
                      'content' => '列如：恭喜你获得【奖品名称】奖品,请刷新页面后查看最新数据',
                    ),
                array(
                        'title' => '中奖语句后提示语',
                        'id'    => 'zjh',
                        'type'  => 'text',
                        'default' => '奖品,请刷新页面后查看最新数据'
                    ),
                    ),
                    
    ));
            
         CSF::createSection($prefix, array(
        'parent'      => 'more',
        'title'       => '通知系统',
        'icon'        => 'fa fa-twitch',
        'description' => '',
        'fields'      => array(
               CFS_chojiang::aut(),
                              array(
                'content' => '<p>不允许修改或增加更多的列表不然有可能会报错 最佳配置方式应 修改名称和奖品图片</p>
   <li>当前是 体验版本功能页面都落后<code>1</code></li>
                <li>当前是 体验版本功能页面都落后<code>2</code></li>
                <li>当前是 体验版本功能页面都落后<code>3</code></li>
                <div style="color:#ff2153;"><i class="fa fa-fw fa-info-circle fa-fw"></i>如果你需要帮助可以前往zibll社区查看相关教程，请确保你的配置没有问题！</div>
                <a href="https://www.zibll.com/forums">教程设置</a> | <a href="https://www.zibll.com/forum-post/9356.html">使用教程</a>',
                'style'   => 'warning',
                'type'    => 'submessage',
            ),
 
            array(
              'type'    => 'notice',
              'style'   => 'success',
              'content' => '下面配置【奖品通知】 到用户中心',
            ),

  array(
                'title'   => __("自定义奖品系统通知", 'zib_language'),
                'id'      => 'jp_msgtz',
                'type'    => 'switcher',
                'subtitle' => '开启关闭/奖品通知',
                'default' => true,
            ),
  array(
                'dependency' => array('jp_msgtz', '!=', ''),
              'id'      => 'jp_msgtz_title',
              'subtitle' => '奖品标题/奖品提示',
              'desc'    => '<i class="fa fa-fw fa-info-circle fa-fw"></i>奖品标题变量字符串:<div class="c-yellow"><code>【msgtitle】</code></div>',
              'type'    => 'text',
              'title'   => '奖品通知标题',
              'default' => '恭喜你获得了msgtitle'
            ),
array(
          'dependency' => array('jp_msgtz', '!=', ''),
                'title'   => __("自定义奖品系统通知内容", 'zib_language'),
                'id'          => 'jp_msgtz_comment',
                'subtitle' => '奖品内容/奖品提示',
                'placeholder' => __('自定义你的奖品通知内容', 'zib_language'),
                'class'       => 'compact',
                'desc'    => '<i class="fa fa-fw fa-info-circle fa-fw"></i>奖品内容变量字符串:<div class="c-yellow"><code>奖品标题：【msgcomment】奖品时间：【msgdeta】</code></div>',
                'default'     => '在抽奖项目中获得了 :<p>msgcomment</p> 时间:msgdeta
                再接再厉',
                'attributes'  => array(
                    'rows' => 5,
                ),
                'sanitize'    => false,
                'type'        => 'textarea',
            ),
                    ),
           
                    
    ));
        CSF::createSection($prefix, array(
        'parent'      => 'chojiang',
        'title'       => '奖品/概率配置',
        'icon'        => 'fa fa-fw fa-ban',
        'description' => '',
        'fields'      => array(
               CFS_chojiang::aut(),
                        array(
                'content' => '<p>不允许修改或增加更多的列表不然有可能会报错 最佳配置方式应 修改名称和奖品图片</p>
   <li>当前是 体验版本功能页面都落后<code>1</code></li>
                <li>当前是 体验版本功能页面都落后<code>2</code></li>
                <li>当前是 体验版本功能页面都落后<code>3</code></li>
                <div style="color:#ff2153;"><i class="fa fa-fw fa-info-circle fa-fw"></i>如果你需要帮助可以前往zibll社区查看相关教程，请确保你的配置没有问题！</div>
                <a href="https://www.zibll.com/forums">教程设置</a> | <a href="https://www.zibll.com/forum-post/9356.html">使用教程</a>',
                'style'   => 'warning',
                'type'    => 'submessage',
            ),
            array(
  'type'    => 'notice',
  'style'   => 'success',
  'content' => '不允许修改或增加更多的列表不然有可能会报错 最佳配置方式应 修改名称和奖品图标',
),

          
            array(
                'title'        => '奖品概率配置',
                'subtitle'     => '中奖几率/转盘图片',
                'id'           => 'chojiang_jp',
                'sanitize'     => false,
                'type'         => 'group',
                'button_title' => '添加奖品',
                'default'      => array(
                    array(
                          'title' => '30天会员',
                          'thumbnail'       => '/wp-content/themes/zibll/img/vip-2.svg',
                          'jp_jine' => '30',
                          'jp_lx' => 'zibl_choujiang_user_vip',
                          'chojiang_vip' => '',
                          'gailv' => '1',
                    ),
                    array(
                          'title' => '谢谢惠顾',
                          'thumbnail' => '/wp-content/themes/zibll/img/vip-2.svg',
                          'jp_jine' => '0',
                          'jp_lx' => 'xxhg',
                          'gailv' => '30',
                    ),
                    array(
                        'title' => '30积分',
                         'thumbnail' => '/wp-content/themes/zibll/img/vip-2.svg',
                         'jp_jine' => '30',
                          'jp_lx' => 'zibl_choujiang_user_points',
                          'gailv' => '10',
                    ),
                    array(
                        'title' => '50经验',
                         'thumbnail' => '/wp-content/themes/zibll/img/vip-2.svg',
                         'jp_jine' => '50',
                          'jp_lx' => 'zibl_choujiang_user_level',
                          'gailv' => '5',
                    ),
                    array(
                        'title' => '谢谢惠顾',
                         'thumbnail' => '/wp-content/themes/zibll/img/vip-2.svg',
                         'jp_jine' => '0',
                          'jp_lx' => 'xxhg',
                          'gailv' => '30',
                    ),
                    array(
                        'title' => '5余额',
                         'thumbnail' => '/wp-content/themes/zibll/img/vip-2.svg',
                         'jp_jine' => '5',
                          'jp_lx' => 'zibl_choujiang_user_balance',
                          'gailv' => '1',
                    ),
                    array(
                        'title' => '100积分',
                         'thumbnail'       => '/wp-content/themes/zibll/img/vip-2.svg',
                         'jp_jine' => '100',
                          'jp_lx' => 'zibl_choujiang_user_points',
                          'gailv' => '10',
                    ),
                    array(
                        'title' => '20经验',
                         'thumbnail'       => '/wp-content/themes/zibll/img/vip-2.svg',
                         'jp_jine' => '20',
                          'jp_lx' => 'zibl_choujiang_user_level',
                          'gailv' => '10',
                    ),
                ),
                'fields'       => array(
                    array(
                    'title'        => '奖品名称配置',
                         'subtitle' => '奖品名称',
                        'default' => '奖品名称',
                        'id'      => 'title',
                        'type'    => 'text',
                    ),
            array(

                'id'         => 'jp_jine',
                'class'      => 'compact',
                'title'      => '奖励数额',
                'subtitle'   => '奖励数额 奖励不能低于扣除金额',
                  'desc'    => '谢谢惠顾 请填:<code>0</code><div class="c-yellow"><i class="fa fa-fw fa-info-circle fa-fw"></i>如果奖品是会员<code>1 = 1天会员</code></div>',
                'default'    => 30,
                'type'       => 'number',
                'unit'       => '数额',
                'class'      => 'compact',
            ),
            array(
              'id'          => 'jp_lx',
              'type'        => 'select',
              'title'       => '奖励类型',
              'placeholder' => '请选择奖品',
              'options'     => array(
                'xxhg'  => '谢谢惠顾',
                'zibl_choujiang_user_points'  => '积分',
                'zibl_choujiang_user_level'  => '经验',
                'zibl_choujiang_user_vip'  => '会员',
                'zibl_choujiang_user_balance'  => '余额',
              ),
              'default'     => 'zibl_choujiang_user_points'
            ),
         array(
                  'dependency' => array('jp_lx', '==', 'zibl_choujiang_user_vip'),
                      'id'          => 'chojiang_vip',
                      'type'        => 'select',
                      'title'       => '会员奖励等级',
                      'subtitle' => '只支持 会员1/会员2',
                       'desc'    => '对应子比的 会员一级 会员二级 没有区别~',
                      'options'     => array(
                        '2'  => '二级会员',
                        '1'  => '一级会员',
                      ),
                      'default'     => '1'
                    ), 
            array(
                'title'    => '奖品图片',
                'subtitle' => '奖品图片配置',
                'id'       => 'thumbnail',
                'class'    => 'compact',
                'desc'     => '奖品图标',
                'default'  => '/wp-content/themes/zibll/img/vip-2.svg',
                'library'  => 'image',
                'type'     => 'upload',
            ),
                        array(
                'title'   => '奖品概率',
                'desc'    => '<i class="fa fa-fw fa-info-circle fa-fw"></i>1最低 100最高',
                'id'      => 'gailv',
                'default' => 6,
                'max'     => 100,
                'min'     => 3,
                'step'    => 1,
                'unit'    => '%',
                'type'    => 'spinner',
        
),
           
                ),
            ),
        ),
    ));
    
             CSF::createSection($prefix, array(
        'parent'      => 'chojiang',
        'title'       => '大转盘配置',
        'icon'        => 'fa fa-twitch',
        'description' => '',
        'fields'      => array(
               CFS_chojiang::aut(),
                              array(
                'content' => '<p>不允许修改或增加更多的列表不然有可能会报错 最佳配置方式应 修改名称和奖品图片</p>
   <li>当前是 体验版本功能页面都落后<code>1</code></li>
                <li>当前是 体验版本功能页面都落后<code>2</code></li>
                <li>当前是 体验版本功能页面都落后<code>3</code></li>
                <div style="color:#ff2153;"><i class="fa fa-fw fa-info-circle fa-fw"></i>如果你需要帮助可以前往zibll社区查看相关教程，请确保你的配置没有问题！</div>
                <a href="https://www.zibll.com/forums">教程设置</a> | <a href="https://www.zibll.com/forum-post/9356.html">使用教程</a>',
                'style'   => 'warning',
                'type'    => 'submessage',
            ),
                    ),
                    ));
    
    
    
                 CSF::createSection($prefix, array(
        'parent'      => 'post',
        'title'       => '历史抽奖',
        'icon'        => 'fa fa-twitch',
        'description' => '',
        'fields'      => array(
               CFS_chojiang::aut(),
                              array(
                'content' => '<p>不允许修改或增加更多的列表不然有可能会报错 最佳配置方式应 修改名称和奖品图片</p>
   <li>当前是 体验版本功能页面都落后<code>1</code></li>
                <li>当前是 体验版本功能页面都落后<code>2</code></li>
                <li>当前是 体验版本功能页面都落后<code>3</code></li>
                <div style="color:#ff2153;"><i class="fa fa-fw fa-info-circle fa-fw"></i>如果你需要帮助可以前往zibll社区查看相关教程，请确保你的配置没有问题！</div>
                <a href="https://www.zibll.com/forums">教程设置</a> | <a href="https://www.zibll.com/forum-post/9356.html">使用教程</a>',
                'style'   => 'warning',
                'type'    => 'submessage',
            ),
         
                    ),
                    ));
    
}