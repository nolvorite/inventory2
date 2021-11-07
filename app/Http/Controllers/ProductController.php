<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Carbon\Carbon;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->categories = ProductCategory::select(DB::Raw('*, CONCAT("", name,"") AS name '))->where('product_status','active');
    }

    public function switch_status(){
        $product = ProductCategory::findOrFail(request()->category_id);

        $currentStatus = $product->product_status;

        $newStatus = $currentStatus === 'active' ? 'inactive' : 'active';

        $product->update(['product_status' => $newStatus]);

        return redirect()->route('categories.index');
    }

    public function index(Request $request)
    {

        $products = new Product;

        $products = $products->catJoin();

        if(request()->get('filter') !== null){
            $filter = request()->get('filter');
            switch($filter){
                case "robi":
                case "airtel":
                    $products = Product::catJoin()->where('products.company_name',$filter);
                break;
                default:
                    return redirect()
                    ->route('products.index');
                break;
            }
        }

        

        if(request()->get('category_id') !== null){
            $categoryId = request()->get('category_id');
            $products = $products->where('product_category_id',$categoryId);
        }

        $products = $products->orderBy(DB::Raw('product_categories.name'))->paginate(25);

        $products = $products->map(function($product){

            $product->buying_date = Carbon::createFromFormat('Y-m-d H:i:s',$product->buying_date)->format('d-M-Y');

            return $product;

        });

        if($request->wantsJson()){
            return response()->json(compact('products'));
        }

        return view('inventory.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categories->get();

        return view('inventory.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ProductRequest  $request
     * @param  App\Product  $model
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $model)
    {

        $dataToSubmit = (array) $request->all();

        if(
            $request->name === null 
        ){
            return redirect()
            ->route('categories.create')
            ->withStatus('Some fields were left empty. Make sure all necessary fields have input.');
        }

        $dataToSubmit['company_name'] = $dataToSubmit['company_name'] === 'robi' ? 'robi' : 'airtel';

        $model->create($dataToSubmit);

        return redirect()
            ->route('products.index')
            ->withStatus('Product successfully registered.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = $this->categories->get();

        $product->buying_date = Carbon::createFromFormat('Y-m-d H:i:s',$product->buying_date)->format('d M Y');

        $product->buying_price = number_format($product->buying_price,2);

        $product->selling_price = number_format($product->selling_price,2);

        return view('inventory.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $dataToSubmit = (array) $request->all();

        $dataToSubmit['company_name'] = $dataToSubmit['company_name'] === 'robi' ? 'robi' : 'airtel';

        $product->update($dataToSubmit);

        return redirect()
            ->route('products.index')
            ->withStatus('Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->withStatus('Product removed successfully.');
    }
}
