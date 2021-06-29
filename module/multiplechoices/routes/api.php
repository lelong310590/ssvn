<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

$moduleRoute = 'multiplechoices';

Route::group(['prefix' => $moduleRoute], function(Router $router) use ($moduleRoute) {
    $router->get('get-lecture-content', 'QuestionController@getContent');
	$router->group(['prefix' => 'question'], function (Router $router) {
		$router->post('add-question', 'QuestionController@addQuestion');
		$router->post('update-question', 'QuestionController@updateQuestion');
		$router->post('delete-question', 'QuestionController@deleteQuestion');
		$router->post('update-on-sort-end', 'QuestionController@onSortEnd');
		$router->get('question-length', 'QuestionController@getQuestionLength');
	});
	
	$router->group(['prefix' => 'answer'], function (Router $router) {
		$router->post('add-answers', 'AnswerController@addAnswers');
		$router->get('list-answers', 'AnswerController@getAnswers');
	});

	$router->group(['prefix' => 'test'], function (Router $router) {
        $router->post('create-test-question', 'QuestionController@createTestQuestion');
        $router->post('update-test-question', 'QuestionController@updateTestQuestion');
    });
});