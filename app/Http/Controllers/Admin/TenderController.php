<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Unit;
use Inertia\Inertia;
use App\Models\Client;
use App\Models\Tender;
use App\Models\TenderItem;
use Illuminate\Http\Request;
use App\Models\ModeOfPayment;
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
            'items' => Item::all(),
            'units' => Unit::all(),
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
                    ]);
                }
            }
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
        $tender->allItems = $tender->items()->with('item', 'unit')->get();
        return Inertia::render('Tender/Show', [
            'tender' => $tender->load('client', 'mop'),
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
                            'item_id' =>  $tenderItem['item_id']
                        ]);
                    } else {
                        $tenderItem = $tender->items()->create([
                            'unit_id' => $tenderItem['unit_id'],
                            'qty' =>  $tenderItem['qty'],
                            'item_id' =>  $tenderItem['item_id']
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
}
