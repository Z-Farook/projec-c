<?php
use App\Http\Middleware\AdminCheck;

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
    return view('welcome');
})->name('main');
Route::get('/test', 'OrderController@createPayment');
Route::get('/getpaymentstatus', 'OrderController@getPaymentStatus');
Route::get('/getseats', 'OrderController@getSeats');
Route::get('/getreservedseats', 'OrderController@getReservedSeats');
Route::get('/isloggedin', 'OrderController@isLoggedIn');
Route::get('/getReservedSeatsByReservationId', 'OrderController@getReservedSeatsByReservationId');
Route::get('/getpaymenthistory', 'OrderController@getPaymentHistory');
Route::get('/getfoodbyreservationid', 'OrderController@getFoodByReservationId');

Auth::routes(['verify' => true]);

Route::group(['middleware' => [AdminCheck::class]], function() {
    Route::get('admin', 'Auth\AccountController@admin')->name('admin');
    Route::get('admin/films', 'Auth\AccountController@admin_movies')->name('admin_movies');
    Route::get('admin/acteurs', 'Auth\AccountController@admin_actors')->name('admin_actors');
    Route::get('admin/gebruikers', 'Auth\AccountController@admin_users')->name('admin_users');
    Route::get('admin/zalen', 'Auth\AccountController@admin_rooms')->name('admin_rooms');
    Route::get('admin/shows', 'Auth\AccountController@admin_shows')->name('admin_shows');
    Route::get('admin/foods', 'Auth\AccountController@admin_foods')->name('admin_foods');
    Route::get('admin/dashboard', 'Auth\AccountController@admin_dashboard')->name('admin_dashboard');
    Route::get('admin/users', 'Auth\AccountController@admin_users')->name('admin_users');
});

Route::get('/account', 'Auth\AccountController@index')->name('account');

Route::resource('movies', 'MovieController');
Route::resource('actors', 'ActorController');
Route::resource('roles', 'RoleController');
Route::resource('prodcomps', 'ProdCompController');
Route::resource('types', 'TypeController');
Route::resource('genres', 'GenreController');
Route::resource('genrebestellingen', 'Genre-bestellingenController');
Route::resource('bezoekers', 'BezoekerController');
Route::get('/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '(.*)');