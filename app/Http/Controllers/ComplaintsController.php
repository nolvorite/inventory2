<?php

namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Http\Request;

class ComplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $complaints = Complaint::where('user_id',\Auth::id())->get();

        if($request->wantsJson()){
            return response()->json(compact('complaints'));
        }

        return view('complaints.index',compact('complaints'));

    }

    public function complaints_all(int $id){

        $complaints = Complaint::where('user_id', $id)->get();

        return response()->json(compact('complaints'));        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('complaints.create');
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

            $newComplaint = Complaint::create([
                'user_id' => \Auth::id(),
                'complaint' => $request->complaint
            ])->id;

        }catch(\Exception $e){

            if($request->wantsJSON()){
                return response()->json(['status' => false, 'message' => 'Failed to send request']);
            }

            return redirect()
            ->route('complaints.index')
            ->withStatus('Failed to register complaint.');
            
        }

        if($request->wantsJSON()){
            return response()->json([
                'status' => true, 
                'message' => 'Successfully sent complaint!'
            ]);
        }

        return redirect()
            ->route('complaints.index')->withStatus('Successfully registered complaint.');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function show(Complaint $complaint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $complaint = Complaint::where('id',$id)->first();
        return view('complaints.edit', compact('complaint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Complaint $complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Complaint  $complaint
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            Complaint::where('id', $id)->delete();
        }catch(\Exception $e){

            return redirect()
            ->route('complaints.index')
            ->withStatus('Failed to delete complaint.');
        }

        return redirect()
            ->route('complaints.index')
            ->withStatus('Successfully deleted complaint.');
    }
}
