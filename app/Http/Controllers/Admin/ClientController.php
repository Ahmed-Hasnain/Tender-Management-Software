<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Client;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit_client')->only('edit','update');
        $this->middleware('can:add_client')->only('create', 'store');
        $this->middleware('can:delete_client')->only('destroy');
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
            $clients = Client::with('category')->where(function ($query) {
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('website', 'like', '%' . $keyword . '%')
                    ->orWhere('address', 'like', '%' . $keyword . '%')
                    ->orWhere('city', 'like', '%' . $keyword . '%')
                    ->orWhere('district', 'like', '%' . $keyword . '%')
                    ->orWhere('country', 'like', '%' . $keyword . '%')
                    ->orWhere('notes', 'like', '%' . $keyword . '%');
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('Client/Index', [
                'clients' => $clients,
                'searchedKeyword' => request()->input('keyword'),
            ]);
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this client.', 'danger');
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
        return Inertia::render('Client/Create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        try{
            DB::beginTransaction();
            $client = Client::create($request->all());
            DB::commit();
            flash('Client Added Sucessfully!', 'success');
            return \redirect(route('dashboard.client.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return Inertia::render('Client/Show', [
            'client' => $client,
            'people' => $client->people
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return Inertia::render('Client/Edit', [
            'categories' => Category::all(),
            'client' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
        try{
            DB::beginTransaction();
            $client->update($request->all());
            DB::commit();
            flash('Client Updated Sucessfully!', 'success');
            return \redirect(route('dashboard.client.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        try {           
            $client->delete();
            flash('Client deleted succesfully', 'success');
            return \redirect()->back();
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this client', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }
}
