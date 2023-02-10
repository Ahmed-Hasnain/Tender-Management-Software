<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:edit_supplier')->only('edit','update');
        $this->middleware('can:add_supplier')->only('create', 'store');
        $this->middleware('can:delete_supplier')->only('destroy');
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
            $suppliers = Supplier::with('categories')->where(function ($query) {
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('website', 'like', '%' . $keyword . '%')
                    ->orWhere('address', 'like', '%' . $keyword . '%')
                    ->orWhere('city', 'like', '%' . $keyword . '%')
                    ->orWhere('district', 'like', '%' . $keyword . '%')
                    ->orWhere('country', 'like', '%' . $keyword . '%')
                    ->orWhere('bank_name', 'like', '%' . $keyword . '%')
                    ->orWhere('account_title', 'like', '%' . $keyword . '%')
                    ->orWhere('account_number', 'like', '%' . $keyword . '%')
                    ->orWhere('iban', 'like', '%' . $keyword . '%')
                    ->orWhere('notes', 'like', '%' . $keyword . '%')
                    ->orWhereHas('categories', function($query) use ($keyword){
                        $query->where('name', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('people', function($query) use ($keyword){
                        $query->where('name', 'like', '%' . $keyword . '%')
                        ->orWhere('mobile_no', 'like', '%' . $keyword . '%')
                        ->orWhere('phone_no', 'like', '%' . $keyword . '%')
                        ->orWhere('email', 'like', '%' . $keyword . '%')
                        ->orWhere('department', 'like', '%' . $keyword . '%');
                    });
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('Supplier/Index', [
                'suppliers' => $suppliers,
                'searchedKeyword' => request()->input('keyword'),
            ]);
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this supplier.', 'danger');
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
        return Inertia::render('Supplier/Create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        try{
            DB::beginTransaction();
            $supplier = Supplier::create($request->all());
            $supplier->categories()->sync($request->input('selectedCategories'));
            DB::commit();
            flash('Supplier Added Sucessfully!', 'success');
            return \redirect(route('dashboard.supplier.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return Inertia::render('Supplier/Show', [
            'supplier' => $supplier,
            'people' => $supplier->people
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $categories = $supplier->categories()->pluck('id')->toArray();
        $supplier->categories = $categories;
        return Inertia::render('Supplier/Edit', [
            'categories' => Category::all(),
            'supplier' => $supplier,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        try{
            DB::beginTransaction();
            $supplier->update($request->all());
            $supplier->categories()->sync($request->input('selectedCategories'));
            DB::commit();
            flash('Supplier Updated Sucessfully!', 'success');
            return \redirect(route('dashboard.supplier.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        try {           
            $supplier->delete();
            flash('Supplier deleted succesfully', 'success');
            return \redirect()->back();
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this supplier', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }
}
