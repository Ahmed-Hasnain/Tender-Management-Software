<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Client;
use App\Models\Person;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PersonRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit_person')->only('edit','update');
        $this->middleware('can:add_person')->only('create', 'store');
        $this->middleware('can:delete_person')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($companyId)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($companyId)
    {
        return Inertia::render('Person/Create', [
            'company_id' => $companyId,
            'type' => request()->input('type'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($companyId , PersonRequest $request)
    {
        try{
            DB::beginTransaction();
            $type = $request->input('type');
            if ($type && $type == 'client') {
                $client = Client::findOrFail($companyId);
                $person = $client->people()->create($request->all());
                DB::commit();
                flash('Person Added Sucessfully!', 'success');
                return \redirect(route('dashboard.client.show', $companyId));    
            }
            if ($type && $type == 'supplier') {
                $supplier = Supplier::findOrFail($companyId);
                $person = $supplier->people()->create($request->all());
                DB::commit();
                flash('Person Added Sucessfully!', 'success');
                return \redirect(route('dashboard.supplier.show', $companyId));    
            }         
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit($compnayId, Person $person)
    {
        return Inertia::render('Person/Edit', [
            'person' => $person,
            'company_id' => $compnayId
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update($companyId, PersonRequest $request, Person $person)
    {
        try{
            DB::beginTransaction();
            $type = $person->personable_type;
            $person = $person->update($request->all());
            DB::commit();
            flash('Person Updated Sucessfully!', 'success');
            if ($type == "App\Models\Supplier") {
                return \redirect(route('dashboard.supplier.show', $companyId));  
            } else {
                return \redirect(route('dashboard.client.show', $companyId));
            }
                    
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy($companyId, Person $person)
    {
        try {           
            $person->delete();
            flash('Person deleted succesfully', 'success');
            return \redirect()->back();
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this person', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }
}
