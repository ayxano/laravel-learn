<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
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



// Route::get('/', function () {
//     return view('home.index');
// })->name('home.index');

// Route::get('/contact', function () {
//     return view('home.contact');
// })->name('home.contact');

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new'    =>  true,
        'has_comments'  => true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new'    =>  false
    ],
    3 => [
        'title' => 'Intro to Python',
        'content' => 'This is a short intro to Python',
        'is_new'    =>  false
    ]
];

Route::get('/', [HomeController::class, 'home'])->name('home.index');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');

Route::get('/singleController', AboutController::class);

Route::resource('/posts', PostsController::class)->only(['index', 'show', 'create', 'store']);

/*
Route::get('/posts', function() use ($posts) {
    dd(request()->except(['page']));
    return view('posts.index', ['posts' => $posts]);
})->name('posts.index');

Route::get('/posts/{id}', function($id) use($posts) {
    abort_if(!isset($posts[$id]), 404);
    return view('posts.show', [
        'post' => $posts[$id]
    ]);
})
// Disabled check. Added to RouteServiceProvider.php
// ->where([
//     'id'    =>  '[0-9]+'
// ])
->name('posts.show');
*/

Route::prefix('/fun')->name('fun.')->group(function() use ($posts) {
    Route::get('/responses', function() use ($posts) {
        return response($posts, 201)
        ->header('Content-Type', 'application/json')
        ->cookie('MY_COOKIE', 'Ayxan', 3600);
    })->name('responses');
    
    Route::get('/redirect', function() {
        return redirect('/contact');
    })->name('redirect');
    
    Route::get('/back', function() {
        return back();
    })->name('back');
    
    Route::get('/named-route', function() {
        return redirect()->route('posts.show', [
            'id' => 1
        ]);
    })->name('named-route');
    
    Route::get('/away', function() {
        return redirect()->away('https://www.google.com/');
    })->name('away'); 
    
    Route::get('/json', function() use($posts) {
        return response()->json($posts);
    })->name('json');
    
    Route::get('/download', function() {
        return response()->download(public_path('/dua lipa.jpg'), 'DuaLipa.jpg');
    })->name('download');
});

Route::get('/recent-posts/{days_ago?}', function($daysAgo = 20) {
    return 'Posts from '.$daysAgo.' days ago';
})->name('posts.recent.index');