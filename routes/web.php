<?php

use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
    //$markdown = Storage::get('../resources/views/project.md');
    $markdown = Markdown::parse(File::get('../resources/views/project.md'));
    return view('welcome', [
        'markdown' => $markdown
    ]);
});

//require __DIR__ . '/auth.php';
