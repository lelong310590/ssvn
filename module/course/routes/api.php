<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 1:42 PM
 */
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$moduleRoute = 'course';

Route::group(['prefix' => $moduleRoute], function(Router $router) use ($moduleRoute) {
	$router->group(['prefix' => 'curriculum'], function (Router $router) {
		$router->get('get-all-items', 'CourseCurriculumItemsController@getAllItems');
		$router->post('add-item', 'CourseCurriculumItemsController@addItem');
		$router->post('delete-item', 'CourseCurriculumItemsController@deleteItem');
		$router->post('update-item', 'CourseCurriculumItemsController@updateItem');
		$router->post('update-on-sort-end', 'CourseCurriculumItemsController@onSortEnd');
		$router->post('update-description', 'CourseCurriculumItemsController@updateDescription');
		$router->post('update-course-status', 'CourseCurriculumItemsController@updateStatus');
		$router->post('update-preview-status', 'CourseCurriculumItemsController@updatePreview');
		$router->get('related-curriculum', 'CourseCurriculumItemsController@getRelatedItems');
		$router->get('get-lecture-info', 'CourseCurriculumItemsController@getLectureInfo');

		$router->get('get-section-item', 'CourseCurriculumItemsController@getAllSection');
		$router->get('get-lecture-in-section', 'CourseCurriculumItemsController@getLectureInSection');
		$router->get('get-lecture-info-route', 'CourseCurriculumItemsController@getLectureInfoRoute');

		$router->get('get-video', 'CourseCurriculumItemsController@getVideo');
		$router->get('get-slug-via-lectureid', 'CourseCurriculumItemsController@getSlug');
		$router->post('get-all-question-and-answer', 'CourseCurriculumItemsController@getAllQuestions');
		$router->post('upload-image', 'CourseCurriculumItemsController@uploadImage');

		$router->post('search-curriculum', 'CourseCurriculumItemsController@searchCurriculum');
		$router->post('report', 'Frontend\LectureReportController@store');
	});

	$router->group(['prefix' => 'test'], function (Router $router) {
        $router->post('submit-lecture', 'TestResultController@submitTest');
        $router->post('check-answer', 'TestResultController@checkAnswer');
        $router->get('get-result', 'TestResultController@getResult');
        $router->get('result-detail', 'TestResultController@resultReview');
        $router->get('leaderboard', 'TestResultController@getLeaderboards');
    });

	$router->group(['prefix' => 'process'], function (Router $router) {
	    $router->get('get-process', 'CurriculumProcessController@getProcess');
	    $router->post('change-process', 'CurriculumProcessController@changeProcess');
	    $router->post('update-last-process', 'CourseCurriculumItemsController@updateLastCurriculum');
    });
});