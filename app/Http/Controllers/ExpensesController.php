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

        $expenses = []

        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create', compact('expenses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(expenses $expenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, expenses $expenses)
    {
        //
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
