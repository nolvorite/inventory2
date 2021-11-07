<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use App\Http\Requests\ProductCategoryRequest;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductCategory $model)
    {

        $categories = ProductCategory::paginate(25);

        if(request()->get('filter') !== null){
            $filter = request()->get('filter');
            switch($filter){
                case "robi":
                case "airtel":
                    $categories = ProductCategory::where('company_name',$filter)->paginate(25);
                break;
                default:
                    return redirect()
                    ->route('categories.index');
                break;
            }
        }

        

        return view('inventory.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request, ProductCategory $category)
    {

        $dataToSubmit = (array) $request->all();

        if(
            $request->name === null 
        ){
            return redirect()
            ->route('categories.create')
            ->withStatus('Some fields were left empty. Make sure all necessary fields have input.');
        }

        $dataToSubmit['product_status'] = $dataToSubmit['product_status'] === 'active' ? 'active' : 'inactive';

        $category->create($dataToSubmit);

        return redirect()
            ->route('categories.index')
            ->withStatus('Category successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $category)
    {
        return view('inventory.categories.show', [
            'category' => $category,
            'products' => Product::where('product_category_id', $category->id)->paginate(25)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $category)
    {
        return view('inventory.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, ProductCategory $category)
    {
        $category->update($request->all());

        return redirect()
            ->route('categories.index')
            ->withStatus('Category successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->withStatus('Category successfully deleted.');
    }
}
