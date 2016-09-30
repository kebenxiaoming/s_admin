 $(function(){
        $(".sideMenu .nLi h3").click(function(){
            if($(this).parent(".nLi").hasClass("on")){
                //当前状态展开的时候，继续点击无效
            }else{
                $(this).parents("ul").find(".sub").slideUp(300,function(){
                    $(this).parents("ul").find(".nLi").removeClass("on");
                });
                $(this).next(".sub").slideDown(300,function(){
                    $(this).parent(".nLi").addClass("on");
                });
            }
        })
    })// JavaScript Document