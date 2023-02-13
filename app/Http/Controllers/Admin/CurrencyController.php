<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit_currency')->only('edit','update');
        $this->middleware('can:add_currency')->only('create', 'store');
        $this->middleware('can:delete_currency')->only('destroy');
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
            $currencies = Currency::where(function ($query) {
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('symbol', 'like', '%' . $keyword . '%');
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('Currency/Index', [
                'currencies' => $currencies,
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
        return Inertia::render('Currency/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencyRequest $request)
    {
        try{
            DB::beginTransaction();
            $currency = Currency::create($request->all());
            DB::commit();
            flash('Currency Added Sucessfully!', 'success');
            return \redirect(route('dashboard.currency.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return Inertia::render('Currency/Edit', [
            'currency' => $currency
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(CurrencyRequest $request, Currency $currency)
    {
        try{
            DB::beginTransaction();
            $currency->update($request->all());
            DB::commit();
            flash('Currency Updated Sucessfully!', 'success');
            return \redirect(route('dashboard.currency.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        try {           
            $currency->delete();
            flash('Currency deleted succesfully', 'success');
            return \redirect()->back();
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this currency', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }
}
