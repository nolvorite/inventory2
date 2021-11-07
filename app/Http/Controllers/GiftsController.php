<?php

namespace App\Http\Controllers;

use App\Gift;
use Illuminate\Http\Request;

use App\Assignment;
use App\Product;
use App\ProductCategory;
use App\Entities\User;
use Illuminate\Support\Facades\DB;

class GiftsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gifts = Gift::fullDataScope()->orderByDesc('gifts.created_at')->get();

        

        if(request()->wantsJson()){
            return json_encode(compact('gifts'));
        }

        return view('gifts.index', compact('gifts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $customers = User::withCustomers();

        $employees = User::withDept();

        $employees = $employees->map(function($employee){

            $employee->optionAttr .= 'company_desc="('. $employee->employee_type .')"';

            return $employee;

        });

        $customers = $customers->map(function($customer){

            $customer->customer_name = $customer->first_name .  " " . $customer->last_name;

            return $customer;
        });

        return view('gifts.create', compact('customers', 'employees'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        try {
            Gift::create([
                'employee_id' => auth()->id(),
                'customer_id' => $request->customer_id,
                'gift_label' => $request->gift_label,
                'delivery_date' => $request->delivery_date,
                'assigned_to_id' => $request->assigned_to_id
            ]);
        }catch(\Exception $e){
            return redirect()
            ->route('gifts.index')
            ->withStatus('Failed to register gift.');
        }

        return redirect()
            ->route('gifts.index')
            ->withStatus('Successfully registered gift!');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\gifts  $gifts
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $customers = User::withCustomers();

        $gift = Gift::select(DB::Raw('gifts.*,users.name AS employee_name'))->leftJoin('users', 'employee_id', '=', 'users.id')->where('gifts.id',$id)->first();

        $customers = $customers->map(function($customer){

            $customer->customer_name = $customer->first_name .  " " . $customer->last_name;

            return $customer;
        });

        return view('gifts.edit', compact('customers', 'gift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\gifts  $gifts
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {

        try {
            Gift::where('id', $id)->update( [
                'gift_label' => $request->gift_label,
                'delivery_date' => $request->delivery_date,
                'status' => $request->status
            ]);
        }catch(\Exception $e){
            return redirect()
            ->route('gifts.index')
            ->withStatus('Failed to modify gift details.');
        }

        return redirect()
            ->route('gifts.index')
            ->withStatus('Successfully modified gift details.');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\gifts  $gifts
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        Gift::findOrFail($id)->delete();

        return redirect()
            ->route('gifts.index')
            ->withStatus('Successfully deleted gift data.');

    }
}
