<?php

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

Route::get('/', function () {
    echo "1906weixin";"<br>";
//    echo date("Y-m-d H:i:s");
//    echo 666666666;die;
//    phpinfo();die;
    return view('welcome');
});

Route::get('/curl/post1','TestController@curlPost1');  //curl测试form-data
Route::get('/curl/post2','TestController@curlPost2');  //curl测试form-urlencoded
Route::get('/curl/post3','TestController@curlPost3');  //curl测试raw

Route::get('/curl/upload','TestController@curlUpload');  //curl post上传文件

Route::get('/guzzle/get1','TestController@guzzleGet1');  //guzzle get
Route::get('/guzzle/post1','TestController@guzzlePost1');  //guzzle post
Route::get('/guzzle/post2','TestController@guzzlePost2');  //guzzle post 上传文件

Route::get('/test1','TestController@test1');