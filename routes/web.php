<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/profile', function () {
    return view('index');
});

Auth::routes();

Route::get('/', 'home\HomeController@index');
Route::get('/privacy', 'home\HomeController@contact');
Route::get('/about', 'home\HomeController@contact');
Route::get('/questions', 'home\HomeController@contact');
Route::get('/contact', 'home\HomeController@contact');
Route::post('/home/contact/store', 'home\HomeController@contactStore');
Route::get('/home/search_box/{id}', 'home\HomeController@search_box');
Route::get('/home/search_box2/{id}', 'home\HomeController@search_box2');
Route::get('/home/search', 'home\HomeController@search');
Route::get('/single/{id}', 'home\HomeController@single');
Route::get('/like/{id}', 'home\HomeController@like');
Route::post('/comment/{id}', 'home\HomeController@comment');

Route::get('/add_compare_list/{id}', 'home\CompareController@addDataSession');
Route::get('/destroy_compare_list/{id}', 'home\CompareController@destroyDataSession');
Route::get('/compare/', 'home\CompareController@posters');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::post('/password', 'HomeController@password');

// upload sector
//Route::post('sector', 'HomeController@sector');

Route::get('/panel', 'HomeController@index');

Route::group(['prefix' => 'panel', 'namespace' => 'panel', 'middleware' => 'auth'], function () {

    Route::get('/about', 'SiteController@about');
    Route::get('/questions', 'SiteController@questions');
    Route::get('/contact', 'SiteController@contact');
    Route::post('/store-about', 'SiteController@storeAbout');
    Route::post('/store-questions', 'SiteController@storeQuestions');
    Route::post('/store-contact', 'SiteController@storeContact');

    Route::post('/comments/{id}', 'CommentController@index');
    Route::post('/comment/store', 'CommentController@store');
    Route::any('/comment/destroy/{id}', 'CommentController@destroy');

    Route::resource('forms', 'FormController');
    Route::any('/forms/userDestroy/{id}', 'FormController@delete');

    # Fields
    Route::resource('fields', 'FieldController');
    Route::any('/fields/fieldsDestroy/{id}', 'FieldController@destroyField');
    Route::get('forms_fields/{id}', 'FieldController@field');
    Route::get('fields_id/{id}', 'FieldController@edit');
    Route::put('fieldAjaxStatus/{id}', 'FieldController@fieldAjaxStatus');
    Route::put('fieldAjaxQuestionStatus/{id}', 'FieldController@fieldAjaxQuestionStatus');
    Route::put('fieldAjaxRequiredStatus/{id}', 'FieldController@fieldAjaxRequiredStatus');
    Route::put('forms/fields/changeTypeAjax/{id}', 'FieldController@changeTypeAjax');
    Route::get('/fields_options/{id}', 'FieldController@option');
    Route::post('/fieldsOptionLoad/{id}', 'FieldController@optionLoad');
    Route::post('/fieldOptions', 'FieldController@optionStore');
    Route::put('optionAjaxStatus/{id}', 'FieldController@optionAjaxStatus');
    Route::delete('fields/options/{id}', 'FieldController@destroyOption');
    Route::get('formFieldGetAjax', 'FieldController@formFieldGetAjax');
    Route::any('/options/optionsDestroy/{id}', 'FieldController@destroyOption');

    Route::resource('poster', 'PosterController');
    Route::get('poster-load', 'PosterController@load');
    Route::post('/poster/detail/{id}', 'PosterController@detail');
    Route::post('/poster/comment/{id}', 'PosterController@comment');
    Route::post('/poster/commentUpdate', 'PosterController@commentUpdate');
    Route::any('/poster/posterDestroy/{id}', 'PosterController@delete');
    Route::get('/poster_images/{id}', 'PosterController@images');
    Route::post('/poster/image-upload/', 'PosterController@image_upload');
    Route::any('/poster/posterImageDestroy/{id}', 'PosterController@posterImageDestroy');

    Route::get('/poster_files/{id}', 'PosterController@files');
    Route::post('/poster/file-upload/', 'PosterController@file_upload');
    Route::any('/poster/posterFileDestroy/{id}', 'PosterController@posterFileDestroy');
    Route::get('poster/save/{id}', [
        'as' => 'poster.download', 'uses' => 'PosterController@downloadfile']);
    Route::get('/poster/favorite/{id}', 'PosterController@favorite');
    Route::get('/poster/verify/{id}', 'PosterController@verify');
    Route::get('/poster/sold/{id}', 'PosterController@sold');

    Route::resource('users', 'UserController');;
    Route::any('/users/userDestroy/{id}', 'UserController@delete');
    Route::get('/users-favorites', 'UserController@favorite');
    Route::get('/users/delete-favorites/{id}', 'UserController@delete_favorites');

    Route::any('/deleteImage/{id}', 'PanelController@deleteImage');
    Route::resource('roles', 'RoleController');


    Route::resource('estates', 'EstateController');
    Route::any('/estates/estatesDestroy/{id}', 'EstateController@delete');

    Route::post('map', 'PosterController@map');

});

