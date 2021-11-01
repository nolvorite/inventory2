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

Route::group(['middleware' => 'client_credentials'], function(){
	Route::resources([
        'providers' => 'ProviderController',
        'inventory/products' => 'ProductController',
        'clients' => 'ClientController',
        'inventory/categories' => 'ProductCategoryController',
        'transactions/transfer' => 'TransferController',
        'methods' => 'MethodController',
        'assignments' => 'AssignmentController',
        'gifts' => 'GiftsController',
        'loans' => 'LoansController',
        'loan_payments' => 'LoanPaymentsController',
    ]);
});