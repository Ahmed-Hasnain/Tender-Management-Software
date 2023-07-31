<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Unit;
use Inertia\Inertia;
use App\Models\Client;
use App\Models\Demand;
use App\Models\Tender;
use App\Models\Company;
use App\Models\TenderItem;
use Illuminate\Http\Request;
use App\Models\ModeOfPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\TenderRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TenderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit_tender')->only('edit','update');
        $this->middleware('can:add_tender')->only('create', 'store');
        $this->middleware('can:delete_tender')->only('destroy');
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
            $tenders = Tender::with('client', 'quotation', 'company')->where(function ($query) use ($company, $statusParam, $startDate, $endDate, $departmentParam){
                $keyword = request()->input('keyword');
                //search 
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('reference_no', 'like', '%' . $keyword . '%')
                    ->orWhere('file_name', 'like', '%' . $keyword . '%')
                    ->orWhere('rate_basis', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%')
                    ->orWhereHas('client', function($query) use ($keyword){
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });
                });
                //company filter
                $query->when($company, function ($subQuery) use ($company){
                    $subQuery->whereRelation('company', 'name', $company);
                });
                //status filter
                $query->when($statusParam, function ($subQuery) use ($statusParam) {
                    $subQuery->where('status', $statusParam);
                });
                //department filter
                $query->when($departmentParam, function ($subQuery) use ($departmentParam) {
                    $subQuery->whereRelation('client', 'name', $departmentParam);
                });
                //last date of submission filter
                $query->when($startDate && $endDate, function ($subQuery) use ($startDate, $endDate) {
                    $subQuery->whereBetween('last_date_of_submission', [$startDate, $endDate]);
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('Tender/Index', [
                'tenders' => $tenders,
                'searchedKeyword' => request()->input('keyword') ?? '',
                'selectedCompany' => $companyParam,
                'selectedStatus' => $statusParam,
                'selectedDepartment' => $departmentParam,
                'selectedStartDate' => $startDate,
                'selectedEndDate' => $endDate,
                'selectedLimit' => $limit,
                'totalTenders' => Tender::count(),
                'tenderIds' => $tenders->pluck('id')->toArray(),
                'allDepartments' => Client::select('name')->get(),
            ]);
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this tender.', 'danger');
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
        return Inertia::render('Tender/Create', [
            'mode_of_payment' => ModeOfPayment::all(),
            'clients' => Client::all(),
            'items' => Item::all(),
            'units' => Unit::all(),
            'companies' => Company::all(),
            'demands' => Demand::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TenderRequest $request)
    {
        try{
            DB::beginTransaction();
            $tender = Tender::create($request->all());
            $tenderItems = $request->input('items');
            if (count($tenderItems) > 0) {
                foreach ($tenderItems as $key => $tenderItem) {
                    $tender->items()->create([
                        'item_id' => $tenderItem['item_id'],
                        'unit_id' => $tenderItem['unit_id'],
                        'qty' => $tenderItem['qty'],
                        'description' => $tenderItem['description'],
                    ]);
                }
            }
            DB::commit();
            flash('Tender Added Sucessfully!', 'success');
            return \redirect(route('dashboard.tender.index'));          
        }catch (\Exception $e) {
            DB::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tender  $tender
     * @return \Illuminate\Http\Response
     */
    public function show(Tender $tender)
    {
        $tender->allItems = $tender->items()->with('item', 'unit')->get();
        return Inertia::render('Tender/Show', [
            'tender' => $tender->load('client', 'mop', 'demand', 'company'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tender  $tender
     * @return \Illuminate\Http\Response
     */
    public function edit(Tender $tender)
    {
        return Inertia::render('Tender/Edit', [
            'mode_of_payment' => ModeOfPayment::all(),
            'clients' => Client::all(),
            'tender' => $tender->load('items'),
            'items' => Item::all(),
            'units' => Unit::all(),
            'companies' => Company::all(),
            'demands' => Demand::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tender  $tender
     * @return \Illuminate\Http\Response
     */
    public function update(TenderRequest $request, Tender $tender)
    {
        try{
            DB::beginTransaction();
            $tender->update($request->all());
            $tenderItems = $request->input('items');
            $tenderItemIds = [];
            if (count($tenderItems) > 0) {
                foreach ($tenderItems as $key => $tenderItem) {
                    if (array_key_exists('id', $tenderItem)) {
                        $tenderItemIds [] = $tenderItem['id'];
                        $tender->items()->whereId($tenderItem['id'])->update([
                            'unit_id' => $tenderItem['unit_id'],
                            'qty' =>  $tenderItem['qty'],
                            'item_id' =>  $tenderItem['item_id'],
                            'description' => $tenderItem['description'],

                        ]);
                    } else {
                        $tenderItem = $tender->items()->create([
                            'unit_id' => $tenderItem['unit_id'],
                            'qty' =>  $tenderItem['qty'],
                            'item_id' =>  $tenderItem['item_id'],
                            'description' => $tenderItem['description'],
                        ]);
                        $tenderItemIds [] = $tenderItem->id;
                    }
                }
                $tender->items()->whereNotIn('id', $tenderItemIds)->delete();
            }
            DB::commit();
            flash('Tender Updated Sucessfully!', 'success');
            return \redirect(route('dashboard.tender.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tender  $tender
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tender $tender)
    {
        try {           
            $tender->delete();
            flash('Tender deleted succesfully', 'success');
            return \redirect()->back();
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this tender', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    public function tenderReports($reportParams) 
    {
        try {
            $params = json_decode($reportParams, true);
            $ids = $params['ids'];
            $company = $params['company'];
            $status = $params['status'];
            $startDate = $params['start_date'];
            $endDate = $params['end_date'];
            $limit = $params['limit'];
            $tenders = Tender::whereIn('id', $ids)->with('client', 'company')->get();
            $data = [
                'tenders' =>  $tenders,
                'status' => $status,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'limit' => $limit,
                'report_type' => 'tender',
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
            return $pdf->download('Tender-Report.pdf');
        } catch (\Throwable $th) {
            Log::error([
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ]);
        }
    }
}
