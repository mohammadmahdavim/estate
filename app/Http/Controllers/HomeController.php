<?php

namespace App\Http\Controllers;

use App\Imports\SectorImporter;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('panel.blank');

//        $response = Http::withHeaders([
//            'Api-Key' => 'service.pYhLm5JfM9Dnv65snZLA4H2CfmRM2Llh2e7I6xH5',
//        ])->get('https://api.neshan.org/v2/static?key=service.pYhLm5JfM9Dnv65snZLA4H2CfmRM2Llh2e7I6xH5&type=neshan&zoom=10&center=35.71586339999998,51.4012605&width=500&height=500&marker=blue'
//);
        $client = new Client([
            // Example
            'base_uri' => 'https://www.google.com',
        ]);

        // Send request and collect response
//        $response       = $client->get('https://api.neshan.org/v2/static?key=service.pYhLm5JfM9Dnv65snZLA4H2CfmRM2Llh2e7I6xH5&type=neshan&zoom=10&center=35.71586339999998,51.4012605&width=500&height=500&marker=blue');
//$response=new Request('GET', 'https://api.neshan.org/v2/static?key=service.pYhLm5JfM9Dnv65snZLA4H2CfmRM2Llh2e7I6xH5&type=neshan&zoom=10&center=35.71586339999998,51.4012605&width=500&height=500&marker=blue');
        $response = Http::get('https://api.neshan.org/v2/static?key=service.pYhLm5JfM9Dnv65snZLA4H2CfmRM2Llh2e7I6xH5&type=neshan&zoom=10&center=35.71586339999998,51.4012605&width=500&height=500&marker=blue');

        dd($response->json());

dd($response->json());
        return view('home');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('profile', ['user' => $user]);
    }

    public function password(Request $request)
    {
        $this->validate(request(),
            [
                'old_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required',
            ]
        );

        $user = auth()->user();

        if ($request->old_password || $request->new_password || $request->confirm_password) {
            if (!Hash::check($request['old_password'], $user->password)) {
                alert()->error('پسورد وارد شده قبلی شما نادرست است', 'خطا')->autoClose(5000);
                return back();
            } else {
                if ($request->new_password == $request->confirm_password) {
                    $password = Hash::make($request->new_password);
                    $user->update([
                        'password' => $password,
                    ]);
                    alert()->success('ویرایش شما با موفقیت ثبت گردید!', 'موفق');
                    return back();
                } else {
                    alert()->error('رمز عبور با تکرار آن مطابقت ندارد', 'خطا')->autoClose(5000);
                    return back();
                }
            }

        }
    }

    public function sector(Request $request)
    {

        $this->validate($request, [
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);
        $path = $request->file('file')->getRealPath();
        Excel::import(new SectorImporter(), $path);

        return back();
    }
}
