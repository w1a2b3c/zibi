<?php
/*!
 *@name     server.php
 *@project  jquery.barrager.js
 *@des      弹幕插件服务端演示
 *@author   yaseng@uauc.net
 *@url      https://github.com/yaseng/jquery.barrager.js
 */
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-includes/wp-db.php' );
//mode=1 实时模式 mode=2 一次性获取模式
    /**
     * 随机颜色生成
     * @author LJ
     * @date 2017-02-09
     */
    function randomColor() { 
        // 颜色 例:#866573
        $str = '#'; 
        for($i = 0 ; $i < 6 ; $i++) { 
            $randNum = rand(0 , 15); 
            switch ($randNum) { 
                case 10: 
                    $randNum = 'A'; 
                    break; 
                case 11: 
                    $randNum = 'B'; 
                    break; 
                case 12: 
                    $randNum = 'C'; 
                    break; 
                case 13: 
                    $randNum = 'D'; 
                    break; 
                case 14: 
                    $randNum = 'E'; 
                    break; 
                case 15: 
                    $randNum = 'F'; 
                    break; 
            } 
            $str .= $randNum; 
        } 
        return $str; 
    } 
    $color = randomColor();
    
//   echo $color;
function randColor(){
$colors=array('5CB85C','428BCA','FF6600','D9534F','B37333','00ABA9');
$show_color = array_rand($colors, 1);
return $colors[$show_color];
} 
$ys = '#'.randColor();

// $wpdb->show_errors();
$name="";
$querystr = "SELECT * FROM `wp_zeke_chojiang`  ";
$querystr .="WHERE  title like '%s' ";
$querystr .="ORDER BY title LIMIT 5";
$results = $wpdb->get_results($wpdb->prepare($querystr,$name.'%'));
foreach($results as $row){ 
   $user_id = $row->chojiang_user;
    $avatar_img =  get_avatar($row->chojiang_user, 50);
    $barrages =
array(
    array(
        'info'   => '获得了'.$row->title,
        'img'    => $avatar_img,
        'href'   => '/author/'.$row->chojiang_user,
         'color'  => $color
     ),    array(
        'info'   => '获得了'.$row->title,
        'img'    => $avatar_img,
        'href'   => '/author/'.$row->chojiang_user,
         'color'  => $color
     ),    array(
        'info'   => '获得了'.$row->title,
        'img'    => $avatar_img,
        'href'   => '/author/'.$row->chojiang_user,
         'color'  => $color
     ),    array(
        'info'   => '获得了'.$row->title,
        'img'    => $avatar_img,
        'href'   => '/author/'.$row->chojiang_user,
         'color'  => $color
     ),    array(
        'info'   => '获得了'.$row->title,
        'img'    => $avatar_img,
        'href'   => '/author/'.$row->chojiang_user,
         'color'  => $color
     ),    array(
        'info'   => '获得了'.$row->title,
        'img'    => $avatar_img,
        'href'   => '/author/'.$row->chojiang_user,
         'color'  => $color
     ),    array(
        'info'   => '获得了'.$row->title,
        'img'    => $avatar_img,
        'href'   => '/author/'.$row->chojiang_user,
         'color'  => $color
     ),
     
    );

}

// $barrages=
// array(
//     array(
//         'info'   => '获得了5积分',
//         'img'    => 'https://thirdqq.qlogo.cn/g?b=oidb&k=pQCK9DFKtCYiahT8PgSKb5w&s=100&t=1615431525',
//         'href'   => '/author/'.$row->chojiang_user,
//          'color'  => $color
//         ),
//     array(
//         'info'   => '获得了30天会员',
//         'img'    => 'https://thirdqq.qlogo.cn/g?b=oidb&k=pQCK9DFKtCYiahT8PgSKb5w&s=100&t=1615431525',
//         'href'   => '/author/'.$row->chojiang_user,

//          'color'  =>  $ys
 
//         ),
//     array(
//         'info'   => '获得了30经验',
//         'img'    => 'https://thirdqq.qlogo.cn/g?b=oidb&k=pQCK9DFKtCYiahT8PgSKb5w&s=100&t=1615431525',
//         'href'   => '/author/'.$row->chojiang_user,
//          'color'  => $color
//         ),
//     array(
//         'info'   => '获得了5积分',
//         'img'    => 'https://thirdqq.qlogo.cn/g?b=oidb&k=pQCK9DFKtCYiahT8PgSKb5w&s=100&t=1615431525',
//         'href'   => '/author/1',
//         'close'  =>false,
//         ),
 
//     );
 
 
echo   json_encode($barrages);
