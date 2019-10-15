window.onload=function () {
    var mySwiper = new Swiper ('.swiper-container1', {
        loop: true, // 循环模式选项
        // 如果需要分页器
        pagination: {
            el: '.swiper-pagination',
        },
        autoplay:{
            stopOnLastSlide:true,
        },

    })
    var swiper2 = new Swiper('.swiper-container2', {
        slidesPerView :3.5
    })

};
$(function(){
    $('.wall').jaliswall({ item: '.article' });
});