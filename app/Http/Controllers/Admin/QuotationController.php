<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Tender;
use App\Models\Quotation;
use App\Models\TenderItem;
use Illuminate\Http\Request;
use App\Models\QuotationItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuotationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit_quotation')->only('edit','update');
        $this->middleware('can:add_quotation')->only('create', 'store');
        $this->middleware('can:delete_quotation')->only('destroy');
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
            $quotations = Quotation::with('tender')->where(function ($query) {
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('reference_no', 'like', '%' . $keyword . '%')
                    ->orWhere('total_price', 'like', '%' . $keyword . '%')
                    ->orWhereHas('tender', function($query) use ($keyword){
                        $query->where('reference_no', 'like', '%' . $keyword . '%');
                    });
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('Quotation/Index', [
                'quotations' => $quotations,
                'searchedKeyword' => request()->input('keyword'),
            ]);
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
        return Inertia::render('Quotation/Create', [
            'tender_items' => Tender::find(request()->input('tender_id'))->items()->with('item', 'unit')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $quotation = Quotation::create([
                'reference_no' => $request->input('reference_no'),
                'currency' => $request->input('currency'),
                'terms_and_conditions' => $request->input('terms_and_conditions'),
                'tender_id' => $request->input('tender_id'),
            ]);
            $quotationItems = $request->input('items');
            if (count($quotationItems) > 0) {
                foreach ($quotationItems as $key => $quotationItem) {
                    $quotation->items()->create([
                        'tender_item_id' => $quotationItem['tender_item_id'],
                        'unit_price' => $quotationItem['unit_price'],
                    ]);
                }
            }
            DB::commit();
            flash('Quotation Added Sucessfully!', 'success');
            return \redirect(route('dashboard.quotation.index'));          
        }catch (\Exception $e) {
            DB::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        return Inertia::render('Quotation/Show', [
            'quotation' => $quotation->load('tender.client', 'items.tenderItem.item', 'items.tenderItem.unit'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation)
    {
        return Inertia::render('Quotation/Edit', [
            'quotation' => $quotation,
            'quotation_items' => $quotation->items()->with(['tenderItem' => function ($query) {
                $query->with('item', 'unit');
            }])->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quotation $quotation)
    {
        try{
            DB::beginTransaction();
            $quotation->update([
                'reference_no' => $request->input('reference_no'),
                'currency' => $request->input('currency'),
                'terms_and_conditions' => $request->input('terms_and_conditions'),
            ]);
            $quotationItems = $request->input('items');
            if (count($quotationItems) > 0) {
                foreach ($quotationItems as $key => $quotationItem) {
                    QuotationItem::find($quotationItem['id'])->update([
                        'unit_price' => $quotationItem['unit_price'],
                    ]);
                }
            }
            DB::commit();
            flash('Quotation Added Sucessfully!', 'success');
            return \redirect(route('dashboard.tender.index'));          
        }catch (\Exception $e) {
            DB::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        try {           
            $quotation->delete();
            flash('Quotation deleted succesfully', 'success');
            return \redirect()->back();
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this quotation', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }
}
