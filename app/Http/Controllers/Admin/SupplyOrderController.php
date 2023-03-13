<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Quotation;
use App\Models\SupplyOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplyOrderRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        try{
            $limit = \config()->get('settings.pagination_limit');
            $supplyOrder = SupplyOrder::with('quotation.tender', 'items')->where(function ($query) {
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->WhereHas('quotation', function($query) use ($keyword){
                        $query->where('reference_no', 'like', '%' . $keyword . '%')
                        ->orWhereHas('tender', function ($query) use ($keyword) {
                            $query->where('reference_no', 'like', '%' . $keyword . '%');
                        });
                    });
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('SupplyOrder/Index', [
                'supplyOrder' => $supplyOrder,
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
        return Inertia::render('SupplyOrder/Create' , [
            'quotation_items' => Quotation::find(request()->input('quotation_id'))->items()->with('quotation' , 'tenderItem.item', 'tenderItem.unit')->get(),
            'quotation_id' => request()->input('quotation_id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplyOrderRequest $request)
    {
        try{
            DB::beginTransaction();
            $supplyOrder = SupplyOrder::create([
                'date_of_supply_order' => $request->input('date_of_supply_order'),
                'delivery_date' => $request->input('delivery_date'),
                'quotation_id' => $request->input('quotation_id'),
            ]);
            $supplyOrderItems = $request->input('items');
            if (count($supplyOrderItems) > 0) {
                foreach ($supplyOrderItems as $key => $supplyOrderItem) {
                    if ($supplyOrderItem['status']) {
                        $supplyOrder->items()->create([
                            'quotation_item_id' => $supplyOrderItem['quotation_item_id'],
                            'unit_price' => $supplyOrderItem['unit_price'],
                            'qty' => $supplyOrderItem['qty'],
                            'qty_left' => $supplyOrderItem['qty'],
                        ]);
                    }
                }
            }
            DB::commit();
            flash('Supply Order Added Sucessfully!', 'success');
            return \redirect(route('dashboard.supply-order.index'));          
        }catch (\Exception $e) {
            DB::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplyOrder  $supplyOrder
     * @return \Illuminate\Http\Response
     */
    public function show(SupplyOrder $supplyOrder)
    {
        return Inertia::render('SupplyOrder/Show', [
            'supplyOrder' => $supplyOrder->load('items.quotationItem.tenderItem.item', 'items.quotationItem.tenderItem.unit', 'quotation.tender.items.item', 'quotation.tender.items.unit'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplyOrder  $supplyOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplyOrder $supplyOrder)
    {
        return Inertia::render('SupplyOrder/Edit', [
            'supplyOrder' => $supplyOrder->load('items.quotationItem.tenderItem.item', 'items.quotationItem.tenderItem.unit', 'quotation.tender.items.item', 'quotation.tender.items.unit'),
            'quotation_items' => Quotation::find($supplyOrder->quotation_id)->items()->with('quotation' , 'tenderItem.item', 'tenderItem.unit')->get(),
        ]);
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
        try{
            DB::beginTransaction();
            $supplyOrder->update([
                'date_of_supply_order' => $request->input('date_of_supply_order'),
                'delivery_date' => $request->input('delivery_date'),
            ]);
            if ($supplyOrder->items()->count() > 0) {
                $supplyOrder->items()->delete();
            }
            $supplyOrderItems = $request->input('items');
            if (count($supplyOrderItems) > 0) {
                foreach ($supplyOrderItems as $key => $supplyOrderItem) {
                    if ($supplyOrderItem['status']) {
                        $supplyOrder->items()->create([
                            'quotation_item_id' => $supplyOrderItem['quotation_item_id'],
                            'unit_price' => $supplyOrderItem['unit_price'],
                            'qty' => $supplyOrderItem['qty'],
                            'qty_left' => $supplyOrderItem['qty'],
                        ]);
                    }
                }
            }
            DB::commit();
            flash('Supply Order Edited Sucessfully!', 'success');
            return \redirect(route('dashboard.supply-order.index'));          
        }catch (\Exception $e) {
            DB::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplyOrder  $supplyOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplyOrder $supplyOrder)
    {
        try {           
            $supplyOrder->delete();
            flash('Supply Order deleted succesfully', 'success');
            return \redirect()->back();
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this supply order', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }
}
