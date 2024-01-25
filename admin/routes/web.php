<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\VisitorController;
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

Route::get('/', [HomeController::class, 'HomeIndex'])->middleware('loginCheck');
Route::get('/visitor', [VisitorController::class, 'VisitorIndex'])->middleware('loginCheck');

//Admin Panel Service Management
Route::get('/services', [ServicesController::class, 'ServicesIndex'])->middleware('loginCheck');
Route::get('/getServicesData', [ServicesController::class, 'getServicesData'])->middleware('loginCheck');
Route::post('/serviceDelete', [ServicesController::class, 'serviceDelete'])->middleware('loginCheck');
Route::post('/updateServiceDetails', [ServicesController::class, 'updateServiceDetails'])->middleware('loginCheck');
Route::post('/serviceUpdate', [ServicesController::class, 'serviceUpdate'])->middleware('loginCheck');
Route::post('/serviceAdd', [ServicesController::class, 'serviceAdd'])->middleware('loginCheck');

//Admin Panel Courses Management
Route::get('/courses', [CoursesController::class, 'CoursesIndex'])->middleware('loginCheck');
Route::get('/getCoursesData', [CoursesController::class, 'getCoursesData'])->middleware('loginCheck');
Route::post('/courseDelete', [CoursesController::class, 'courseDelete'])->middleware('loginCheck');
Route::post('/updateCourseDetails', [CoursesController::class, 'updateCourseDetails'])->middleware('loginCheck');
Route::post('/courseUpdate', [CoursesController::class, 'courseUpdate'])->middleware('loginCheck');
Route::post('/courseAdd', [CoursesController::class, 'courseAdd'])->middleware('loginCheck');

//Admin Panel Projects Management
Route::get('/projects', [ProjectsController::class, 'ProjectsIndex'])->middleware('loginCheck');
Route::get('/getProjectsData', [ProjectsController::class, 'getProjectsData'])->middleware('loginCheck');
Route::post('/projectDelete', [ProjectsController::class, 'projectDelete'])->middleware('loginCheck');
Route::post('/updateProjectDetails', [ProjectsController::class, 'updateProjectDetails'])->middleware('loginCheck');
Route::post('/projectUpdate', [ProjectsController::class, 'projectUpdate'])->middleware('loginCheck');
Route::post('/projectAdd', [ProjectsController::class, 'projectAdd'])->middleware('loginCheck');

//Admin Panel Team Management
Route::get('/team_member', [TeamController::class, 'TeamIndex'])->middleware('loginCheck');
Route::get('/getTeamData', [TeamController::class, 'getTeamData'])->middleware('loginCheck');
Route::post('/teamDelete', [TeamController::class, 'teamDelete'])->middleware('loginCheck');
Route::post('/updateTeamDetails', [TeamController::class, 'updateTeamDetails'])->middleware('loginCheck');
Route::post('/teamUpdate', [TeamController::class, 'teamUpdate'])->middleware('loginCheck');
Route::post('/teamAdd', [TeamController::class, 'teamAdd'])->middleware('loginCheck');

//Admin Panel Contact Management
Route::get('/contact', [ContactController::class, 'ContactIndex'])->middleware('loginCheck');
Route::get('/getContactData', [ContactController::class, 'getContactData'])->middleware('loginCheck');
Route::post('/updateContactDetails', [ContactController::class, 'updateContactDetails'])->middleware('loginCheck');
Route::post('/contactDelete', [ContactController::class, 'contactDelete'])->middleware('loginCheck');

//Admin Panel Review Management
Route::get('/review', [ReviewController::class, 'ReviewIndex'])->middleware('loginCheck');
Route::get('/getReviewData', [ReviewController::class, 'getReviewData'])->middleware('loginCheck');
Route::post('/reviewDelete', [ReviewController::class, 'reviewDelete'])->middleware('loginCheck');
Route::post('/updateReviewDetails', [ReviewController::class, 'updateReviewDetails'])->middleware('loginCheck');
Route::post('/reviewUpdate', [ReviewController::class, 'reviewUpdate'])->middleware('loginCheck');
Route::post('/reviewAdd', [ReviewController::class, 'reviewAdd'])->middleware('loginCheck');

//Admin Panel Login Management
Route::get('/login', [LoginController::class, 'loginIndex']);
Route::post('/onLogin', [LoginController::class, 'onLogin']);
Route::get('/onLogout', [LoginController::class, 'onLogout']);

//Admin Panel Photo Gallery Management
Route::get('/photo', [PhotoController::class, 'PhotoIndex'])->middleware('loginCheck');
Route::post('/photoUpload', [PhotoController::class, 'photoUpload'])->middleware('loginCheck');

Route::get('/photoJSON', [PhotoController::class, 'photoJSON'])->middleware('loginCheck');
Route::get('/photoJSONById/{id}', [PhotoController::class, 'photoJSONById'])->middleware('loginCheck');
Route::post('/photoDelete', [PhotoController::class, 'photoDelete'])->middleware('loginCheck');
