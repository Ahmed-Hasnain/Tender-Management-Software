<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Client;
use App\Models\Quotation;
use App\Models\SupplyOrder;
use Illuminate\Http\Request;
use App\Models\DeliveryChallan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            $companyParam = request()->input('params') && request()->input('params')['company'] ? request()->input('params')['company'] : "";
            $statusParam = request()->input('params') && request()->input('params')['status'] ? request()->input('params')['status'] : "";
            $departmentParam = request()->input('params') && request()->input('params')['department'] ? request()->input('params')['department'] : "";
            $startDate = request()->input('params') && request()->input('params')['startDate'] ? setDateValues(request()->input('params')['startDate']) : "";
            $endDate = request()->input('params') && request()->input('params')['endDate'] ? setDateValues(request()->input('params')['endDate']) : "";
            $itemStatusParam = request()->input('params') && request()->input('params')['item_status'] ? request()->input('params')['item_status'] : "";
            $amountIncludedParam = request()->input('params') && request()->input('params')['amount_included'] ? request()->input('params')['amount_included'] : "";
            $limit = request()->input('params') && request()->input('params')['limit'] ? request()->input('params')['limit'] : 10;

            switch ($companyParam) {
                case 'OndreTicaretTemplate':
                    $company = 'Onder Ticaret (Private) Limited';
                    break;
                case 'MSaadAndCompanyTemplate':
                    $company = 'Muhammad Saad and Company';
                    break;
                case 'AscentTemplate':
                    $company = 'Ascent Tech Trade Solution';
                    break;
                default:
                    $company = null;
                    break;
            }
            $deliveryChallan = DeliveryChallan::with('supplyOrder.quotation.tender')->where(function ($query) use ($company, $statusParam, $startDate, $endDate, $departmentParam){
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
                //created date filter
                $query->when($startDate && $endDate, function ($subQuery) use ($startDate, $endDate){
                    $subQuery->whereBetween('created_at', [$startDate, $endDate]);
                });
                $query->whereHas('supplyOrder', function ($query) use ($company, $statusParam, $startDate, $endDate, $departmentParam) {
                    // status filter
                    $query->when($statusParam, function ($subQuery) use ($statusParam){
                        $subQuery->where('status', $statusParam);
                    });
                    //quotation filters
                    $query->whereHas('quotation', function ($query) use ($company, $departmentParam){
                        //tender filters
                        $query->whereHas('tender', function ($query) use ($company, $departmentParam){
                            //company filter
                            $query->when($company, function ($subQuery) use ($company){
                                $subQuery->whereRelation('company', 'name', $company);
                            });
                            //department filter
                            $query->when($departmentParam, function ($subQuery) use ($departmentParam) {
                                $subQuery->whereRelation('client', 'name', $departmentParam);
                            });
                        });
                    });
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('DeliveryChallan/Index', [
                'deliveryChallan' => $deliveryChallan,
                'searchedKeyword' => request()->input('keyword') ?? '',
                'selectedCompany' => $companyParam,
                'selectedStatus' => $statusParam,
                'selectedDepartment' => $departmentParam,
                'selectedStartDate' => $startDate,
                'selectedEndDate' => $endDate,
                'selectedLimit' => $limit,
                'selectedItemStatus' => $itemStatusParam,
                'selectedAmountIncluded' => $amountIncludedParam,
                'totalDeliveryChallans' => DeliveryChallan::count(),
                'deliveryChallanIds' => $deliveryChallan->pluck('id')->toArray(),
                'allDepartments' => Client::select('name')->get(),
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

    public function downloadDeliveryChallan($deliveryChallanId, $company, $date = null)
    {
        try {
            $deliveryChallan = DeliveryChallan::with( 'supplyOrder.quotation.tender.client','items.supplyOrderItem.quotationItem.tenderItem.item', 'items.supplyOrderItem.quotationItem.tenderItem.unit')->findOrFail($deliveryChallanId);
            $data = [
                'deliveryChallan' => $deliveryChallan,
                'date' => $date
            ];
            switch ($company) {
                case 'OndreTicaretTemplate':
                    $data['logo'] = "assets/images/logo/onder-logo.png";
                    $pdf = Pdf::loadView('DeliveryChallan/OndreTicaretDCTemplate', $data);
                    break;
                case 'MSaadAndCompanyTemplate':
                    $data['logo'] = "assets/images/logo/saad&co.png";
                    $pdf = Pdf::loadView('DeliveryChallan/MSaadAndCompanyDCTemplate', $data);
                    break;
                case 'AscentTemplate':
                    $data['logo'] = "assets/images/logo/ascent.png";
                    $pdf = Pdf::loadView('DeliveryChallan/AscentDCTemplate', $data);
                    break;
            }
            // return view('DeliveryChallan/OndreTicaretDCTemplate', $data);
            return $pdf->download('Delivery-Challan-' . $deliveryChallan->supplyOrder->quotation->reference_no . '.pdf');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    public function deliveryChallanReports($reportParams) 
    {
        try {
            $params = json_decode($reportParams, true);
            $ids = $params['ids'];
            $company = $params['company'];
            $status = $params['status'];
            $startDate = $params['start_date'];
            $endDate = $params['end_date'];
            $limit = $params['limit'];
            $deliveryChallans = DeliveryChallan::whereIn('id', $ids)->with('supplyOrder.quotation.tender.client', 'supplyOrder.quotation.tender.company')->get();
            $data = [
                'deliveryChallans' =>  $deliveryChallans,
                'status' => $status,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'limit' => $limit,
                'totalAmount' => $deliveryChallans->sum('total'),
                'report_type' => 'Delivery Challan',
            ];
            switch ($company) {
                case 'OndreTicaretTemplate':
                    $data['logo'] = "assets/images/logo/onder-logo.png";
                    $data['company'] = "Onder Ticaret";
                    $pdf = Pdf::loadView('Reports/OnderTicaret', $data); 
                    break;
                case 'MSaadAndCompanyTemplate':
                    $data['logo'] = "assets/images/logo/saad&co.png";
                    $data['company'] = "Muhammad Saad And Company";
                    $pdf = Pdf::loadView('Reports/MSaadAndCompany', $data); 
                    break;
                case 'AscentTemplate':
                    $data['logo'] = "assets/images/logo/ascent.png";
                    $data['company'] = "Ascent Tech";
                    $pdf = Pdf::loadView('Reports/AscentTech', $data); 
                    break;
                default:
                    $data['logo'] = "assets/images/logo/ascent.png";
                    $data['company'] = "None";
                    $pdf = Pdf::loadView('Reports/Tender', $data); 
                    break; 
            }
            return $pdf->download('Delivery-Challan-Report.pdf');
        } catch (\Throwable $th) {
            Log::error([
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ]);
        }
    }
}
