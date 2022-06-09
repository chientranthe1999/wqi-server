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

Route::get('images/{filename}', function ($filename)
{
    $path = storage_path('app/images/' . $filename);
    if (!File::exists($path)) {
        abort(Response::HTTP_NOT_FOUND);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return  response($file, 200)->header("Content-Type", $type);
});

