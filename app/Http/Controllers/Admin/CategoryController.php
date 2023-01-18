<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:edit_category')->only('edit','update');
        $this->middleware('can:add_category')->only('create', 'store');
        $this->middleware('can:delete_category')->only('destroy');
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
            $categories = Category::with('parent')->where(function ($query) {
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('name', 'like', '%' . $keyword . '%');
                });
            })->orderBy('id', 'desc')->paginate($limit);
            return Inertia::render('Category/Index', [
                'categories' => $categories,
                'searchedKeyword' => request()->input('keyword'),
            ]);
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this category.', 'danger');
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
        return Inertia::render('Category/Create', [
            'categories' => Category::where('parent_id' , null)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try{
            DB::beginTransaction();
            $category = Category::create($request->all());
            DB::commit();
            flash('Category Added Sucessfully!', 'success');
            return \redirect(route('dashboard.category.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return Inertia::render('Category/Edit', [
            'categories' => Category::where('parent_id' , null)->get(),
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try{
            DB::beginTransaction();
            $category->update($request->all());
            DB::commit();
            flash('Category Updated Sucessfully!', 'success');
            return \redirect(route('dashboard.category.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {           
            $category->delete();
            flash('Category deleted succesfully', 'success');
            return \redirect()->back();
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this category', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }
}
