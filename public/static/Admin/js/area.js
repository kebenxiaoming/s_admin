//显示省份
function show_province(){
    $.post(choose_province,function(result){
        result = $.parseJSON(result);
        if(result.error == 0){
            var area_dom = '<div class="cpgl_cptj_xl" style="margin-right: 10px"><select id="choose_province" name="province_id" class="col-sm-1" style="margin-right:10px;width: 135px">';
            $.each(result.list,function(i,item){
                area_dom+= '<option value="'+item.id+'" '+(item.id==$('#choose_cityarea').attr('province_id') ? 'selected="selected"' : '')+'>'+item.name+'</option>';
            });
            area_dom+= '</select></div>';
            $('#choose_cityarea').prepend(area_dom);
            show_city($('#choose_province').find('option:selected').attr('value'),$('#choose_province').find('option:selected').html(),1);
            $('#choose_province').change(function(){
                show_city($(this).find('option:selected').attr('value'),$(this).find('option:selected').html(),1);
            });
        }else if(result.error == 2){
            var area_dom = '<div class="cpgl_cptj_xl" style="margin-right: 10px"><select id="choose_province_hide" name="province_id" style="display:none;">';
            area_dom += '<option value="'+result.id+'">'+result.name+'</option>';
            area_dom += '</select></div>';
            $('#choose_cityarea').prepend(area_dom);
            show_city(result.id,result.name,0);
        }else{
            window.top.msg(0,result.info,true);
            window.top.closeiframe();
        }
    });
}
//显示城市
function show_city(id,name,type){
    $.post(choose_city,{id:id,name:name,type:type},function(result){
        result = $.parseJSON(result);
        if(result.error == 0){
            var area_dom = '<select id="choose_city" name="city_id" class="col-sm-1" style="margin-right:10px;width: 135px">';
            $.each(result.list,function(i,item){
                area_dom+= '<option value="'+item.id+'" '+(item.id==$('#choose_cityarea').attr('city_id') ? 'selected="selected"' : '')+'>'+item.name+'</option>';
            });
            area_dom+= '</select>';
            if(document.getElementById('choose_city')){
                $('#choose_city').replaceWith(area_dom);
            }else if(document.getElementById('choose_province')){
                $('#choose_province').after(area_dom);
            }else{
                $('#choose_cityarea').prepend(area_dom);
            }
            show_area($('#choose_city').find('option:selected').attr('value'),$('#choose_city').find('option:selected').html(),1);
            $('#choose_city').change(function(){
                show_area($(this).find('option:selected').attr('value'),$(this).find('option:selected').html(),1);
            });
        }else if(result.error == 2){
            var area_dom = '<select id="choose_city_hide" name="city_id" style="display:none;">';
            area_dom += '<option value="'+result.id+'">'+result.name+'</option>';
            area_dom += '</select>';
            $('#choose_cityarea').prepend(area_dom);
            show_area(result.id,result.name,0);
        }else{
            window.top.msg(0,result.info,true,5);
            window.top.closeiframe();
        }
    });
}

//显示区域
function show_area(id,name,type){
    $.post(choose_area,{id:id,name:name,type:type},function(result){
        result = $.parseJSON(result);
        if(result.error == 0){
            var area_dom = '<select id="choose_area" name="area_id" class="col-sm-1" style="margin-right:10px;width: 135px">';
            $.each(result.list,function(i,item){
                area_dom+= '<option value="'+item.id+'" '+(item.id==$('#choose_cityarea').attr('area_id') ? 'selected="selected"' : '')+'>'+item.name+'</option>';
            });
            area_dom+= '</select>';
            if(document.getElementById('choose_area')){
                $('#choose_area').replaceWith(area_dom);
            }else if(document.getElementById('choose_city')){
                $('#choose_city').after(area_dom);
            }else{
                $('#choose_cityarea').prepend(area_dom);
            }
            // if (typeof(show_circle) == 'undefined') {
            //show_circle($('#choose_area').find('option:selected').attr('value'),$('#choose_area').find('option:selected').html(),1);
            // $('#choose_area').change(function(){
            //     show_circle($(this).find('option:selected').attr('value'),$(this).find('option:selected').html(),1);
            // });
            // }
        }else{
            window.top.msg(0,result.info,true,5);
            window.top.closeiframe();
        }
    });
}
$(function(){
    //检测是否需要显示城市
    if(document.getElementById('choose_cityarea')){
        show_province();
    }
});