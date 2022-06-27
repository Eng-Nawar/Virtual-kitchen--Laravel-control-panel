<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $invoices = Invoice::all();
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
  
        return view('invoice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'amount' => 'required',
            'description' => 'required',
        ]);

        $invoice = new Invoice();
        $invoice->amount = $request->amount;
        $invoice->description = $request->description;
        $invoice->creator_id = auth()->user()->id;
        $invoice->save();

      

         return redirect('expences/'.$invoice->id)->with('message','invoice created Successfully');




    }

 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::where(['invoices_id'=>$id])->get()->first();

        return view('invoice.show', compact('invoice'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
   
        $invoice = Invoice::where(['invoices_id'=>$id])->get()->first();
  
        return view('invoice.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([

        'amount' => 'required',
        'description' => 'required',
    ]);

    /*$invoice = Invoice::where(['invoices_id'=>$id])->get()->first();
    $invoice->amount = $request->amount;
    $invoice->description = $request->description;
    
    $invoice->save();
    */
    Invoice::where('invoices_id', $id)
    ->update(['amount' => $request->amount, 'description'=> $request->description]);
    return redirect()->route('expences.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        Invoice::where(['invoices_id'=>$id])->delete();
        
        return redirect()->back();

    }
}
