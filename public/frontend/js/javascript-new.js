desktop = 1023;
tablet = 768;

function updateCatg() {
    var wWidth = jQuery(window).width();
    if(wWidth < desktop){
        jQuery('.vj-isteacher').appendTo(jQuery('.user ul'));

        jQuery('.menu-main > li > a').click(function(){
            jQuery(this).parent().find('.menu-sub').toggle();
        });

        jQuery('header.main nav .user h6').click(function(){
            jQuery(this).parent().find('ul').toggle();
        });

        jQuery('.mb__menu-main').click(function(){
            jQuery('header.main').addClass('show__menu');
        });
        jQuery('.mb_menu_close').click(function(){
            jQuery('header.main').removeClass('show__menu');
        });

        jQuery('.mb__wrap-left').click(function(){
            jQuery('.wrap__page').addClass('show__wrap-left');
        });
        jQuery('.mb_wrap-left_close').click(function(){
            jQuery('.wrap__page').removeClass('show__wrap-left');
        });
    }else{
        jQuery('.vj-isteacher').insertBefore(jQuery('.vj-search'));
        jQuery('.menu-sub').removeAttr("style");
        jQuery('header.main nav .user ul').removeAttr("style");
    }
}

$(document).ready(function () {
    updateCatg();
    jQuery(window).resize(function () {
        updateCatg();
    });
});


