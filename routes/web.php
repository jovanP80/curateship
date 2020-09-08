<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Entities\Post;

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



Route::get('/',function(){
    $posts = Post::where('is_published', 1)->get();

    return view('site1.index', compact('posts'));
});

Route::get('/site1',function(){
    return view('site1.index');
  });

  Route::get('/site1/blog',function(){
    return view('site1.pages.blog');
  });

  Route::get('/site1/profile',function(){
    return view('site1.pages.profile');
  });

  Route::get('/site1/post',function(){
    return view('site1.pages.post');
  });

  Route::get('/site1/user-controlpanel',function(){
    return view('site1.pages.user-controlpanel');
  });

  Route::get('/site1/home',function(){
    return view('site1.home');
  });

  Route::get('/site2',function(){
    return view('site2.index');
  });
