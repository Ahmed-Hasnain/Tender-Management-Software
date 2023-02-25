<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\SupplyOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplyOrderRequest;

class SupplyOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit_supply_order')->only('edit','update');
        $this->middleware('can:add_supply_order')->only('create', 'store');
        $this->middleware('can:delete_supply_order')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'hi';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('SupplyOrder/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplyOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplyOrder  $supplyOrder
     * @return \Illuminate\Http\Response
     */
    public function show(SupplyOrder $supplyOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplyOrder  $supplyOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplyOrder $supplyOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplyOrder  $supplyOrder
     * @return \Illuminate\Http\Response
     */
    public function update(SupplyOrderRequest $request, SupplyOrder $supplyOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplyOrder  $supplyOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplyOrder $supplyOrder)
    {
        //
    }
}
