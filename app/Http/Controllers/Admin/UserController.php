<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:edit_user')->only('edit','update');
        $this->middleware('can:add_user')->only('create', 'store');
        $this->middleware('can:delete_user')->only('destroy');
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
            $users = User::where(function ($query) {
                $keyword = request()->input('keyword');
                $query->when($keyword, function ($subQuery) use ($keyword){
                    $subQuery->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('user_type', 'like', '%' . $keyword . '%')
                    ->orWhere('status', 'like', '%' . $keyword . '%');
                });
            })->paginate($limit);
            return Inertia::render('Users/Index', [
                'users' => $users,
                'searchedKeyword' => request()->input('keyword'),
            ]);
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this delivery zone', 'danger');
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
        return Inertia::render('Users/Edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try{
            DB::beginTransaction();
            $user = User::create($request->except('avatar'));
            $this->addAvatar($request, $user);
            DB::commit();
            flash('User Added Sucessfully!', 'success');
            return \redirect(route('dashboard.user.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        try{
            DB::beginTransaction();
            $user->update($request->except('avatar'));
            $this->addAvatar($request, $user);
            DB::commit();
            flash('User Updated Sucessfully!', 'success');
            return \redirect(route('dashboard.user.index'));          
        }catch (\Exception $e) {
            Db::rollBack();
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
    public function destroy(User $user)
    {
        try {
            $user->delete();
            flash('User deleted succesfully', 'success');
            return \redirect()->route('dashboard.user.index');
        } catch (ModelNotFoundException $e) {
            flash('Unable to find this user', 'danger');
            return \redirect()->back();
        } catch (\Exception $e) {
            flash($e->getMessage(), 'danger');
            return \redirect()->back();
        }
    }

    public function addAvatar($request, $user){
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            if ($user->getRawOriginal('avatar')) {
                $image = $user->getRawOriginal('avatar');
                if(Storage::disk('public')->exists($image)){
                    $imagePath = public_path('storage/'.$image);
                    unlink($imagePath);
                }
            }
            $image = $request->file('avatar')->store('images', 'public');
            $user->avatar = $image;
            $user->save();
        }
        return;
    }
}
