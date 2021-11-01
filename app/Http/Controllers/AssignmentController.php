<?php

namespace App\Http\Controllers;

use App\Assignment;
use Illuminate\Http\Request;
use App\Product;
use App\ProductCategory;
use App\Entities\User;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\AssignmentRequest;
use App\Http\Requests\AssignmentRequestU;


use Carbon\Carbon;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $assignments = Assignment::fullDataScope()->get();

        if(request()->wantsJson()){

            $assignments->map(function($assignment){

                foreach(['stock_defective', 'assigned_by_id','email','product_label','assigned_to_id','created_at','deleted_at','updated_at'] as $cols){
                    unset($assignment->{$cols});
                }

                return $assignment;

            });


            return json_encode(compact('assignments'));
        }
        
        return view('assignments.index', compact('assignments'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $products = Product::catJoin()->orderBy('products.created_at')->paginate(100);

        $products = $products->map(function($product){

            $product->buying_date = Carbon::createFromFormat('Y-m-d H:i:s',$product->buying_date)->format('d M Y');

            return $product;

        });

        $assignees = User::withDept();

        return view('assignments.create', compact('products', 'assignees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssignmentRequest $request)
    {

        $dataToSubmit = $request->all();
        $dataToSubmit['assigned_by_id'] = \Auth::id();
        $dataToSubmit['return_status'] = 'approved';
        
        try {
            Assignment::create($dataToSubmit);
        }catch(\Exception $e){
            return redirect()
            ->route('assignments.index')
            ->withStatus('Failed to register assignment.');
        }

        return redirect()
            ->route('assignments.index')
            ->withStatus('Successfully registered assignment!');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
        // $assignmentData = Assignment::fullDataScope()->where('assignments.id',$id)->first();
        // $products = Product::catJoin()->orderBy('products.created_at')->paginate(100);

        // $assignees = User::withDept();

        // if($assignmentData === null){
        //     return redirect()->route('assignments.index');
        // }

        // return view('assignments.show', $assignmentData);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit($assignment_id)
    {
        
        $assignment = Assignment::fullDataScope()->where('assignments.id',$assignment_id)->first();
        $products = Product::catJoin()->orderBy('products.created_at')->paginate(100)->all();
        $assignees = User::withDept();

        if($assignment === null){
            return redirect()->route('assignments.index');
        }

        return view('assignments.edit', compact('assignment', 'products', 'assignees'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update($id, AssignmentRequestU $request)
    {
        $dataToSubmit = $request->all();

        unset($dataToSubmit['_method'],$dataToSubmit['_token'],$dataToSubmit['id']);
        
        try {
            Assignment::where('id', $id)->update($dataToSubmit);
        }catch(\Exception $e){
            return redirect()
            ->route('assignments.index')
            ->withStatus('Failed to edit assignment.');
        }

        return redirect()
            ->route('assignments.index')
            ->withStatus('Successfully modified assignment.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Assignment $assignment)
    {
        try {
            Assignment::where('id', $id)->delete();
        }catch(\Exception $e){

            return redirect()
            ->route('assignments.index')
            ->withStatus('Failed to delete assignment.');
        }

        return redirect()
            ->route('assignments.index')
            ->withStatus('Successfully deleted assignment.');
    }
}
