<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PaymentRecieving;
use App\Http\Controllers\Controller;

class PaymentRecievingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "hello payment recieving";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\PaymentRecieving  $paymentRecieving
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentRecieving $paymentRecieving)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentRecieving  $paymentRecieving
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentRecieving $paymentRecieving)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentRecieving  $paymentRecieving
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentRecieving $paymentRecieving)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentRecieving  $paymentRecieving
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentRecieving $paymentRecieving)
    {
        //
    }
}
