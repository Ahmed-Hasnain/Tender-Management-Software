<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\PaymentRecieving;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentRecievingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit_item')->only('edit','update');
        $this->middleware('can:add_item')->only('create', 'store');
        $this->middleware('can:delete_item')->only('destroy'); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $limit = \config()->get('settings.pagination_limit');
            $paymentRecieving = PaymentRecieving::where(function ($query) {
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('cheque_no', 'like', '%' . $keyword . '%')
                    ->orWhere('bank_name', 'like', '%' . $keyword . '%')
                    ->orWhere('cheque_amount', 'like', '%' . $keyword . '%')
                    ->orWhere('income_tax_amount', 'like', '%' . $keyword . '%')
                    ->orWhere('gst_withhold_amount', 'like', '%' . $keyword . '%')
                    ->orWhere('serial_no', 'like', '%' . $keyword . '%')
                    ->orWhereHas('supplyOrder', function($query) use ($keyword){
                        // $query->where('quotation_id', 'like', '%' . $keyword . '%');
                    });
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('PaymentRecieving/Index', [
                'paymentRecieving' => $paymentRecieving,
                'searchedKeyword' => request()->input('keyword'),
            ]);
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this Payment recieving.', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
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
