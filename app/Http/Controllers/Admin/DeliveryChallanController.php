<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Quotation;
use App\Models\SupplyOrder;
use Illuminate\Http\Request;
use App\Models\DeliveryChallan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryChallanRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeliveryChallanController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit_delivery_challan')->only('edit','update');
        $this->middleware('can:add_delivery_challan')->only('create','store');
        $this->middleware('can:delete_delivery_challan')->only('destroy');
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
            $deliveryChallan = DeliveryChallan::with('supplyOrder.quotation.tender')->where(function ($query) {
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('reference_no', 'like', '%' . $keyword . '%')
                    ->orWhereHas('supplyOrder', function($query) use ($keyword){
                        $query->whereHas('quotation', function ($query) use ($keyword) {
                            $query->where('reference_no', 'like', '%' . $keyword . '%')
                            ->orWhereHas('tender', function ($query) use ($keyword) {
                                $query->where('reference_no', 'like', '%' . $keyword . '%');
                            });
                        });
                    });
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('DeliveryChallan/Index', [
                'deliveryChallan' => $deliveryChallan,
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
        // dd(SupplyOrder::with('deliveryChallanItems.deliveryChallan')->find(request()->input('supply_order_id')));
        return Inertia::render('DeliveryChallan/Create' , [
            'supply_order_items' => SupplyOrder::find(request()->input('supply_order_id'))->items()->with('quotationItem.tenderItem.item', 'quotationItem.tenderItem.unit')->get(),
            'supply_order_id' => request()->input('supply_order_id'),
            'delivery_challan_items' => SupplyOrder::find(request()->input('supply_order_id'))->deliveryChallanItems()->with('deliveryChallan', 'supplyOrderItem.quotationItem.tenderItem.item', 'supplyOrderItem.quotationItem.tenderItem.unit')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryChallanRequest $request)
    {
        try{
            // dd($request->all());
            DB::beginTransaction();
            $deliveryChallan = DeliveryChallan::create([
                'supply_order_id' => $request->input('supply_order_id'),
                'description' => $request->input('description'),
                'delivered' => $request->input('delivered'),
            ]);
            $deliveryChallanItems = $request->input('items');
            if (count($deliveryChallanItems) > 0) {
                foreach ($deliveryChallanItems as $key => $deliveryChallanItem) {
                    if ($deliveryChallanItem['status']) {
                        $deliveryChallan->items()->create([
                            'supply_order_item_id' => $deliveryChallanItem['supply_order_item_id'],
                            'unit_price' => $deliveryChallanItem['unit_price'],
                            'qty' => $deliveryChallanItem['qty'],
                        ]);
                    }
                }
            }
            DB::commit();
            flash('Delivery Challan Added Sucessfully!', 'success');
            return \redirect(route('dashboard.delivery-challan.index'));          
        }catch (\Exception $e) {
            DB::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryChallan  $deliveryChallan
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryChallan $deliveryChallan)
    {
        return Inertia::render('DeliveryChallan/Show', [
            'deliveryChallan' => $deliveryChallan->load('items.supplyOrderItem.quotationItem.tenderItem.item', 'items.supplyOrderItem.quotationItem.tenderItem.unit', 'supplyOrder'),
            'supplyOrder' => $deliveryChallan->supplyOrder->load('items.quotationItem.tenderItem.item', 'items.quotationItem.tenderItem.unit', 'quotation.tender.items.item', 'quotation.tender.items.unit'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryChallan  $deliveryChallan
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryChallan $deliveryChallan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryChallan  $deliveryChallan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryChallan $deliveryChallan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryChallan  $deliveryChallan
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryChallan $deliveryChallan)
    {
        try {           
            $deliveryChallan->delete();
            flash('Delivery Challan deleted succesfully', 'success');
            return \redirect()->back();
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this delivery challan', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }
}
