<?php

namespace App\Http\Controllers;

use App\Client;
use App\Sale;
use App\Product;
use Carbon\Carbon;
use App\SoldProduct;
use App\Transaction;
use App\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::latest()->paginate(25);

        return view('sales.index', compact('sales'));

    }

    public function indexBuy2(Request $request)
    {

        DB::enableQueryLog();

        $request->month = $request->month !== null ? $request->month : date("m")."";
        $request->year = $request->year !== null ? $request->year : date("Y")."";

        $sales = Sale::

        where(DB::Raw('MONTH(date)'),(intval($request->month))."")->
        where(DB::Raw('YEAR(date)'),(intval($request->year))."")->
        where('client_id',auth()->id())->

        latest()->get();

        if($request->wantsJson()){
            return response()->json(compact('sales'));
        }

        return view('sales.index', compact('sales'));

    }

    public function indexBuy1(Request $request)
    {

        DB::enableQueryLog();

        $request->day = $request->day !== null ? $request->day : date("d")."";
        $request->month = $request->month !== null ? $request->month : date("m")."";
        $request->year = $request->year !== null ? $request->year : date("Y")."";

        $sales = Sale::

        where(DB::Raw('DAY(created_at)'),(intval($request->day))."")->
        where(DB::Raw('MONTH(created_at)'),(intval($request->month))."")->
        where(DB::Raw('YEAR(created_at)'),(intval($request->year))."")->
        where('client_id',auth()->id())->

        latest()->get();

        if($request->wantsJson()){
            return response()->json(compact('sales'));
        }

        return view('sales.index', compact('sales'));

    }

    public function indexD(Request $request)
    {

        DB::enableQueryLog();

        $request->day = $request->day !== null ? $request->day : date("d")."";
        $request->month = $request->month !== null ? $request->month : date("m")."";
        $request->year = $request->year !== null ? $request->year : date("Y")."";

        $sales = Sale::

        where(DB::Raw('DAY(created_at)'),(intval($request->day))."")->
        where(DB::Raw('MONTH(created_at)'),(intval($request->month))."")->
        where(DB::Raw('YEAR(created_at)'),(intval($request->year))."")->
        where('user_id',auth()->id())->

        latest()->get();

        if($request->wantsJson()){
            return response()->json(compact('sales'));
        }

        return view('sales.index', compact('sales'));

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();

        return view('sales.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sale $model)
    {

        $dataToSubmit = $request->all();
        $dataToSubmit['user_id'] = auth()->id();
        $dataToSubmit['client_id'] = $request->customerid;
        $dataToSubmit['date'] = Carbon::createFromFormat('d-M-Y',$request->date)->format('Y-m-d H:i:s');

        try {
            $sale = $model->create($dataToSubmit);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Failed to register new sale. Reason: ' . $e->getMessage()
            ]);
        }

        

        if($request->wantsJson()){

            return response()->json([
                'status' => true,
                'message' => 'Successfully created sale.'
            ]);

        }
        
        return redirect()
            ->route('sales.show', ['sale' => $sale->id])
            ->withStatus('Sale registered successfully, you can start registering products and transactions.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return view('sales.show', ['sale' => $sale]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->withStatus('The sale record has been successfully deleted.');
    }

    public function finalize(Sale $sale)
    {
        $sale->total_amount = $sale->products->sum('total_amount');

        foreach ($sale->products as $sold_product) {
            $product_name = $sold_product->product->name;
            $product_stock = $sold_product->product->stock;
            if($sold_product->qty > $product_stock) return back()->withError("The product '$product_name' does not have enough stock. Only has $product_stock units.");
        }

        foreach ($sale->products as $sold_product) {
            $sold_product->product->stock -= $sold_product->qty;
            $sold_product->product->save();
        }

        $sale->finalized_at = Carbon::now()->toDateTimeString();
        $sale->client->balance -= $sale->total_amount;
        $sale->save();
        $sale->client->save();

        return back()->withStatus('The sale has been successfully completed.');
    }

    public function addproduct(Sale $sale)
    {
        $products = Product::all();

        return view('sales.addproduct', compact('sale', 'products'));
    }

    public function storeproduct(Request $request, Sale $sale, SoldProduct $soldProduct)
    {
        $request->merge(['total_amount' => $request->get('price') * $request->get('qty')]);

        $soldProduct->create($request->all());

        return redirect()
            ->route('sales.show', ['sale' => $sale])
            ->withStatus('Product successfully registered.');
    }

    public function editproduct(Sale $sale, SoldProduct $soldproduct)
    {
        $products = Product::all();

        return view('sales.editproduct', compact('sale', 'soldproduct', 'products'));
    }

    public function updateproduct(Request $request, Sale $sale, SoldProduct $soldproduct)
    {
        $request->merge(['total_amount' => $request->get('price') * $request->get('qty')]);

        $soldproduct->update($request->all());

        return redirect()->route('sales.show', $sale)->withStatus('Product successfully modified.');
    }

    public function destroyproduct(Sale $sale, SoldProduct $soldproduct)
    {
        $soldproduct->delete();

        return back()->withStatus('The product has been disposed of successfully.');
    }

    public function addtransaction(Sale $sale)
    {
        $payment_methods = PaymentMethod::all();

        return view('sales.addtransaction', compact('sale', 'payment_methods'));
    }

    public function storetransaction(Request $request, Sale $sale, Transaction $transaction)
    {
        switch($request->all()['type']) {
            case 'income':
                $request->merge(['title' => 'Payment Received from Sale ID: ' . $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Sale Return Payment ID: ' . $request->all('sale_id')]);

                if($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1) ]);
                }
                break;
        }

        $transaction->create($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus('Successfully registered transaction.');
    }

    public function edittransaction(Sale $sale, Transaction $transaction)
    {
        $payment_methods = PaymentMethod::all();

        return view('sales.edittransaction', compact('sale', 'transaction', 'payment_methods'));
    }

    public function updatetransaction(Request $request, Sale $sale, Transaction $transaction)
    {
        switch($request->get('type')) {
            case 'income':
                $request->merge(['title' => 'Payment Received from Sale ID: '. $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Sale Return Payment ID: '. $request->get('sale_id')]);

                if($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                }
                break;
        }
        $transaction->update($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus('Successfully modified transaction.');
    }

    public function destroytransaction(Sale $sale, Transaction $transaction)
    {
        $transaction->delete();

        return back()->withStatus('Transaction deleted successfully.');
    }
}
