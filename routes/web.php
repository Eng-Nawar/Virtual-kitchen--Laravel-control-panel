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
    return view('welcome');
});

Auth::routes();



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

//Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);

	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::resource('items', 'App\Http\Controllers\ItemsController');
    Route::prefix('items')->name('items.')->group(function () {
        Route::get('reorder/{up}', 'App\Http\Controllers\ItemsController@reorderCategories')->name('reorder');
        Route::get('list', 'App\Http\Controllers\ItemsController@index')->name('admin');

        // Options
        Route::get('options/{item}', 'App\Http\Controllers\Items\OptionsController@index')->name('options.index');
        Route::get('options/{option}/edit', 'App\Http\Controllers\Items\OptionsController@edit')->name('options.edit');
        Route::get('options/{item}/create', 'App\Http\Controllers\Items\OptionsController@create')->name('options.create');
        Route::post('options/{item}', 'App\Http\Controllers\Items\OptionsController@store')->name('options.store');
        Route::put('options/{option}', 'App\Http\Controllers\Items\OptionsController@update')->name('options.update');
        Route::get('options/del/{option}', 'App\Http\Controllers\Items\OptionsController@destroy')->name('options.delete');

        // Variants
        Route::get('variants/{item}', 'App\Http\Controllers\Items\VariantsController@index')->name('variants.index');
        Route::get('variants/{variant}/edit', 'App\Http\Controllers\Items\VariantsController@edit')->name('variants.edit');
        Route::get('variants/{item}/create', 'App\Http\Controllers\Items\VariantsController@create')->name('variants.create');
        Route::post('variants/{item}', 'App\Http\Controllers\Items\VariantsController@store')->name('variants.store');
        Route::put('variants/{variant}', 'App\Http\Controllers\Items\VariantsController@update')->name('variants.update');

        Route::get('variants/del/{variant}', 'App\Http\Controllers\Items\VariantsController@destroy')->name('variants.delete');
    });
	Route::post('/import/items', 'App\Http\Controllers\ItemsController@import')->name('import.items');
    Route::post('/item/change/{item}', 'App\Http\Controllers\ItemsController@change');
    Route::post('/{item}/extras', 'App\Http\Controllers\ItemsController@storeExtras')->name('extras.store');
    Route::post('/{item}/extras/edit', 'App\Http\Controllers\ItemsController@editExtras')->name('extras.edit');
    Route::delete('/{item}/extras/{extras}', 'App\Http\Controllers\ItemsController@deleteExtras')->name('extras.destroy');

    Route::resource('categories', 'App\Http\Controllers\CategoriesController');

	Route::resource('drivers', 'App\Http\Controllers\DriverController');
    Route::get('/driver/{driver}/activate', 'App\Http\Controllers\DriverController@activateDriver')->name('driver.activate');
    Route::get('driverlocations', 'App\Http\Controllers\DriverController@driverlocations');
	//Register driver
	Route::get('new/driver/register', 'App\Http\Controllers\DriverController@register')->name('driver.register');
	Route::post('new/driver/register/store', 'App\Http\Controllers\DriverController@registerStore')->name('driver.register.store');

// assets and stcok
// Assets
 	Route::delete('assets/destroy', 'App\Http\Controllers\AssetsController@massDestroy')->name('assets.massDestroy');
	Route::resource('assets', 'App\Http\Controllers\AssetsController');
// Stocks
    //Route::delete('stocks/destroy', 'StocksController@massDestroy')->name('stocks.massDestroy');
    Route::resource('stocks', 'App\Http\Controllers\StocksController');

    // Transactions
//  Route::delete('transactions/destroy', 'TransactionsController@massDestroy')->name('transactions.massDestroy');
    Route::post('transactions/{stock}/storeStock', 'App\Http\Controllers\TransactionsController@storeStock')->name('transactions.storeStock');
    Route::resource('transactions', 'App\Http\Controllers\TransactionsController')->only(['index']);

	// Clients
	Route::resource('clients', 'App\Http\Controllers\ClientController');

	//orders
	Route::resource('orders', 'App\Http\Controllers\OrderController');
	Route::post('/rating/{order}', 'App\Http\Controllers\OrderController@rateOrder')->name('rate.order');
    Route::get('/check/rating/{order}', 'App\Http\Controllers\OrderController@checkOrderRating')->name('check.rating');
	Route::get('/updatestatus/{alias}/{order}', ['as' => 'update.status', 'uses'=>'App\Http\Controllers\OrderController@updateStatus']);

	//live orders
	Route::get('live', 'App\Http\Controllers\OrderController@live');

	Route::prefix('finances')->name('finances.')->group(function () {
        Route::get('admin', 'App\Http\Controllers\FinanceController@adminFinances')->name('admin');
        Route::get('accountant', 'App\Http\Controllers\FinanceController@accountantFinances')->name('accountant');
    });

    Route::prefix('stripe')->name('stripe.')->group(function () {
        Route::get('connect', 'App\Http\Controllers\FinanceController@connect')->name('connect');
    });
// Expences
    Route::resource('expences', 'App\Http\Controllers\InvoiceController');
	