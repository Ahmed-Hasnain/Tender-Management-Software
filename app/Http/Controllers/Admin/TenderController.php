<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Client;
use App\Models\Tender;
use Illuminate\Http\Request;
use App\Models\ModeOfPayment;
use Illuminate\Support\Facades\DB;
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
            $limit = \config()->get('settings.pagination_limit');
            $tenders = Tender::with('client')->where(function ($query) {
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('reference_no', 'like', '%' . $keyword . '%')
                    ->orWhere('file_name', 'like', '%' . $keyword . '%')
                    ->orWhere('rate_basis', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%')
                    ->orWhereHas('client', function($query) use ($keyword){
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('Tender/Index', [
                'tenders' => $tenders,
                'searchedKeyword' => request()->input('keyword'),
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
            DB::commit();
            flash('Tender Added Sucessfully!', 'success');
            return \redirect(route('dashboard.tender.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
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
        return Inertia::render('Tender/Show', [
            'tender' => $tender,
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
            'tender' => $tender,
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
}
