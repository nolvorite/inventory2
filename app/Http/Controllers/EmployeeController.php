<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Receipt;
use App\Provider;
use App\Product;

use Carbon\Carbon;
use App\ReceivedProduct;

class EmployeeController extends Controller
{
    public function index(Request $request){
        return view('employees/index');
    }
    public function assign(Request $request){
        return view('employees/assign');
    }
}
