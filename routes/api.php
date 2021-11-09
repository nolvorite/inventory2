<?php

use Illuminate\Http\Request;
use Laravel\Passport\Passport;

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

Passport::routes(null, ['middleware' => 'api']);

Route::group(['middleware' => ['client_credentials', 'auth:api']], function(){

    Route::get('profile', ['uses' => 'ProfileController@edit']);

    Route::get('myComplains', [ 'uses' => 'ComplaintsController@index']);

    Route::get('customerList', [ 'uses' => 'UserManagement\UsersController@index_c']);

    Route::post('addComplain', [ 'uses' => 'ComplaintsController@store']);

    Route::group(['middleware' => 'role:employee'], function(){

        Route::get('/addSale', 'UsersController@show');
        Route::get('/returnProduct', 'ProductController@index');

    });

    Route::group(['middleware' => 'role:admin'], function(){

        Route::group(['namespace' => '\App\Http\Controllers\UserManagement'], function(){

            Route::get('/employeeProfile/{id}', 'UsersController@show');
            Route::get('/customerProfile/{id}', 'UsersController@show');


        });

        Route::resources(['assignments' => 'AssignmentController']);

        Route::group(['prefix' => 'inside_resource'], function(){
            Route::resources([
                'providers' => 'ProviderController',
                'inventory/products' => 'ProductController',
                'clients' => 'ClientController',
                'inventory/categories' => 'ProductCategoryController',
                'transactions/transfer' => 'TransferController',
                'methods' => 'MethodController',
                'gifts' => 'GiftsController',
                'loans' => 'LoansController',
                'loan_payments' => 'LoanPaymentsController',
            ]);
        });

        

    });

	
});