<?php

namespace App\Http\Controllers;

use App\LoanPayment;
use Illuminate\Http\Request;

class LoanPaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

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

            LoanPayment::create([
                'loan_id' => $request->loan_id,
                'payment_amount' => $request->payment_amount,
                'payment_date' => $request->payment_date
            ]);

        }catch(\Exception $e){
            return redirect()
            ->route('loans.edit',['loan' => $request->loan_id])
            ->withStatus('Failed to add loan payment.');
        }

        return redirect()
            ->route('loans.edit',['loan' => $request->loan_id])
            ->withStatus('Successfully added loan payment record!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LoanPayment  $loanPayment
     * @return \Illuminate\Http\Response
     */
    public function show(LoanPayment $loanPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LoanPayment  $loanPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanPayment $loanPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LoanPayment  $loanPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanPayment $loanPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LoanPayment  $loanPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {

        $loanId = LoanPayment::where('id',$id)->first()->loan_id;

        

        LoanPayment::where('id',$id)->delete();
        return redirect()
            ->route('loans.edit',['loan' => $loanId])
            ->withStatus('Deleted payment.');
    }
}
