<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\PaymentRecieving;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRecievingRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentRecievingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit_payment_recieving')->only('edit','update');
        $this->middleware('can:add_payment_recieving')->only('create', 'store');
        $this->middleware('can:delete_payment_recieving')->only('destroy'); 
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
            $paymentRecieving = PaymentRecieving::with('supplyOrder.quotation.tender.company')->where(function ($query) {
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('cheque_no', 'like', '%' . $keyword . '%')
                    ->orWhere('bank_name', 'like', '%' . lowerCaseAndAddDashes($keyword) . '%')
                    ->orWhere('cheque_amount', 'like', '%' . $keyword . '%')
                    ->orWhere('income_tax_amount', 'like', '%' . $keyword . '%')
                    ->orWhere('gst_withhold_amount', 'like', '%' . $keyword . '%')
                    ->orWhere('serial_no', 'like', '%' . $keyword . '%')
                    ->orWhereHas('supplyOrder', function($query) use ($keyword){
                        $query->whereHas('quotation', function ($query) use ($keyword){
                            $query->where('reference_no', 'like', '%' . $keyword . '%')
                            ->orWhereHas('tender', function ($query) use ($keyword){
                                $query->whereHas('company', function ($query) use ($keyword){
                                    $query->where('name', 'like', '%' . $keyword . '%');
                                });
                            });
                        });
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
        return Inertia::render('PaymentRecieving/Create', [
            'supplyOrderId' => request()->input('supplyOrder') ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRecievingRequest $request)
    {
        try{
            DB::beginTransaction();
            $payment = PaymentRecieving::create($request->all());
            DB::commit();
            flash('Payment Recieving Added Sucessfully!', 'success');
            return \redirect(route('dashboard.payment-recieving.index'));          
        }catch (\Exception $e) {
            DB::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentRecieving  $paymentRecieving
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentRecieving $paymentRecieving)
    {
        return Inertia::render('PaymentRecieving/Show', [
            'paymentRecieving' => $paymentRecieving->load('supplyOrder.quotation.tender.company', 'supplyOrder.quotation.tender.client'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentRecieving  $paymentRecieving
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentRecieving $paymentRecieving)
    {
        return Inertia::render('PaymentRecieving/Edit', [
            'paymentRecieving' => $paymentRecieving,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentRecieving  $paymentRecieving
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentRecievingRequest $request, PaymentRecieving $paymentRecieving)
    {
        try{
            DB::beginTransaction();
            $paymentRecieving->update($request->all());
            DB::commit();
            flash('Payment Recieving Updated Sucessfully!', 'success');
            return \redirect(route('dashboard.payment-recieving.index'));          
        }catch (\Exception $e) {
            DB::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentRecieving  $paymentRecieving
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentRecieving $paymentRecieving)
    {
        try {           
            $paymentRecieving->delete();
            flash('Payment Recieving deleted succesfully', 'success');
            return \redirect()->back();
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this payment recieving', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }
}
