<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tender;
use App\Models\TenderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\TenderItemRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TenderItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit_tender')->only('update');
        $this->middleware('can:add_tender')->only('store');
        $this->middleware('can:delete_tender')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TenderItemRequest $request)
    {
        try{
            DB::beginTransaction();
            $tender = Tender::findOrFail($request->tender_id);
            $tender->items()->create($request->all());
            DB::commit();
            flash('Tender Item Added Sucessfully!', 'success');
            return \redirect()->back();     
        }catch (\Exception $e) {
            DB::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TenderItemRequest $request, TenderItem $tenderItem)
    {
        try{
            DB::beginTransaction();
            $tenderItem->update($request->all());
            DB::commit();
            flash('Tender Item Updated Sucessfully!', 'success');
            return \redirect()->back();     
        }catch (\Exception $e) {
            DB::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TenderItem $tenderItem)
    {
        try {           
            $tenderItem->delete();
            flash('Tender Item deleted succesfully', 'success');
            return \redirect()->back();
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this tender item', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }
}
