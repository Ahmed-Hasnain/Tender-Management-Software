<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\ModeOfPayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModeOfPaymentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModeOfPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit_mode_of_payment')->only('edit','update');
        $this->middleware('can:add_mode_of_payment')->only('create', 'store');
        $this->middleware('can:delete_mode_of_payment')->only('destroy');
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
            $modeOfPayments = ModeOfPayment::where(function ($query) {
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('name', 'like', '%' . $keyword . '%');
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('ModeOfPayment/Index', [
                'mode_of_payments' => $modeOfPayments,
                'searchedKeyword' => request()->input('keyword'),
            ]);
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this mode of payment.', 'danger');
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
        return Inertia::render('ModeOfPayment/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModeOfPaymentRequest $request)
    {
        try{
            DB::beginTransaction();
            $mop = ModeOfPayment::create($request->all());
            DB::commit();
            flash('Mode of Payment Added Sucessfully!', 'success');
            return \redirect(route('dashboard.mode-of-payment.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModeOfPayment  $modeOfPayment
     * @return \Illuminate\Http\Response
     */
    public function show(ModeOfPayment $modeOfPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModeOfPayment  $modeOfPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(ModeOfPayment $modeOfPayment)
    {
        return Inertia::render('ModeOfPayment/Edit', [
            'mode_of_payment' => $modeOfPayment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModeOfPayment  $modeOfPayment
     * @return \Illuminate\Http\Response
     */
    public function update(ModeOfPaymentRequest $request, ModeOfPayment $modeOfPayment)
    {
        try{
            DB::beginTransaction();
            $modeOfPayment->update($request->all());
            DB::commit();
            flash('Mode of Payment Updated Sucessfully!', 'success');
            return \redirect(route('dashboard.mode-of-payment.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModeOfPayment  $modeOfPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModeOfPayment $modeOfPayment)
    {
        try {           
            $modeOfPayment->delete();
            flash('Mode of Payment deleted succesfully', 'success');
            return \redirect()->back();
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this Mode Of Payment', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }
}
