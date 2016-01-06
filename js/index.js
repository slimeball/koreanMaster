$(function(){
	//首页banner
	var bannerSwiper = new Swiper('.swiper-container',{
	pagination: '.pagination',
	loop:true,
	autoplay: 3000,
	grabCursor: true,
	paginationClickable: true
	})

	//客片展示
	var caseSwiper = new Swiper('.swiper-container-case',{
		pagination: '.pagination-case',
		loop:true,
		// autoplay: 3000,
		grabCursor: true,
		paginationClickable: true
	})


	$('.nav li').ready(function(){
		for(var i=0;i<$(this).find('.nav li a').length;i++){
			if(location.hash == $(this).find('.nav li a').eq(i).attr('href')){
				$(this).find('.nav li').eq(i).addClass('nav_current')
				.siblings().removeClass('nav_current')
			}
		}
	})

	$('.nav li').on('click',function(){
		$(this).addClass('nav_current')
		.siblings().removeClass('nav_current')
	})
	// 新闻活动
    $(document).ready(function () {
        $(".ix_new .ix_new_main img").hover(function () {
           $(".ix_new .ix_new_main img").not($(this)).stop().animate({ opacity: 0.5 }, 500);
        }, function () {
            $(".ix_new .ix_new_main img").not($(this)).stop().animate({ opacity: 1 }, 500);
        });
    })

	//图片集 works
    $('.ix_works_subpic').find('.ix_works_subone').on('mouseover',function(){
        $(this).addClass('curpic')
        .siblings().removeClass('curpic');
        var curnum = $(this).index()+1;
        var subpicsrc = $(this).find('img').attr('src');
        $('.ix_works_banner').find('img').attr('src',subpicsrc);
        $('.ix_works_banner').find('a').attr('href',"./works0"+curnum+".html")
    })
    $('ix_show_case_pic').on('mouseover',function(){
    	$(this).css('background-color','#000')
   	})

	$('.ix_works_subpic_wrap').css('width',$('.ix_works_subone').length*217+100)
	//works 左箭头
	$('.ix_works_sub').find('.arrow-left').on('click',function(){
		for(var i=0;i<$('.ix_works_subone').length;i++){
			if($('.ix_works_subone').eq(i).hasClass('curpic')){
				if(i==0){
					$('.ix_works_subone:last').addClass('curpic').
					siblings().removeClass('curpic');
					var subpicsrc = $('.ix_works_subone:last').find('img').attr('src');
					$('.ix_works_banner').find('img').attr('src',subpicsrc);
					$('.ix_works_banner').find('a').attr('href',"./works0"+i+".html")
					return false
				}else{
					$('.ix_works_subone').eq(i-1).addClass('curpic').
					siblings().removeClass('curpic');
					var subpicsrc = $('.ix_works_subone').eq(i-1).find('img').attr('src');
					$('.ix_works_banner').find('img').attr('src',subpicsrc);
					$('.ix_works_banner').find('a').attr('href',"./works0"+i+".html")
				}

			}
		}
		
	})
	//works 右箭头
	$('.ix_works_sub').find('.arrow-right').on('click',function(){
		for(var i=0;i<$('.ix_works_subone').length;i++){
			if($('.ix_works_subone').eq(i).hasClass('curpic')){
				$('.ix_works_subone').eq(i+1).addClass('curpic').
				siblings().removeClass('curpic');
				var subpicsrc = $('.ix_works_subone').eq(i+1).find('img').attr('src');
				$('.ix_works_banner').find('img').attr('src',subpicsrc)
				$('.ix_works_banner').find('a').attr('href',"./works0"+i+".html")
				return false;
			}else if($('.ix_works_subone:last').hasClass('curpic')){
				$('.ix_works_subone').eq(i).addClass('curpic').
				siblings().removeClass('curpic');
				var subpicsrc = $('.ix_works_subone').eq(i).find('img').attr('src');
				$('.ix_works_banner').find('img').attr('src',subpicsrc);
				$('.ix_works_banner').find('a').attr('href',"./works0"+i+".html")
			}
		}
	})
})