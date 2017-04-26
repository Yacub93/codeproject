<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// This method will register the proper routes 
// for the new authentication controllers.
Auth::routes(); 


Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/', function () {
    return view('welcome');
});



Route::group(['middleware'=>'admin'], function(){


	Route::get('/admin', function(){

	return view('admin.index');
	
});

    Route::resource('/admin/users', 'AdminUsersController', ['names'=>[


    	'index' =>'admin.users.index',
    	'create'=>'admin.users.create',
    	'store' =>'admin.users.store',
    	'edit'  =>'admin.users.edit'




    	]]);

    Route::get('/post/{id}',['as'=>'home.post','uses'=>'AdminPostsController@post']);

    Route::resource('/admin/posts', 'AdminPostsController',['names'=>[


        'index' =>'admin.posts.index',
    	'create'=>'admin.posts.create',
    	'store' =>'admin.posts.store',
    	'edit'  =>'admin.posts.edit'




    	]]);
    Route::resource('/admin/categories', 'AdminCategoriesController',['names'=>[


        'index' =>'admin.categories.index',
    	'create'=>'admin.categories.create',
    	'store' =>'admin.categories.store',
    	'edit'  =>'admin.categories.edit'


    	]]);
    Route::resource('/admin/media', 'AdminMediasController',['names'=>[

        'index' =>'admin.media.index',
    	'create'=>'admin.media.create',
    	'store' =>'admin.media.store',
    	'edit'  =>'admin.media.edit'



    	]]);

    // Route::get('/admin/media/upload', ['as'=>'admin.media.upload']);
    Route::get('admin/media/upload', array('as'=>'admin.media.upload' ,function(){
	//Shortcut URL path uses associated array('as'=>'shortpathname')

	return view('admin.media.upload');
	}));

	Route::resource('/admin/comments', 'PostCommentsController',['names'=>[


	    'index' =>'admin.comments.index',
    	'create'=>'admin.comments.create',
    	'store' =>'admin.comments.store',
    	'edit'  =>'admin.comments.edit',
    	'show' =>'admin.comments.show'
	



		]]);
	Route::resource('/admin/comment/replies', 'CommentRepliesController',['names'=>[


        'index' =>'admin.comment.index',
    	'create'=>'admin.comment.create',
    	'store' =>'admin.comment.store',
    	'edit'  =>'admin.comment.edit',
    	'show' =>'admin.comment.show'




		]]);


});
