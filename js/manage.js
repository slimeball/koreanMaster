$(function(){
var img_arr = [];
var banner_data = {};
// 回显local里面的数据
// var strStoreDate = localStorage.getItem("img_arr");
// strStoreDate = strStoreDate.split(",")
// for(var i = 0;strStoreDate.length>i;i++){
//     $('#j_banner_show').append('<li><img src="'+strStoreDate[i]+'"></li>')
// }

    // tab按钮切换
    for(var i=0;$('.nav li').length>i;i++){
        (function(i){
            $('.nav li').eq(i).on('click',function(){
                $('.nav li').eq(i).addClass('active').siblings().removeClass('active')
                $('.upload_box').eq(i).show().siblings().hide()
            })
        })(i)
    }

    $('#banner_input').on('change',function(){
        var formData = new FormData($( "#j_banner_form" )[0]);
        $.ajax({
            url: './upload.php?action=upload',  
            type: 'POST',  
            data: formData,  
            async: false,  
            cache: false,  
            contentType: false,  
            processData: false,  
            success: function (response) {
                console.log(response)
                response = JSON.parse(response);
                img_url = '../'+response.result.img_url;
                banner_data = {
                    'main':{'p_type':1,'img_url':img_url}
                }
                console.log(banner_data)
                img_arr.push(img_url);
                //localStorage.setItem('img_arr',img_arr)
                $('#j_banner_show').append('<li><img src="'+img_url+'"></li>');
            },  
            error: function (returndata) {  
                console.log('some questions')
            }  
        }); 
    });

    $('#j_banner_btn').on('click',function(){
        console.log(banner_data)
        $.ajax({  
            url: './upload.php?action=add' ,  
            type: 'POST',  
            data: banner_data,  
            async: false,  
            cache: false,  
            contentType: false,  
            processData: false,  
            success: function (response) {
                console.log(response)
            },  
            error: function (returndata) {  
                console.log('some questions')
            }  
        }); 
    });   
}); 