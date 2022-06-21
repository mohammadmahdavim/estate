<?php
/**
 * Created by PhpStorm.
 * User: mamad
 * Date: 05/06/2020
 * Time: 05:32 PM
 */

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class userService
{

    public function store($request)
    {

        $user = User::create([
            'name' => $request->name,
            'national_code' => $request->national_code,
            'mobile' => $request->mobile,
            'role' => $request->role,
            'password' => Hash::make($request->national_code),
        ]);
        $user->syncRoles($request->input('role'));

    }

    public function update($request, $row)
    {
        $row->update([
            'name' => $request->name,
            'national_code' => $request->national_code,
            'mobile' => $request->mobile,
            'role' => $request->role,
            'password' => Hash::make($request->national_code),
        ]);
        $row->syncRoles($request->input('role'));

    }
}
