<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TermsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'HomeIndex']);
Route::post('/contactSend', [HomeController::class, 'ContactSend']);

Route::get('/course', [CourseController::class, 'CoursePage']);
Route::get('/project', [ProjectController::class, 'ProjectPage']);
Route::get('/team_member', [TeamController::class, 'TeamPage']);

Route::get('/policy', [PolicyController::class, 'PolicyPage']);
Route::get('/terms', [TermsController::class, 'TermsPage']);

Route::get('/contact', [ContactController::class, 'ContactIndex']);
