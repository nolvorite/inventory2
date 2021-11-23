<?php

namespace App\Http\Controllers;
use App\Sale;
use Carbon\Carbon;
use App\SoldProduct;
use App\Transaction;
use App\PaymentMethod;
use App\Loan;
use App\Assignment;
use App\Product;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {

        $monthlyBalanceByMethod = $this->getMethodBalance()->get('monthlyBalanceByMethod');
        $monthlyBalance = $this->getMethodBalance()->get('monthlyBalance');

        $anualsales = $this->getAnnualSales();
        $anualclients = $this->getAnnualClients();
        $anualproducts = $this->getAnnualProducts();

        $totalassigned = @DB::select(DB::Raw('SELECT COUNT(products.id) AS total_assigned FROM assignments INNER JOIN products ON assignments.product_id = products.id WHERE assignments.return_status != \'sold\' GROUP BY product_id'))[0]->total_assigned;
        
        return view('dashboard', [

            'totalloans' => $this->getTotalLoans(),

            'totaldues' => $this->getTotalDues(),

            'totalsoldthismonth' => $this->getTotalSoldThisMonth(),

            'totalproducts' => $this->totalProductData(),

            'totalassigned' => $totalassigned,

            'monthlybalance'            => $monthlyBalance,
            'monthlybalancebymethod'    => $monthlyBalanceByMethod,
            'lasttransactions'          => Transaction::latest()->limit(20)->get(),
            'unfinishedsales'           => Sale::where('finalized_at', null)->get(),
            'anualsales'                => $anualsales,
            'anualclients'              => $anualclients,
            'anualproducts'             => $anualproducts,
            'lastmonths'                => array_reverse($this->getMonthlyTransactions()->get('lastmonths')),
            'lastincomes'               => $this->getMonthlyTransactions()->get('lastincomes'),
            'lastexpenses'              => $this->getMonthlyTransactions()->get('lastexpenses'),
            'semesterexpenses'          => $this->getMonthlyTransactions()->get('semesterexpenses'),
            'semesterincomes'           => $this->getMonthlyTransactions()->get('semesterincomes')
        ]);
    }

    public function no_access(){
        return view('no_access');
    }

    public function totalProductData(){
        $product = Product::select(DB::Raw('SUM(stock) as stock, SUM(price) as price'))->first();

        return $product;
    }

    public function register_fcm(Request $request){


        try {

            DB::table('fcm_tokens')->insert([
            'userid' => auth()->id(),
            'token' => $request->token
            ]);


        }catch(\Exception $e){

            return response()->json(['status' => false, 'message' => 'Failed to register new token.']);

        }

        return response()->json(['status' => true, 'message' => 'Successfully registered new token.']);

    }

    public function getTotalLoans(){
       $loan = Loan::select(DB::Raw('SUM(loan_amount) as total'))->where('type','normal')

            ->first();
        return $loan['total'];
    }

    public function getTotalSoldThisMonth(){

        DB::enableQueryLog();

        //$assignment = ['total' => 0];

        $assignment = Assignment::select(DB::Raw('SUM(seller_price*quantity_sold) as total'))
            ->whereRaw('

                created_at >= (LAST_DAY(NOW()) + INTERVAL 1 DAY - INTERVAL 1 MONTH)
                AND created_at < (LAST_DAY(NOW()) + INTERVAL 1 DAY)

            ')
            ->first();

        return $assignment['total'];
    }

    public function getTotalDues(){
        $loan = Loan::select(DB::Raw('SUM(loan_amount) as total'))
 
        ->first();

        return $loan['total'];

    }

    public function getMethodBalance()
    {
        $methods = PaymentMethod::all();
        $monthlyBalanceByMethod = [];
        $monthlyBalance = 0;

        foreach ($methods as $method) {
            $balance = Transaction::findByPaymentMethodId($method->id)->thisMonth()->sum('amount');
            $monthlyBalance += (float) $balance;
            $monthlyBalanceByMethod[$method->name] = $balance;
        }
        return collect(compact('monthlyBalanceByMethod', 'monthlyBalance'));
    }

    public function getAnnualSales()
    {
        $sales = [];
        foreach(range(1, 12) as $i) {
            $monthlySalesCount = Sale::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $i)->count();

            array_push($sales, $monthlySalesCount);
        }
        return "[" . implode(',', $sales) . "]";
    }

    public function getAnnualClients()
    {
        $clients = [];
        foreach(range(1, 12) as $i) {
            $monthclients = Sale::selectRaw('count(distinct client_id) as total')
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', $i)
                ->first();

            array_push($clients, $monthclients->total);
        }
        return "[" . implode(',', $clients) . "]";
    }

    public function getAnnualProducts()
    {
        $products = [];
        foreach(range(1, 12) as $i) { 
            $monthproducts = SoldProduct::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $i)->sum('qty');

            array_push($products, $monthproducts);
        }        
        return "[" . implode(',', $products) . "]";
    }

    public function getMonthlyTransactions()
    {
        $actualmonth = Carbon::now();

        $lastmonths = [];
        $lastincomes = '';
        $lastexpenses = '';
        $semesterincomes = 0;
        $semesterexpenses = 0;

        foreach (range(1, 6) as $i) {
            array_push($lastmonths, $actualmonth->shortMonthName);

            $incomes = Transaction::where('type', 'income')
                ->whereYear('created_at', $actualmonth->year)
                ->WhereMonth('created_at', $actualmonth->month)
                ->sum('amount');

            $semesterincomes += $incomes;
            $lastincomes = round($incomes).','.$lastincomes;

            $expenses = abs(Transaction::whereIn('type', ['expense', 'payment'])
                ->whereYear('created_at', $actualmonth->year)
                ->WhereMonth('created_at', $actualmonth->month)
                ->sum('amount'));

            $semesterexpenses += $expenses;
            $lastexpenses = round($expenses).','.$lastexpenses;

            $actualmonth->subMonth(1);
        }

        $lastincomes = '['.$lastincomes.']';
        $lastexpenses = '['.$lastexpenses.']';

        return collect(compact('lastmonths', 'lastincomes', 'lastexpenses', 'semesterincomes', 'semesterexpenses'));
    }
}
