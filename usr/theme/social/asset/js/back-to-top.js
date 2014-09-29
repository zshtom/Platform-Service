/**
 * Created by admin on 14-9-29.
 */
    //绑定页面滚动事件
$(function(){
    var backTop = $('.back-to-top');
    $(window).bind('scroll',function(){
        var len=$(this).scrollTop();
        if(len>=100){
            //显示回到顶部按钮
            backTop.show();
        }else{
        //影藏回到顶部按钮
            backTop.hide();
        }
    });
    //绑定回到顶部按钮的点击事件
    backTop.click(function(){
        //动画效果，平滑滚动回到顶部
        $("body, html").animate({ scrollTop: 0 });
        //不需要动画则直接
        //$(document).scrollTop(0);
    });
});
