<?php
/*
 * @Author        : Qinver
 * @Url           : zibll.com
 * @Date          : 2020-11-01 17:08:02
 * @LastEditTime: 2021-12-08 19:34:59
 * @Email         : 770349780@qq.com
 * @Project       : Zibll子比主题
 * @Description   : 一款极其优雅的Wordpress主题|后台处理身份认证申请的页面
 * @Read me       : 感谢您使用子比主题，主题源码有详细的注释，支持二次开发。
 * @Remind        : 使用盗版主题会存在各种未知风险。支持正版，从我做起！
 */

if (!defined('ABSPATH')) {
    exit;
}
$user_Info = wp_get_current_user();
if (!is_user_logged_in()) {
    exit;
}
$this_url = esc_url(admin_url('users.php?page=chojiang_auth'));
$msg_type    = !empty($_REQUEST['msg_type']) ? $_REQUEST['msg_type'] : 0;

global $wpdb;
$wpdb->show_errors();

$tab ='<div class="table-box">';
           
// $tab .= '<div class="order-header"><ul class="subsubsub"><li><a href="https://bpwzj.com/wp-admin/users.php?page=chojiang_auth">全部系统消息</a></li> | <li><a href="https://bpwzj.com/wp-admin/users.php?page=chojiang_auth&amp;msg_type=promotion">活动消息</a></li> | <li><a href="https://bpwzj.com/wp-admin/users.php?page=chojiang_auth&amp;msg_type=pay">订单消息</a></li> | <li><a href="https://bpwzj.com/wp-admin/users.php?page=chojiang_auth&amp;msg_type=vip">会员消息</a></li> </ul></div>';
$tab .=  ' <table class="widefat fixed striped posts">
            <thead>
                <tr>
                    <th class="" width="5%">用户ID<span class="orderby-but"></span></th>
                    <th class="" width="5%">奖品类型<span class="orderby-but"></span></th>
                    <th class="" width="5%">奖品数值<span class="orderby-but"></span></th>
                    <th class="" width="5%">奖品标题</th>
                    <th class="" width="10%">提交时间<span class="orderby-but"></span>
                    </tr>
            </thead>
            <tbody>';
       echo $tab;     
//获取分页数据 :每页显示的数量 默认为3
$num = 30;
//当前页码,默认为1
$page = isset($_REQUEST['paged']) ? intval($_REQUEST['paged']) : 1;
//计算每一页第一条记录的显示偏移量
//偏移量 = (页码 -1) \* 每页的显示数量
$offset = ($page - 1) * $num ;
//获取分页数据
$sql = " SELECT `id`,`chojiang_user`,`chojiang_type`,`chojiang_shu`,`title`,`create_time` FROM `wp_zeke_chojiang`  ORDER BY create_time desc , `id` ASC  LIMIT {$num} OFFSET {$offset} ";
$results = $wpdb->get_results($sql);
foreach($results as $row){ 
    if($row->title == '谢谢惠顾'){
        $type = '谢谢惠顾';
    }elseif($row->chojiang_type == 'zibl_choujiang_user_level'){
        $type = '经验';
    }elseif($row->chojiang_type == 'zibl_choujiang_user_balance'){
        $type = '余额';
    }elseif($row->chojiang_type == 'zibl_choujiang_user_points'){
        $type = '积分';
    }elseif($row->chojiang_type == 'zibl_choujiang_user_vip'){
        $type = '会员';
    }
  echo '<tr>';
  echo '<td>'.$row->chojiang_user.'</td>'; 
  echo '<td><span style=" color: #0989fd; ">'.$type.'</span></td>'; 
  echo '<td><span style=" color: #0989fd; ">'.$row->chojiang_shu.'</span></td>'; 
   echo '<td><div style="max-height:39px;overflow:hidden;"><div style="color:#fb4444; ">'.$row->title.'</div></div></td>'; 
  echo '<td>'.$row->create_time.'</td>'; 
   echo '</tr>';
}
                

echo '</tbody>
        </table>
    </div>';

?>
    
    
    