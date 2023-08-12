<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Client;
use App\Models\Tender;
use App\Models\Currency;
use App\Models\Quotation;
use App\Models\TenderItem;
use Illuminate\Http\Request;
use App\Models\QuotationItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationRequest;
use Illuminate\Support\Facades\Response;
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
            $companyParam = request()->input('params') && request()->input('params')['company'] ? request()->input('params')['company'] : "";
            $statusParam = request()->input('params') && request()->input('params')['status'] ? request()->input('params')['status'] : "";
            $departmentParam = request()->input('params') && request()->input('params')['department'] ? request()->input('params')['department'] : "";
            $startDate = request()->input('params') && request()->input('params')['startDate'] ? setDateValues(request()->input('params')['startDate']) : "";
            $endDate = request()->input('params') && request()->input('params')['endDate'] ? setDateValues(request()->input('params')['endDate']) : "";
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
            $quotations = Quotation::with('tender.client','tender.company', 'supplyOrder')->where(function ($query) use ($company, $statusParam, $startDate, $endDate, $departmentParam) {
                //search filter
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('reference_no', 'like', '%' . $keyword . '%')
                    ->orWhere('total_price', 'like', '%' . $keyword . '%')
                    ->orWhere('status', 'like', '%' . str_replace(" ", "_", $keyword) . '%')
                    ->orWhereHas('tender', function($query) use ($keyword){
                        $query->where('reference_no', 'like', '%' . $keyword . '%');
                    });
                });
                // status filter
                $query->when($statusParam, function ($subQuery) use ($statusParam){
                    $subQuery->where('status', $statusParam);
                });
                //last date of submission filter
                $query->when($startDate && $endDate, function ($subQuery) use ($startDate, $endDate){
                    $subQuery->whereBetween('applied_date', [$startDate, $endDate]);
                });
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
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('Quotation/Index', [
                'quotations' => $quotations,
                'searchedKeyword' => request()->input('keyword') ?? '',
                'selectedCompany' => $companyParam,
                'selectedStatus' => $statusParam,
                'selectedDepartment' => $departmentParam,
                'selectedStartDate' => $startDate,
                'selectedEndDate' => $endDate,
                'selectedLimit' => $limit,
                'totalQuotations' => Quotation::count(),
                'quotationIds' => $quotations->pluck('id')->toArray(),
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
        return Inertia::render('Quotation/Create', [
            'tender_items' => Tender::find(request()->input('tender_id'))->items()->with('item', 'unit')->get(),
            'currencies' => Currency::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuotationRequest $request)
    {
        try{
            DB::beginTransaction();
            $quotation = Quotation::create([
                'reference_no' => $request->input('reference_no'),
                'currency' => $request->input('currency'),
                'terms_and_conditions' => $request->input('terms_and_conditions'),
                'tender_id' => $request->input('tender_id'),
                'tax' => $request->input('tax'),
                'delivery_time' => $request->input('delivery_time'),
                'validity_of_quotation' => $request->input('validity_of_quotation'),
                'status' => $request->input('status'),
                'applied_date' => $request->input('applied_date'),
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
            'quotation' => $quotation->load('tender.client', 'tender.mop',  'items.tenderItem.item', 'items.tenderItem.unit'),
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
            'currencies' => Currency::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(QuotationRequest $request, Quotation $quotation)
    {
        try{
            DB::beginTransaction();
            $quotation->update([
                'reference_no' => $request->input('reference_no'),
                'currency' => $request->input('currency'),
                'terms_and_conditions' => $request->input('terms_and_conditions'),
                'tax' => $request->input('tax'),
                'delivery_time' => $request->input('delivery_time'),
                'validity_of_quotation' => $request->input('validity_of_quotation'),
                'status' => $request->input('status'),
                'applied_date' => $request->input('applied_date'),
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
            return \redirect(route('dashboard.quotation.index'));          
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

    public function downloadQuotation($quotationId, $company, $date = null) 
    {
        try {
            $quotation = Quotation::with('tender.client', 'tender.mop', 'items.tenderItem.item', 'items.tenderItem.unit')->findOrFail($quotationId);
            $data = [
                'quotation' => $quotation,
                'date' => $date
            ];
            switch ($company) {
                case 'OndreTicaretTemplate':
                    $data['logo'] = "assets/images/logo/onder-logo.png";
                    $pdf = Pdf::loadView('OndreTicaretTemplate', $data);
                    break;
                case 'MSaadAndCompanyTemplate':
                    $data['logo'] = "assets/images/logo/saad&co.png";
                    $pdf = Pdf::loadView('MSaadAndCompanyTemplate', $data);
                    break;
                case 'AscentTemplate':
                    $data['logo'] = "assets/images/logo/ascent.png";
                    $pdf = Pdf::loadView('AscentTemplate', $data);
                    break;
            }
            // return view($company, $data);
            return $pdf->download('Quotation-' . $quotation->reference_no . '.pdf');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    public function quotationReports($reportParams) 
    {
        try {
            $params = json_decode($reportParams, true);
            $ids = $params['ids'];
            $company = $params['company'];
            $status = $params['status'];
            $startDate = $params['start_date'];
            $endDate = $params['end_date'];
            $limit = $params['limit'];
            $quotations = Quotation::whereIn('id', $ids)->with('tender.client', 'tender.company')->get();
            $data = [
                'quotations' =>  $quotations,
                'status' => $status,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'limit' => $limit,
                'totalAmount' => calculateSum($quotations, 'quotation'),
                'report_type' => 'Quotation',
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
            return $pdf->download('Quotation-Report.pdf');
        } catch (\Throwable $th) {
            Log::error([
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ]);
        }
    }
}
