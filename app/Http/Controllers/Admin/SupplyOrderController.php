<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Quotation;
use App\Models\SupplyOrder;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
                'status' => $request->input('status'),
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
                'status' => $request->input('status'),
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

    public function downloadSupplyOrder($supplyOrderId, $company, $type)
    {
        try {
            $supplyOrder = SupplyOrder::with('items.quotationItem.tenderItem.item', 'items.quotationItem.tenderItem.unit', 'quotation.tender.items.item', 'quotation.tender.items.unit', 'quotation.tender.client')->findOrFail($supplyOrderId);
            $data = [
                'supplyOrder' => $supplyOrder,
            ];
            if ($type === 'sale_tax_invoice') {
                switch ($company) {
                    case 'OndreTicaretTemplate':
                        $data['logo'] = "assets/images/logo/onder-logo.png";
                        $pdf = Pdf::loadView('SaleTaxInvoice/OndreTicaretDCTemplate', $data);
                        break;
                    case 'MSaadAndCompanyTemplate':
                        $data['logo'] = "assets/images/logo/saad&co.png";
                        $pdf = Pdf::loadView('SaleTaxInvoice/MSaadAndCompanyDCTemplate', $data);
                        break;
                    case 'AscentTemplate':
                        $data['logo'] = "assets/images/logo/ascent.png";
                        $pdf = Pdf::loadView('SaleTaxInvoice/AscentDCTemplate', $data);
                        break;
                }
            } else {
                switch ($company) {
                    case 'OndreTicaretTemplate':
                        $data['logo'] = "assets/images/logo/onder-logo.png";
                        $pdf = Pdf::loadView('CommercialInvoice/OndreTicaretDCTemplate', $data);
                        break;
                    case 'MSaadAndCompanyTemplate':
                        $data['logo'] = "assets/images/logo/saad&co.png";
                        $pdf = Pdf::loadView('CommercialInvoice/MSaadAndCompanyDCTemplate', $data);
                        break;
                    case 'AscentTemplate':
                        $data['logo'] = "assets/images/logo/ascent.png";
                        $pdf = Pdf::loadView('CommercialInvoice/AscentDCTemplate', $data);
                        break;
                }
            }
            //updating invoice download flags
            switch ($type) {
                case 'sale_tax_invoice':
                    $supplyOrder->sti_downloaded = $supplyOrder->sti_downloaded ? $supplyOrder->sti_downloaded : true; 
                    break;
                case 'commercial_invoice':
                    $supplyOrder->ci_downloaded = $supplyOrder->ci_downloaded ? $supplyOrder->ci_downloaded : true; 
                    break;
            }
            $supplyOrder->saveQuietly();
            // return view($company, $data);
            return $pdf->download( replaceUnderscoreWithDash($type) . '-' . $supplyOrder->quotation->reference_no . '.pdf');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    public function getInvoices()
    {
        try{
            switch (request()->input('company')) {
                case 'OndreTicaretTemplate':
                    $company = 'Onder Ticaret (Private) Limited';
                    break;
                case 'MSaadAndCompanyTemplate':
                    $company = 'Muhammad Saad and Company';
                    break;
                default:
                    $company = 'Ascent Tech Trade Solution';
                    break;
            }
            $limit = \config()->get('settings.pagination_limit');
            $supplyOrder = SupplyOrder::with('quotation.tender', 'items', 'paymentRecieving')->where(function ($query) use ($company){
                $keyword = request()->input('keyword');
                $query->whereDelivered(1);
                $query->when($keyword, function ($subQuery) use ($keyword, $company){
                    $subQuery->whereHas('quotation', function($query) use ($keyword, $company){
                        $query->where('reference_no', 'like', '%' . $keyword . '%')
                        ->orWhereHas('tender', function ($query) use ($keyword, $company) {
                            $query->where('reference_no', 'like', '%' . $keyword . '%');
                        });
                    });
                })
                ->whereHas('quotation', function($query) use ($company){
                    $query->whereHas('tender', function ($query) use ($company) {
                        $query->whereRelation('company', 'name', $company);
                    });
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('Invoices/Index', [
                'supplyOrder' => $supplyOrder,
                'searchedKeyword' => request()->input('keyword'),
                'selectedCompany' => request()->input('company') ?? 'AscentTemplate' 
            ]);
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }
}
