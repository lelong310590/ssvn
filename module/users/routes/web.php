<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 2:24 PM
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'users';

//Backend
Route::group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->group(['prefix' => $moduleRoute, 'middleware' => 'verfiry-admin'], function (Router $router) use ($adminRoute, $moduleRoute) {
        $router->get('setting', 'UsersController@getSetting')
            ->name('nqadmin::users.setting.get');

        $router->get('index', 'UsersController@getIndex')
            ->name('nqadmin::users.index.get');

       // $router->get('index/{email}')->name('nqadmin::users.search.get');

        $router->get('create', 'UsersController@getCreate')
            ->name('nqadmin::users.create.get');

        $router->post('create', 'UsersController@postCreate')
            ->name('nqadmin::users.create.post');

        $router->get('edit/{id}', 'UsersController@getEdit')
            ->name('nqadmin::users.edit.get');

        $router->post('edit/{id}', 'UsersController@postEdit')
            ->name('nqadmin::users.edit.post');

        $router->get('delete/{id}', 'UsersController@getDelete')
            ->name('nqadmin::users.delete.get');

        $router->get('enable', 'Google2FAController@enableTwoFactor')
            ->name('nqadmin::2fa.enable');

        $router->get('disable', 'Google2FAController@disableTwoFactor')
            ->name('nqadmin::2fa.disable');

        $router->post('disable', 'Google2FAController@disableTwoFactorPost')
            ->name('nqadmin::2fa.disable.post');

        $router->get('list-employer', 'UsersController@getEmployer')
            ->name('nqadmin::employer.index.get');

        $router->get('transfer/{id}', 'UsersController@getTransfer')
            ->name('nqadmin::employer.transfer.get');

        $router->post('transfer/{id}', 'UsersController@postTransfer')
            ->name('nqadmin::employer.transfer.post');

    });
});

//Frontend
Route::group(['namespace' => 'Frontend'], function (Router $router) {
    $router->group(['prefix' => 'users'], function (Router $router) {

        // Infomation of user (GET and POST)
        $router->get('info', 'UsersController@getInfo')
            ->name('front.users.info.get')->middleware('auth');

        $router->get('thong-ke', 'UsersController@getStat')
            ->name('fronts.user.stat.get')->middleware('auth');

        $router->get('export-excel', 'UsersController@exportExcel')
            ->name('front.users.export.get')->middleware('auth');

        // POST Lấy thông tin quân huyện, khi thay đổi thành phố Ajax
        $router->post('province', 'UsersController@postProvince')
            ->name('front.users.province.post')->middleware('auth');

        // POST Lưu toàn bộ thông tin khi bấm submit
        $router->post('info', 'UsersController@postUpdateInfo')
            ->name('front.users.info.post')->middleware('auth');

        // POST lưu địa chỉ contact với ajax
        $router->post('contact', 'UsersController@postUpdateContact')
            ->name('front.users.contact.post')->middleware('auth');

        // POST Thay avatar với ajax
        $router->post('avatar', 'UsersController@postUpdateAvatar')
            ->name('front.users.avatar.post')->middleware('auth');

        $router->get('my-course', 'UsersController@getMyCourse')
            ->name('front.users.my_course.get')->middleware('auth');

        $router->get('love-course', 'UsersController@getLoveCourse')
            ->name('front.users.love_course.get')->middleware('auth');

        $router->get('notification', 'UsersController@getNotification')
            ->name('front.users.notification.get')->middleware('auth');

        $router->get('certificate', 'UsersController@getCertificate')
            ->name('front.users.certificate.get')->middleware('auth');

        $router->get('my-certificate', 'UsersController@getMyCertificate')
            ->name('front.users.my-certificate.get')->middleware('auth');

        $router->get('employers', 'UsersController@getEmployers')
            ->name('front.users.employers.get')->middleware('auth');

        $router->post('employers', 'UsersController@postEmployers')
            ->name('front.users.employers.post')->middleware('auth');

        $router->get('history', 'UsersController@getHistory')
            ->name('front.users.history.get')->middleware('auth');

        $router->get('history/detail/{order_id}', 'UsersController@getHistoryDetail')
            ->name('front.users.history_detail.get')->middleware('auth');

        $router->get('change-password', 'UsersController@getChangePassword')
            ->name('front.users.change_password.get')->middleware('auth');

        // POST thay doi mat khau
        $router->post('change-password', 'UsersController@postChangePassword')
            ->name('front.users.change_password.post')->middleware('auth');

        //tong quan khoa hoc
        $router->get('tong-quan-khoa-hoc', 'UsersController@tongquankhoahoc')
            ->name('front.users.tong_quan_khoa_hoc.get')->middleware('auth');
        //tong quan khoa hoc hoi dap
        $router->get('tong-quan-hoi-dap', 'UsersController@tongquankhoahochoidap')
            ->name('front.users.tong_quan_khoa_hoc_hoi_dap.get')->middleware('auth');
        //tong quan khoa hoc danh gia
        $router->get('tong-quan-danh-gia', 'UsersController@tongquankhoahocdanhgia')
            ->name('front.users.tong_quan_khoa_hoc_danh_gia.get')->middleware('auth');

        //quan ly khoa hoc thong ke
        $router->get('quan-ly-khoa-hoc/{id}/thong-ke', 'UsersController@quanlykhoahocthongke')
            ->name('front.users.quan_ly_khoa_hoc_thong_ke.get')->middleware('auth', 'check-course-owner');
        //quan ly khoa hoc hoc sinh
        $router->get('quan-ly-khoa-hoc/{id}/hoc-sinh', 'UsersController@quanlykhoahochocsinh')
            ->name('front.users.quan_ly_khoa_hoc_hoc_sinh.get')->middleware('auth', 'check-course-owner');
        //quan ly khoa hoc thong bao
        $router->get('quan-ly-khoa-hoc/{id}/thong-bao', 'UsersController@quanlykhoahocthongbao')
            ->name('front.users.quan_ly_khoa_hoc_thong_bao.get')->middleware('auth', 'check-course-owner');
        //quan ly khoa hoc tao thong bao
        $router->get('quan-ly-khoa-hoc/{id}/tao-thong-bao', 'UsersController@quanlykhoahoctaothongbao')
            ->name('front.users.quan_ly_khoa_hoc_tao_thong_bao.get')->middleware('auth', 'check-course-owner');
        //quan ly khoa hoc tao thong bao submit
        $router->post('quan-ly-khoa-hoc/{id}/tao-thong-bao-default', 'UsersController@postquanlykhoahoctaothongbaodefault')
            ->name('front.users.quan_ly_khoa_hoc_tao_thong_bao_default.post')->middleware('auth', 'check-course-owner');
        //quan ly khoa hoc tao thong bao submit
        $router->post('quan-ly-khoa-hoc/{id}/tao-thong-bao', 'UsersController@postquanlykhoahoctaothongbao')
            ->name('front.users.quan_ly_khoa_hoc_tao_thong_bao.post')->middleware('auth', 'check-course-owner');
        $router->post('searchcourse', 'UsersController@searchCourse')
            ->name('front.user.search.course')->middleware('auth');
        $router->post('searchallcourse', 'UsersController@searchAllCourse')
            ->name('front.user.search.allcourse')->middleware('auth');
        //quan ly khoa hoc gia va phieu
        $router->get('quan-ly-khoa-hoc/{id}/gia', 'UsersController@quanlykhoahocgia')
            ->name('front.users.quan_ly_khoa_hoc_gia.get')->middleware('auth', 'check-course-owner');
        //quan ly khoa hoc setting
        $router->get('quan-ly-khoa-hoc/{id}/setting', 'UsersController@quanlykhoahocsetting')
            ->name('front.users.quan_ly_khoa_hoc_setting.get')->middleware('auth', 'check-course-owner');
        // POST reply review
        $router->post('reply-review', 'UsersController@postReplyReview')
            ->name('front.users.reply_review.post')->middleware('auth');
        // get delete review
        $router->get('delete-answer', 'UsersController@deleteAnswer')
            ->name('front.users.delete_answer.post')->middleware('auth');
        // POST reply review
        $router->post('reply-question', 'UsersController@postReplyQuestion')
            ->name('front.users.reply_question.post')->middleware('auth');
        // get delete answer question
        $router->get('delete-answerq', 'UsersController@deleteAnswerq')
            ->name('front.users.delete_answerq.post')->middleware('auth');
        // get delete question
        $router->get('delete-question', 'UsersController@deleteQuestion')
            ->name('front.users.delete_question.post')->middleware('auth');
        // get danh dau chua doc
        $router->get('change-read', 'UsersController@changeRead')
            ->name('front.users.change_read.post')->middleware('auth');
        // danh dau tra loi hang dau
        $router->get('change-usefull', 'UsersController@changeUsefull')
            ->name('front.users.change_usefull.post')->middleware('auth');
    });

    Route::group(['prefix' => 'profile'], function () {
        // Infomation of user (GET and POST)
        Route::get('{code}', 'UsersController@getProfile')->name('front.users.profile.get');
    });
});

