<?php

namespace App\Http\Controllers;

use App\Loan;
use App\LoanPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use Carbon\Carbon;

class LoansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::select(DB::Raw('*,(SELECT SUM(payment_amount) FROM loan_payments WHERE loan_payments.loan_id = loans.id) AS currently_paid'))->where('type', 'normal')->get();

        $loans = $loans->map(function($loan){

            $loan->assigned_date = dated($loan->assigned_date);
            $loan->loan_due_date = dated($loan->loan_due_date);

            return $loan;
        });


        return view('loans.index', compact('loans'));
    }

    public function index_d()
    {
        $loans = Loan::where(['type' => 'due'])->get();
        return view('loans.due', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('loans.create');
    }

    public function create_due()
    {
        return view('loans.new_due');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(
            $request->loaner_name === null ||
            $request->loan_amount === null ||
            $request->assigned_date === null ||
            $request->loan_due_date === null
        ){
            return redirect()
            ->route('loans.create')
            ->withStatus('Some fields were left empty. Make sure all necessary fields have input.');
        }


        

       try {

            $newId = Loan::create([
                'assigned_by_id' => auth()->id(),
                'loaner_name' => $request->loaner_name,
                'loan_amount' => $request->loan_amount,
                'assigned_date' => $request->assigned_date,
                'loan_due_date' => $request->loan_due_date,
                'type' => $request->type
            ])->id;

        }catch(\Exception $e){
            return redirect()
            ->route('loans.index')
            ->withStatus('Failed to register loan.');
        }

        return redirect()
            ->route('loans.edit', ['loan' => $newId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\loans  $loans
     * @return \Illuminate\Http\Response
     */
    public function show(loans $loans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\loans  $loans
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $loan = Loan::select(DB::Raw('loans.*,
                (SELECT SUM(payment_amount) FROM loan_payments WHERE loan_payments.loan_id = loans.id) AS amount_paid,
                loan_amount - (SELECT SUM(payment_amount) FROM loan_payments WHERE loan_payments.loan_id = loans.id) AS amount_remaining
            '))

            ->where('id',$id)->first();
        $payments = LoanPayment::fromId($id);



        $loan->assigned_date = Carbon::createFromFormat('Y-m-d H:i:s',$loan->assigned_date)->format('d M Y');
        $loan->loan_due_date = Carbon::createFromFormat('Y-m-d H:i:s',$loan->loan_due_date)->format('d M Y');

        return view('loans.edit', compact('loan', 'payments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\loans  $loans
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        try {
            Loan::

            where('id', $id)->update( [
                'loaner_name' => $request->loaner_name,
                'assigned_date' => $request->assigned_date,
                'loan_due_date' => $request->loan_due_date
            ]);
        }catch(\Exception $e){
            return redirect()
            ->route('loans.index')
            ->withStatus('Failed to modify loan details.');
        }

        return redirect()
            ->route('loans.index')
            ->withStatus('Successfully modified loan details.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\loans  $loans
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            Loan::where('id', $id)->delete();
        }catch(\Exception $e){

            return redirect()
            ->route('loans.index')
            ->withStatus('Failed to delete loan.');
        }

        return redirect()
            ->route('loans.index')
            ->withStatus('Successfully deleted loan.');
    }
}
