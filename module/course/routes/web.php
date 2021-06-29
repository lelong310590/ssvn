<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 1:42 PM
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$adminRoute = config('base.admin_route');
$moduleRoute = 'course';

Route::group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->group(['prefix' => $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {

        $router->get('setting', 'CourseController@getSetting')
            ->name('nqadmin::course.setting.get');

        $router->get('index', 'CourseController@getIndex')
            ->name('nqadmin::course.index.get');

        $router->get('create', 'CourseController@getCreate')
            ->name('nqadmin::course.create.get');

        $router->post('create', 'CourseController@postCreate')
            ->name('nqadmin::course.create.post');

        $router->get('delete/{id}', 'CourseController@getDelete')
            ->name('nqadmin::course.delete.get');

        //Course Landing Page
        $router->get('{id}/course-landingpage', 'CourseLandingPageController@getIndex')
            ->name('nqadmin::course.landingpage.get');

        $router->get('remove-promo/{id}', 'CourseLandingPageController@deletePromovideo')
            ->name('nqadmin::course.removepromovideo');

        $router->post('{id}/course-landingpage', 'CourseLandingPageController@postIndex')
            ->name('nqadmin::course.landingpage.post');

        //Course Targe
        $router->get('{id}/create-course-target', 'CourseTargetController@getIndex')
            ->name('nqadmin::course.target.get');

        $router->post('{id}/create-course-target', 'CourseTargetController@postIndex')
            ->name('nqadmin::course.target.post');

        //Course Curriculum
        $router->get('{id}/create-course-curriculum', 'CourseCurriculumController@getIndex')
            ->name('nqadmin::course.curriculum.get');
        $router->post('{id}/create-course-curriculum', 'CourseCurriculumController@postIndex')
            ->name('nqadmin::course.curriculum.post');
        //Course Price
        $router->get('{id}/create-course-price', 'CoursePriceController@getIndex')
            ->name('nqadmin::course.price.get');
        //Course save Price
        $router->post('{id}/create-course-price', 'CoursePriceController@save')
            ->name('nqadmin::course.price.save');

        //autocomplete tag
        $router->get('get-tag-auto', 'CourseLandingPageController@getTagAuto')
            ->name('nqadmin::course.tags.get');

        //enable course
        $router->get('enable/{id}', 'CourseController@getEnable')
            ->name('nqadmin::course.enable.get');

        $router->post('change-author/{id}', 'CourseController@changeAuthor')
            ->name('nqadmin::course.changeauthor.post');

        $router->post('change-assistant/{id}', 'CourseController@changeAssistant')
            ->name('nqadmin::course.changeassistant.post');

        //enable course post
        $router->get('enable-post/{id}', 'CourseController@postEnable')
            ->name('nqadmin::course.enable.post');

        $router->get('enable', 'CourseController@getEnableList')
            ->name('nqadmin::course.enable.list');

        $router->get('google-analytics-code/{id}', 'CourseController@googleAnalytics')
            ->name('nqadmin::course.google');

        $router->post('google-analytics-code/{id}', 'CourseController@postgoogleAnalytics')
            ->name('nqadmin::course.google.post');

        //exam setting
        $router->get('exam-setting/{id}', 'CourseController@getExamSetting')
            ->name('nqadmin::course.exam');

        $router->post('exam-setting/{id}', 'CourseController@postExamSetting')
            ->name('nqadmin::course.exam.post');


        //enable all
        $router->get('enable-all', 'CourseController@enableAll')
            ->name('nqadmin::course.enable.all');
    });
});

//Frontend
Route::group(['namespace' => 'Frontend'], function (Router $router) {
    $router->get('/{slug}', 'CourseBuyController@getIndex')
        ->name('front.course.buy.get')
        ->middleware('check-course-active');

    $router->get('/{slug}/hoc/bai-hoc/{lectureId?}/{type?}/{status?}/{resultId?}', 'LectureController@getIndex')
        ->name('nqadmin::course.lecture.learn')
        ->middleware('check-course', 'check-exam');


    //Tạo Khóa đào tạo
    $router->get('khoa-hoc/tao-khoa-hoc', 'CourseController@createCourse')
        ->name('front.course.create.get');
    $router->post('khoa-hoc/tao-khoa-hoc', 'CourseController@postCraeteCourse')
        ->name('front.course.create.post');
    $router->group(['prefix' => 'khoa-hoc/tao-khoa-hoc'], function(Router $router) {
        $router->get('{id}/landing-page', 'CourseController@khoahoclandingpage')
               ->name('front.khoahoclandingpage');
        $router->post('{id}/landing-page', 'CourseController@postkhoahoclandingpage')
               ->name('front.khoahoclandingpage.post');
    });

    //rating
    $router->post('khoa-hoc/rating', 'CourseBuyController@postRating')
        ->name('front.course.rating.post');
    $router->post('ajax/search-comment', 'CourseBuyController@ajaxPostSearchComment')
        ->name('front.ajax.searchComment');
    //dat lai tien do
    $router->get('khoa-hoc/dat-lai-tien-do/{id}', 'CourseController@resetProgress')
        ->name('front.course.resetprogress.get');
});

