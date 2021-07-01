function updateCatg() {
    var courseHeight = $('.box-course-search .main-course .course').height();
    $('.box-course-search .main-course .course .right-course').css("min-height",courseHeight);
    var wH = jQuery(window).height();
    var windowWidth = jQuery(window).width();
    var PopupWidth = $(".main-popup").width();
    var ContainerWidth = $(".container").width();
    var HeaderHeight = $("header").height();
    var TabBottomHeight = $(".tab-question .bottom-fix").height();
    var TopLibraryHeight = $(".top-library .top-header").height();
    var BottomFixHeight = $(".bottom-fix").height();
    var NavTabHeight = $(".main-library ul.nav-tabs").height();

    var PopupHeight = $(".main-popup").height();
    $('body').css("min-height", wH);
    if (windowWidth < 1025) {
        $(".list-category .li-level-1 .lable-list i").addClass("click-menu");
        $('.list-category .li-level-1 .lable-list i.click-menu').click(function () {
            $(this).parent().parent().find('.level-2').show();
        });
        $(".menu-show-level").css("max-height", wH);
        $('.box-popup .main-popup, .box-view-fast').css("max-height", wH - 20);

    } else {
        $(".list-category .li-level-1 .lable-list i").removeClass("click-menu");
        $("header .left-menu .menu-category").removeClass("show-menu-mobile");
        $('.box-popup .main-popup').removeAttr("style");
    }
    $('.main-popup').css("margin-left", -(PopupWidth/2)).css("margin-top", (wH - PopupHeight)/4);
    $('.box-finish-lesson').css("height", wH);
    $('.height-full').css("min-height", wH - HeaderHeight - TopLibraryHeight);
    $('.content-quiz').css("min-height", wH - HeaderHeight - BottomFixHeight - TopLibraryHeight);
    $('.video-lesson').css("height", wH - HeaderHeight - BottomFixHeight - TopLibraryHeight);
    $('.top-library .tab-content-course,.top-library .tab-question, .box-post-comment-question').css("height", wH - HeaderHeight - TopLibraryHeight - NavTabHeight - 2);
    $('.tab-noti .content-tab-noti textarea').css("height", wH - HeaderHeight - TopLibraryHeight - NavTabHeight - 20);
    $('.top-library .tab-question .box-list-question-tab .main-comment-course,.top-library .tab-question .box-comment-question-detail .list-course-announcement .comment-course').css("max-height", wH - HeaderHeight - TopLibraryHeight - NavTabHeight - TabBottomHeight - 98);
}

function toggleFullScreen() {
    if ((document.fullScreenElement && document.fullScreenElement !== null) ||
        (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}

function textCounter(field,cnt, maxlimit) {
    if ($(field).val().length > maxlimit){
        $(field).val(field.value.substring(0, maxlimit));
    }
    else{
        $(cnt).val(maxlimit - $(field).val().length);
    }

}

    $(document).ready(function () {
        $('.btn-popup').click(function() {
            var loginBox = $(this).attr('href');
            $(loginBox).fadeIn(300);
            return false;
        });

        $('body').click(function () {
            $('.box-search .box-dropdown, .box-view-fast, .box-dropdown-single .form-dropdown, header .box-search .box-dropdown').hide();
    });

    $('.box-search .txt-form, .main-course .course .bottom-course a.view-fast, .box-view-fast, .box-dropdown-single .show-txt, .header .main-menu-header, header .box-search, .box-popup-opportunity .box-search ').click(function (event) {
        event.stopPropagation();
    });

    $('header .box-search').click(function () {
        $(this).toggleClass('show-form-search');
    });
    $('.box-popup-opportunity .box-search').click(function () {
        $('.box-popup-opportunity .box-search .box-dropdown').show();
    });

    var windowWidth = jQuery(window).width();
    var wH = jQuery(window).height();
    if (windowWidth < 767) {
        $('header .left-menu .menu-category .label-menu').addClass("click-menu");
        $('header .mb__menu-main').click(function () {
            $('.menu-mobile').addClass('show-menu-mobile');
            $('.bg-overflow').show();
        });
        $('header .menu-mobile  .left-menu .menu-category .label-menu.click-menu').click(function () {
            $('.menu-show-level').addClass('show-menu-mobile');
        });
        $('header .menu-mobile .list-category .li-level-1 .lable-list').click(function () {
            $(this).parent().find('.level-2').addClass('show-menu-mobile');
        });
        $('header .menu-mobile  .list-category .li-level-1 .back').click(function () {
            $(this).parent().removeClass('show-menu-mobile');
        });
        $('header .menu-mobile  .list-category .li-level-1.back').click(function () {
            $(this).parent().parent().removeClass('show-menu-mobile');
        });
        //$('header .box-search .form-group').addClass('form-group-mobile');
        //$('header .box-search .form-group.form-group-mobile').click(function () {
        //    $('header .box-search .form-group.form-group-mobile').css('width','auto');
        //});

        $('body').click(function () {
            $('header .box-search .form-group').removeAttr("style");
        });
        $('header .box-search').click(function (event) {
            event.stopPropagation();
        });

    } else {
        $('header .left-menu .menu-category .label-menu').removeClass("click-menu");
    }

    $('.box-search .txt-form').focus(function () {
        $(this).parent().parent().find('.box-dropdown').toggleClass('dropdown-search-show');
    });

    $('.top-library .tab-question .box-list-question-tab .list-comment').click(function () {
        $(this).parent().parent().parent().parent().parent().parent().find('.tab-list-question').hide();
        $(this).parent().parent().parent().parent().parent().parent().find('.box-comment-question-detail').show();
    });

    $('.tab-question .btn-post-question').click(function () {
        $(this).parent().parent().parent().parent().parent().parent().find('.tab-list-question').hide();
        $(this).parent().parent().parent().parent().parent().parent().find('.box-post-comment-question').show();
    });

    $('.tab-question .box-back .back-tab').click(function () {
        $(this).parent().parent().hide();
        $(this).parent().parent().parent().find('.tab-list-question').show();
    });

    $('.bg-overflow').click(function () {
        $(this).hide();
        $('.menu-mobile').removeClass('show-menu-mobile');
    });

    $('.box-view-fast .close-popup').click(function () {
        $(this).parent().hide();
        $('.bg-overflow').hide();

    });

    $('.btn-follow').click(function () {
        $(this).toggleClass('btn-followed');
    });

    $('.top-header .icon-close').click(function () {
        $('.top-header').hide();
    });

    $('.top-library .icon-library .icon').click(function () {
        $('.box-library, .width-right').toggleClass('show-library');
    });

    $('.box-dropdown-single .show-txt').click(function () {
        $(this).parent().parent().find('.form-dropdown').toggle();
    });

    $('.box-select .txt-find').click(function () {
        $(this).parent().find('.list-select').toggle();
    });

    $('.close-popup').click(function () {
        $('.box-popup').hide();
    });

    $('.favorite').click(function () {
        $(this).toggleClass('loved');
    });

    $('.content-menu .label-menu').click(function () {
        $('.menu-show-level').show('');
    });

    $('.box-form-default .form .default .text-change').click(function () {
        $(this).parent().parent().hide();
        $(this).parent().parent().parent().find('.change-form').show();
    });

    $('.box-form-default .form .change-form .cancel,.box-form-default .form .change-form .save').click(function () {
        $(this).parent().parent().parent().parent().hide();
        $(this).parent().parent().parent().parent().parent().find('.default').show();
    });

    $('.box-img .show-img').click(function () {
        $(this).hide();
        $(this).parent().find('.show-video').show();
    });

    $('.main-course .course .bottom-course a.view-fast').click(function () {
        $('.box-view-fast').show();
        $('.bg-overflow').show();
    });

    $('.content-active .show-more').click(function () {
        $(this).parent().find('.main').toggleClass('show-all');
    });

    $('.less').click(function () {
        $(this).toggleClass('more');
    });

    $('.des-comment .less').click(function () {
        $(this).parent().toggleClass('show-all');
    });

    $('.text-center .less').click(function () {
        $(this).parent().parent().toggleClass('show-all');
    });

    $('.box-about-course .content-about-course .less').click(function () {
        $(this).parent().parent().toggleClass('show-all');
    });

    $('.question .btn').click(function () {
        $('.show-message').show();
    });

    $('.list .check').click(function () {
        $(this).toggleClass('checked');
    });

    $('.box-resources .top-resources').click(function () {
        $(this).parent().toggleClass('show-all');
    });

    $('.list-comment .right .icon-exclamation').click(function () {
        $(this).parent().toggleClass('show-all');
    });

    $('.pop-noti .icon-noti-table ').click(function () {
        $(this).parent().toggleClass('show-popup');
    });

    $('.favorite-message , .left-message .content .icon').click(function () {
        $(this).toggleClass('favorite');
    });

    $('.form-select-course .content ul li span .fa-times-circle ').click(function () {
        $(this).parent().parent().hide();
    });

    $('.form-select-course .close-select').click(function () {
        $(this).parent().parent().find('.content ul li').hide();
        $(this).hide();
    });

    $(window).scroll(function () {
        $(window).scrollTop() > 300 ? $(".go_top").addClass("go_tops") : $(".go_top").removeClass("go_tops")
    });

    var allStart=$(".box-course").find(".main-course");
    for (var i = 0; i < allStart.length; i++) {
        $(allStart[i]).addClass("main-course-"+(i+1));
    }

    updateCatg();
    jQuery(window).resize(function () {
        updateCatg();
    });

    // $('.owl-carousel').owlCarousel({
    //     itemsCustom: [
    //         [320, 1],
    //         [480, 2],
    //         [768, 3],
    //         [1024, 4],
    //         [1200, 5]
    //     ],
    //     navigation: true,
    //     autoPlay: true
    // });
    //
    // $('.owl-carousel').owlCarousel({
    //     itemsCustom: [
    //         [320, 1],
    //         [480, 2],
    //         [768, 3],
    //         [1024, 4],
    //         [1200, 5]
    //     ],
    //     navigation: true,
    //     autoPlay: true
    // });
    //
    // $('.box-story .owl-carousel-1').owlCarousel({
    //     itemsCustom: [
    //         [320, 1],
    //         [480, 1],
    //         [768, 2],
    //         [1024, 3],
    //         [1200, 3]
    //     ],
    //     navigation: true,
    //     autoPlay: true
    // });

    //ClassicEditor.create( document.querySelector( '#editor' ) );

    if ($('.datetimepicker') > 0) {
        $('.datetimepicker').datetimepicker();
    }
});


