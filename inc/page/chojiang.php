
<?php /* Template Name: CustomPage */ ?>
    <?php get_header();?>
  <main class="container">
    <div class="content-wrap">
        <div class="content-layout">
  <?php 
if (is_user_logged_in()) {
    $isusre =1;
} else {
    $isusre = 0;
}





// $querystr = "SELECT * FROM `wp_zeke_chojiang`  ";
// $querystr .="WHERE  title like '%s' ";
// $querystr .="ORDER BY title LIMIT 5";
// $results = $wpdb->get_results($wpdb->prepare($querystr,$name.'%'));
// foreach($results as $row){ 
//   echo $row->title; 
// }


// var_dump($results);

$vip_exp_date = get_user_meta($user_id, 'vip_exp_date', true);
// if ('Permanent' == strtolower($vip_exp_date)) {
//     echo '永久有效';
// }
//  $vip_desc = 'Permanent' == $vip_exp_date ? '永久有效' :'';
// // echo $vip_desc;

// $pay_vip_time =  RYtheme('chojiang_jp')['2']['jp_jine'];
//      echo  date("Y-m-d 23:59:59", strtotime("+" . $pay_vip_time . "day", strtotime($vip_exp_date)));
     
          $user_points     = zibpay_get_user_points($user_id);
        $points_pay_link = zibpay_get_points_pay_link('but c-green', '购买积分');
        $checkin_btn     = zib_get_user_checkin_btn('muted-color px12', '签到领积分<i class="fa fa-angle-right em12 ml3"></i>', '今日已签到<i class="fa fa-angle-right em12 ml3"></i>');

        echo '<div class="row gutters-10">
                    <div class="zib-widget relative" style="padding-left: 24px;">
                        <div class="flex jsb">
                            <div class="mb6">
                            ' . zib_get_svg('points-color', null, 'em12 mr6') . '积分
                            </div>
                            ' . $checkin_btn . '
                        </div>
                        <div class="flex jsb ac">
                            <div class="mb6 c-green">' . zib_get_svg('points') . '<span class="em3x font-bold ml6">' . $user_points . '</span></div>
                            <div class="flex0">' . $points_pay_link . '</div>
                        </div>
                        
                    </div>
              </div>  ';
  ?>

<link rel="stylesheet" href="/wp-content/plugins/zibi-chojiang/pule/css/animate.min.css">
		<link rel="stylesheet" href="/wp-content/plugins/zibi-chojiang/pule/css/index.css">
<div class="load_bg"></div>
		<div class="pages page_index">
			<div class="main_box">
				<div class="lottery_box">
					<div class="list_box">
					    <?php 
					 	$arr = RYtheme('chojiang_jp');
					    foreach ($arr as $k => $v)
                    {
              echo "	<div class='list'>
        							<div class='list_ev'>
        								<div>
        									<img src=".$v['thumbnail'].">
        									<div class='name'>".$v['title']."</div>
        								</div>
        							</div>
        						</div>";
                }?>
				 <button id="tupBtn" class="turnplatw_btn">
							<img class="img_wid" src="/wp-content/plugins/zibi-chojiang/pule/img/but.png">
					</div>
					<img class="img_wid" src="/wp-content/plugins/zibi-chojiang/pule/img/but_bg.png">
				</div>
			</div>
		</div>
		
  <div class="row gutters-10">	<div class="zib-widget relative" style="padding-left: 24px;">
      
<div class="padding-w10 nop-sm">
  <ul class="list-inline scroll-x mini-scrollbar tab-nav-theme font-bold">
    <li class="">
      <a data-toggle="tab" href="#record_tab_balance" aria-expanded="false">历史记录</a>
    </li>
    <li class="active">
      <a data-toggle="tab" href="#record_tab_points" aria-expanded="true">个人记录</a>
    </li>

  </ul>
  <div class="tab-content">
    <div class="tab-pane fade" id="record_tab_balance">
        <?php 
        
        global $wpdb;
$wpdb->show_errors();
// $name="谢谢惠顾";

$name="";
$querystr = "SELECT * FROM `wp_zeke_chojiang`  ";
$querystr .="WHERE  title like '%s' ";
$querystr .="ORDER BY create_time desc , title desc  LIMIT 10";
$results = $wpdb->get_results($wpdb->prepare($querystr,$name.'%'));

  foreach ($results as $k => $v)
       { 
    $user_id = $v->chojiang_user;
    $name = zib_get_user_name_link($user_id);
    $avatar_img = get_avatar($v->chojiang_user, 50);
    $html = '<div class="border-bottom padding-h10 flex jsb">';
    $html .= '<span class="avatar-img">'.$avatar_img.'</span>';    
    $html .= '<div class="posts-mini-con em09 ml10 flex xx jsb">
    <span class="flex1 flex"><name class="inflex ac relative-h">'.$name.'</name></span>
          <div class="mb6">
            <div class="badg badg-sm mr6 c-blue">时间：'.$v->create_time.'</div>
          </div>
        </div>';        
    $html .= '<div class="flex jsb xx text-right flex0 ml10">
       <div class="felx0 flex xx jsb">';    
    $html .= ' <div class="c-yellow"><span class="mr3 px12"></span><b class="em10">'.$v->title.'</b></div>
           <div class="text-right"><span class="em09 muted-2-color">消耗积分</span></div></div>';    
    $html .= ' </div>
      </div>
      
      ';  
            echo $html;
        
} 

        ?>
        <div class="text-center mt20 muted-3-color">最多显示近10条记录</div>
      <!--<div class="text-center " style="padding:42px 0;">-->
      <!--  <img style="width:280px;opacity: .7;" src="https://www.zibll.com/wp-content/themes/zibll/img/null-order.svg">-->
      <!--  <p style="margin-top:42px;" class="em09 muted-3-color separator">暂无余额记录</p>-->
      <!--</div>-->
    </div>
    <div class="tab-pane fade active in" id="record_tab_points">
        <?php 
$user_id = get_current_user_id();
$querystr = "SELECT * FROM `wp_zeke_chojiang`  ";
$querystr .="WHERE  chojiang_user=$user_id ";
$querystr .="ORDER BY create_time desc LIMIT 10";
$results = $wpdb->get_results($wpdb->prepare($querystr,$name.'%'));
if (is_user_logged_in()) {
 if ($results == true) {
 foreach ($results as $k => $v)
       { 
   $user_id = $v->chojiang_user;
    $avatar_img = get_avatar($v->chojiang_user, 50);
    $name = zib_get_user_name_link($user_id);
    $html = '<div class="border-bottom padding-h10 flex jsb">';
    $html .= '<span class="avatar-img">'.$avatar_img.'</span>';    
    $html .= '<div class="posts-mini-con em09 ml10 flex xx jsb">
    <span class="flex1 flex"><name class="inflex ac relative-h">'.$name.'</name></span>
          <div class="mb6">
            <div class="badg badg-sm mr6 c-blue">时间：'.$v->create_time.'</div>
          </div>
        </div>';    
    $html .= '<div class="flex jsb xx text-right flex0 ml10">
       <div class="felx0 flex xx jsb">';    
    $html .= ' <div class="c-yellow"><span class="em10 px12">'.$v->title.'</span></div>
    <div class="text-right"><span class="em09 muted-2-color">消耗积分</span></div></div>';    
    $html .= ' </div>
      </div>';  
            echo $html;
} 
} else {
   echo '<div class="text-center " style="padding:42px 0;">
        <img style="width:280px;opacity: .7;" src="https://www.zibll.com/wp-content/themes/zibll/img/null-order.svg">
        <p style="margin-top:42px;" class="em09 muted-3-color separator">暂无抽奖记录</p>
      </div>';
};
} else {

echo '<div class="comment-signarea text-center box-body radius8">
					<h3 class="text-muted em12 theme-box muted-3-color">请登录后查看</h3>
					<p>
						<a href="javascript:;" class="signin-loader but c-blue padding-lg"><i class="fa fa-fw fa-sign-in mr10" aria-hidden="true"></i>登录</a>
						<a href="javascript:;" class="signup-loader ml10 but c-yellow padding-lg"><i data-class="icon mr10" data-viewbox="0 0 1024 1024" data-svg="signup" aria-hidden="true"></i>注册</a>
					</p>
				'.zib_social_login().'
				</div>';
}



 

        
        ?>
      <div class="text-center mt20 muted-3-color">最多显示近10条记录</div>
    </div>
  </div>
</div></div></div>
		<script>
$.ajaxSettings.async = false;
$.getJSON('/wp-content/plugins/zibi-chojiang/inc/sever.php?mode=2',function(data){
//每条弹幕发送间隔
var looper_time=3*1000;
var items=data;
//弹幕总数
var total=data.length;
//是否首次执行
var run_once=true;
//弹幕索引
var index=0;
//先执行一次
barrager();
function  barrager(){
  if(run_once){
      //如果是首次执行,则设置一个定时器,并且把首次执行置为false
      looper=setInterval(barrager,looper_time);                
      run_once=false;
  }
  //发布一个弹幕
  $('body').barrager(items[index]);
  //索引自增
  index++;
  //所有弹幕发布完毕，清除计时器。
  if(index == total){
      clearInterval(looper);
      return false;
  }
}
});
	</script>
		<script>
var clicktype = true;
var isusre = "<?php echo $isusre;?>";
var usre= "<?php echo $user_points;?>";
var chojiangdelete = "<?php echo RYtheme('chojiang_kochu');?>";
var chojiang_lx = "zeke_choujiang";
var userid = '<?php echo get_current_user_id();?>';
function indexFun(){
	$('.load_bg').remove();
	$('.page_index .lottery_box').on('click','.turnplatw_btn',function(){
	    		if(clicktype == false){return false};
		clicktype = false;
  	    	if(isusre == 0){
			      $('.signin-loader').click();
			   $('#tupBtn').attr("disabled",false);
		notyf("你还没有登录,请登录之后重试！","danger");
	return false
			};
			    
            if(usre < chojiangdelete){
                notyf("积分不足" +chojiangdelete+ "", "danger");
                clicktype = true;
                $('#tupBtn').attr("disabled",false);
            };
          	  notyf("正在抽奖请稍等...","load", "6");
	          setTimeout(function(){ 
     	  $.ajax({
            type: "post",
              url: "<?php echo admin_url( 'admin-ajax.php');?>",
            dataType: 'json',
            data: {
            action: chojiang_lx,
            user_id:userid,
            val: chojiangdelete, 
            decs: '请求抽奖', 
            type: 'delete',
            },
            success:function(result){
                $('.list_box .list_box').attr('class','list_box list_box');
                if(result.jife < chojiangdelete){
                    notyf("你的积分不足 为你刷新页面查看","warning");
                    location.reload();
                }
                if(result.msg == 500){
                      notyf(result.name,"warning");
                     $('#tupBtn').attr("disabled",false);
                }
                else if(result.msg == 100){
                      notyf(result.name,"warning");
                     $('#tupBtn').attr("disabled",false);
                }else {
                        notyf("抽奖扣除"+ chojiangdelete + "积分","warning");
                        notyf(result.name);
                    $('.lottery_box .list_box').attr('class','list_box list_box'+result.id);
                    $('#tupBtn').attr("disabled",false);
                }
               
            }
        });
        }, 8000);
		zpfun(function(){
			setTimeout(function(){
				speed = 60;
				zpnum = 0;
				count = 1;
				zpjp = -1;
				clicktype = true;
								$('.lottery_box .list_box').attr('class','list_box');
			},600)
		});	
	})
}
var speed = 60;//初始速度
var zpnum = 0; //当前位置
var count = 1;
var zpjp = 0; //中奖位置
var totalCount = 2;//默认转圈数
function zpfun(zpres){
	zpnum++;
	if(count>totalCount && zpnum == zpjp){
		 zpres();
		 setTimeout(function(){
		  //   $('.lottery_box .list_box').attr('class','list_box list_box'+zpjp);
			 $('.lottery_box .list_box').attr('class','list_box');
		 },800)
	} else {
		if(count>totalCount+1){
			zpnum = 0;
			zpres();
// 			alert(zpnum);
			setTimeout(function(){
			 //   $('.lottery_box .list_box').attr('class','list_box list_box'+zpjp);
				$('.lottery_box .list_box').attr('class','list_box');
			},800)
		} else {
			if(zpnum>8){
				zpnum = 0;
				count++;
			}
			if(count>=totalCount){
				speed+=30;
			}
			setTimeout(function(){
				zpfun(zpres)
			
			},speed)
			
		}
	}
	$('.lottery_box .list_box').attr('class','list_box list_box'+zpnum);
}
		</script>
		<script src="/wp-content/plugins/zibi-chojiang/pule/js/jQuery.1.9.1.js"></script>
		<script src="/wp-content/plugins/zibi-chojiang/pule/js/htpublic.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			addLoadEvent(indexFun);
		</script>
                </div>
          </div>
    </div>
    <?php get_sidebar(); ?>
</main>
<?php
get_footer();?>
<script type="text/javascript" src="/wp-content/plugins/zibi-chojiang/pule/js/jquery.barrager.min.js"></script>