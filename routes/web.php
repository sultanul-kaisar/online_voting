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

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

//Route::get('count', function(){
//    $votedChart = \App\Model\Vote::select([DB::raw("SUM(candidate_id) as total")])
//        ->groupBy('vote_category_id')
//        ->get();
//
//    $votedChart = \App\Model\Vote::all();
//
//    dd($votedChart);
//    foreach($votedChart as $voteChart)
//    {
//        dd($voteChart->vote_category);
//    }
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('voteCategory/{slug}', 'HomeController@vote_submit')->name('vote_submit');
Route::post('vote-submit', 'HomeController@votecreate')->name('vote_submitstore');

// Backend -->


//Backend
Route::group(['prefix' => 'admin'], function () {
    Route::middleware('auth', 'check_admin_user_status')->group(function () {
        Route::get('dashboard', 'Admin\AdminController@dashboard')->name('admin.dashboard');

        //VOTE CATEGORIES
        Route::resource('candidate', 'CandidateController')->except(['show']);
        Route::resource('vote-category', 'VoteCategoryController')->except(['show']);

        //VOTERS
        Route::resource('voter', 'VoterController')->except(['show']);
        Route::get('result', 'VoteController@result')->name('admin.result');
        Route::resource('count', 'VoteController')->except(['show']);



        //SYSTEM SETTINGS
        Route::get('system/setting', 'SettingController@index')->name('admin.system.settings');
        Route::post('system/setting/general', 'SettingController@general')->name('admin.system.general.store');
        Route::post('system/setting/local', 'SettingController@local')->name('admin.system.local.store');
        Route::post('system/setting/logo', 'SettingController@logo')->name('admin.system.logo.store');
        Route::post('system/setting/admin-logo', 'SettingController@adminLogo')->name('admin.system.admin-logo.store');

        Route::get('system/seo', 'SettingController@seo')->name('admin.system.seo');
        Route::post('system/seo/save', 'SettingController@seoStore')->name('admin.system.seo.store');
        Route::post('system/og-image/save', 'SettingController@ogImage')->name('admin.seo.og.image');


        //USERS, ROLES & PERMISSION
        Route::resource(
            'permission',
            PermissionController::class,
            [
                'only' => ['index', 'create', 'store']
            ]
        );
        Route::resource('role', 'RoleController');

        Route::resource('user', 'UserController');
        Route::get('my-account', 'UserProfileController@index')->name('admin.my-account');
        Route::post('my-account/general/{user}', 'UserProfileController@general')->name('admin.my-account.general');
        Route::post('my-account/avatar/{user}', 'UserProfileController@avatar')->name('admin.my-account.avatar');
        Route::post('my-account/profile/{user}', 'UserProfileController@profile')->name('admin.my-account.profile');
        Route::post('my-account/security/{user}', 'UserProfileController@security')->name('admin.my-account.security');
    });
});
