<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $expenses = Expense::get();

        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create');
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

            $newId = Expense::create([
                'expense_type' => $request->expense_type,
                'expense_amount' => $request->expense_amount,
                'date_paid' => $request->date_paid,
                'assigned_by_id' => auth()->id()
            ])->id;

        }catch(\Exception $e){

            return redirect()
            ->route('expenses.index')
            ->withStatus('Failed to register expense.');
        }

        return redirect()
            ->route('expenses.index', ['loan' => $newId])->withStatus('Successfully registered expense.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function show(expenses $expenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $expense = Expense::findOrFail($id)->first();
        return view('expenses.edit', compact('expense'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        try {
            Expense::

            where('id', $id)->update( [
                'expense_type' => $request->expense_type,
                'expense_amount' => $request->expense_amount,
                'date_paid' => $request->date_paid
            ]);

        }catch(\Exception $e){
            return redirect()
            ->route('expenses.index')
            ->withStatus('Failed to modify expense details.');
        }

        return redirect()
            ->route('expenses.index')
            ->withStatus('Successfully modified expense details.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function destroy(expenses $expenses)
    {
        try {
            Expense::where('id', $id)->delete();
        }catch(\Exception $e){

            return redirect()
            ->route('expenses.index')
            ->withStatus('Failed to delete expense.');
        }

        return redirect()
            ->route('loans.index')
            ->withStatus('Successfully deleted expense.');
    }
}
