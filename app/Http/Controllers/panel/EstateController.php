<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\User;
use Illuminate\Http\Request;

class EstateController extends Controller
{
    public function index()
    {
        $estates = Estate::with('managerUser')->with('users')->get();
        return view('panel.estate.index', ['estates' => $estates]);
    }

    public function create()
    {
        $users = User::all();
        return view('panel.estate.create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
                'manager' => 'required',
                'name' => 'required',
            ]
        );
        $row = Estate::create([
            'manager' => $request->manager,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'phone2' => $request->phone2,
            'description' => $request->description,
        ]);
        $row->users()->sync($request->users);
        alert()->success('مشاور املاک با موفقیت افزوده شد.', 'عملیات موفق');
        return back();
    }

    public function edit($id)
    {
        $users = User::all();
        $row = Estate::find($id);

        return view('panel.estate.edit', ['users' => $users, 'row' => $row]);
    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
                'manager' => 'required',
                'name' => 'required',
            ]
        );
        $row = Estate::find($id);
        $row->update([
            'manager' => $request->manager,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'phone2' => $request->phone2,
            'description' => $request->description,
        ]);
        $row->users()->sync($request->users);
        alert()->success('مشاور املاک با موفقیت ویرایش شد.', 'عملیات موفق');
        return back();
    }

    public function delete($id)
    {
        $row = Estate::find($id);
        $row->delete();
    }
}
