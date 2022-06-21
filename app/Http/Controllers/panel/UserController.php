<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Field;
use App\Models\Teammate;
use App\Models\University;
use App\Models\User;
use App\Services\userService;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{

    public $userService;

    public function __construct(userService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('panel.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('panel.users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $this->userService->store($request);
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return redirect('/panel/users');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = User::find($id);
        $roles = Role::pluck('name');

        return view('panel.users.edit', ['row' => $row,'roles'=>$roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $row = User::find($id);
        $this->userService->update($request, $row);
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return redirect('/panel/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $row = User::find($id);
        $row->delete();
    }
    public function favorite()
    {
        $user = User::where('id', auth()->user()->id)->with('favorite')->first();
        return view('panel.users.favorites',['user'=> $user]);
    }
    public function delete_favorites($id)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $user->favorite()->detach($id);
        alert()->success('آگهی از لیست علاقمندی های شما حذف شد.', 'موفق');
        return back();
    }
}
