<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Zipcoder/ZipCodeWilmington-Cohort-4.0-Java-Assessment-1

Route::get('repos', 'TravisCIController@repos');
Route::get('builds/{repo_name}', 'TravisCIController@builds');
Route::get('pullRequests/{repo_name}', 'TravisCIController@pullRequests');
Route::get('repository/{repo_name}', 'TravisCIController@repository');
Route::get('job/{job_id}', 'TravisCIController@job');
Route::get('jobLog/{job_id}', 'TravisCIController@jobLog');
