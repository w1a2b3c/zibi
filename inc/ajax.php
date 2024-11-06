<?php
//抽奖活动奖励积分-会员-经验-余额 唯一请求接口
function choujiang_update_user()
{
    $action  = $_REQUEST['action'];
    $user_id = !empty($_REQUEST['user_id']) ? (int) $_REQUEST['user_id'] : 0;
    $val     = !empty($_REQUEST['val'])  ?($action === 'zibl_choujiang_user_balance' ? round((float)$_REQUEST['val'], 2) : (int) $_REQUEST['val']) : 0;
    $decs    = !empty($_REQUEST['decs']) ? esc_attr($_REQUEST['decs']) : '';
    $type    = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
$user_points     = zibpay_get_user_points($user_id);
$user_balance = zibpay_get_user_balance($user_id);

//下面是 抽奖概率 请勿随意修改！
    if($action === 'zeke_choujiang'){
//计算中奖概率
function getRand($proArr){ 
    $rs = '';//中奖结果 
    $proSum = array_sum($proArr);//概率数组的总概率精度 
    //概率数组循环 
    foreach ($proArr as $key => $proCur) { 
        $randNum = mt_rand(1, $proSum); 
        if ($randNum <= $proCur) { 
            $rs = $key; 
            break; 
        } else { 
            $proSum -= $proCur; 
        } 
    } 
    unset($proArr); 
    return $rs; 
}
$prize_arr = RYtheme('chojiang_jp');
$arr=array();
foreach ($prize_arr as $key => $val) { 
    $arr[$key] = $val['gailv']; 
}
 $prize_id = getRand($arr); //根据概率获取奖品id 
/**
 * 抽奖消耗扣除类型
 * $kochu 类型 积分或余额
 * $kocshu 扣除数额 
**/
$kochu =  RYtheme('chojiang_lx');
$kocshu = RYtheme('chojiang_kochu');
if ($kochu == 'zibl_choujiang_user_points') {
        //判断当前 使用积分进行扣除
           if($user_points < $kocshu){
       //判断积分是否小于你需要消耗的积分
  zib_send_json_success(array('msg' => '积分不足', 'jife' => $user_points));
die;
}
   $type = 'delete';
    $data = array(
        'value' => -$kocshu, //值 整数为加，负数为减去
        'type'  => '抽奖' . ($type === 'add' ? '奖励' : '消费'),
        'desc'  => '抽奖消耗', //说明
    );
        zibpay_update_user_points($user_id, $data);
}
if ($kochu == 'zibl_choujiang_user_balance') {
    //判断当前 使用余额进行扣除
    if ($user_balance < $kocshu) {
        zib_send_json_success(array('msg' => '余额不足','jife'=> $yue));
        die;
    }
       $type = 'delete';
    $data = array(
        'value' => -$kocshu, //值 整数为加，负数为减去
        'type'  => '抽奖' . ($type === 'add' ? '奖励' : '消费'),
        'desc'  => '抽奖消耗', //说明
    );
         zibpay_update_user_balance($user_id, $data);
}

/**
 * 下面进行奖品操作 不懂请问随便修改
 * 如有报错等问题反馈请到 子比社区 
 * https://www.zibll.com/forum-post/9095.html
 * 
*/
$vipdj = RYtheme('chojiang_jp')[$prize_id]['chojiang_vip'];
$vip = zib_get_user_vip_level($user_id);
$jine =  RYtheme('chojiang_jp')[$prize_id]['jp_jine'];
$lx =  RYtheme('chojiang_jp')[$prize_id]['jp_lx'];
$title =  RYtheme('chojiang_jp')[$prize_id]['title'];
$msgzt = RYtheme('jp_msgtz');
$mtitle = RYtheme('jp_msgtz_title');
$comment = RYtheme('jp_msgtz_comment');
$deta = date("Y-m-d H:i:s", time()+8*60*60);
$msgtitle = str_ireplace('msgtitle',$title,$mtitle); 
$c1 = str_ireplace('msgcomment',$title,$comment); 
$message = str_ireplace('msgdeta',$deta,$c1); 
$new_date          = current_time('Y-m-d h:i:s');
$vip_exp_date = get_user_meta($user_id, 'vip_exp_date', true);
$type = 'add';
$zjq = RYtheme('zjq');
$zjh = RYtheme('zjh');
 global $wpdb;
 /*
 *记录用于前段弹幕
 */
     $now = current_time('mysql');
    $now_gmt = current_time('mysql', 1);
$table = "wp_zeke_chojiang"; 
$data_array = array( 
'chojiang_user' => $user_id, 
'chojiang_type' => $lx, 
'chojiang_shu' =>  $jine, 
'title' =>  $title, 
'content' =>  $title, 
'create_time' => $now, 
'modified_time' =>  $now_gmt
); 
$wpdb->insert($table,$data_array);


    $data = array(
        'value' => $jine, //值 整数为加，负数为减去
        'type'  => '抽奖奖励',
        'desc'  => $title, //说明
    );
         if ($msgzt == 1) {          //判断是否开启 系统通知
          if ($lx != 'xxhg') {          //判断奖品是否抽到
                 $msg_arge = array(
                'send_user'    => 'admin',
                'receive_user' => $user_id,
                'type'         => 'system',
                'title'        => $msgtitle,
                'content'      => $message,
                );
                //创建新消息
                ZibMsg::add($msg_arge); 
        }
        }
    /**
      * 下面是奖品赋予区域代码 不懂请问随意修改
      * 如有报错等问题反馈请到 子比社区 
      * https://www.zibll.com/forum-post/9095.html
    **/
  if($lx === 'xxhg'){
      //判断是否 谢谢惠顾 
     $xxhg = RYtheme('xx_xxhg');
    zib_send_json_success(array('msg' => '500', 'id' => $prize_id,'name' => $xxhg));//以json数组返回给前端
    }else  if($lx === 'zibl_choujiang_user_level'){
     //判断是否经验
        $user_integral = (int) get_user_meta($user_id, 'level_integral', true);
        //保存用户的等级经验值
         $value = $jine;
          $key = 'chojiang';
        $new = $value + $user_integral;

        update_user_meta($user_id, 'level_integral', $new);
        //保存用户经验值获取明细
        zib_add_user_level_integral_detail($user_id, $value, $key, $new);
        
    zib_send_json_success(array('msg' => '200', 'id' => $prize_id,'name' => $zjq.$title.$zjh));//以json数组返回给前端
    }else if ($lx === 'zibl_choujiang_user_balance') {
        //余额管理
        if (!_pz('pay_balance_s')) {
            zib_send_json_error('余额功能已关闭');
        }
        $data = array(
        'value' => $jine, //值 整数为加，负数为减去
        'type'  => '抽奖励奖',
        'desc'  => $title, //说明
    );
        zibpay_update_user_balance($user_id, $data);
    zib_send_json_success(array('msg' => '200', 'id' => $prize_id,'name' => $zjq.$title.$zjh));//以json数组返回给前端
    } else if ($lx === 'zibl_choujiang_user_points'){
        //积分管理
        if (!_pz('points_s')) {
            zib_send_json_error('积分功能已关闭');
        }
            $data = array(
        'value' => $jine, //值 整数为加，负数为减去
        'type'  => '抽奖' . ($type === 'add' ? '奖励' : '消费'),
        'desc'  => $title, //说明
    );
        zibpay_update_user_points($user_id, $data);
        zib_send_json_success(array('msg' => '200', 'id' => $prize_id,'name' => $zjq.$title.$zjh));//以json数组返回给前端
    } else if ($lx === 'zibl_choujiang_user_vip'){
        //判断永久会员
          if ('Permanent' === $vip_exp_date) {
        zib_send_json_success(array('msg' => '100', 'id' => $prize_id,'name' => '你已经是永久会员了'));//以json数组返回给前端
             die;
        }  
            //已有会员日期相加
              if ($vip > $vipdj) {
        zib_send_json_success(array('msg' => '100', 'id' => $prize_id,'name' => '你已经拥有比奖励更高级的会员了'));//以json数组返回给前端
             die;
              }
       if ($vip == '0') {
           //判断是否没有会员
           $new_vip_exp_date =  date("Y-m-d 23:59:59", strtotime("+" . $jine . "day", strtotime($new_date)));
           update_user_meta($user_id, 'vip_level', $vipdj);
           update_user_meta($user_id, 'vip_exp_date', $new_vip_exp_date);
           zib_send_json_success(array('msg' => '200', 'id' => $prize_id,'name' =>$zjq.$title.$zjh));//以json数组返回给前端
       }else  {
         $new_vip_exp_date =  date("Y-m-d 23:59:59", strtotime("+" . $jine . "day", strtotime($vip_exp_date)));
        //  update_user_meta($user_id, 'vip_level', $vipdj);
         update_user_meta($user_id, 'vip_exp_date', $new_vip_exp_date);
        zib_send_json_success(array('msg' => '200', 'id' => $prize_id,'name' => $zjq.$title.$zjh));//以json数组返回给前端
       }
    }
    }}
add_action('wp_ajax_zeke_choujiang', 'choujiang_update_user');