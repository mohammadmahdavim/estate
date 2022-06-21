<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\Poster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class CompareController extends Controller
{
    public function posters()
    {

        $ids = [];
        $firstPoster = [];
        $posters = [];
        if (Session::has('posters')) {
            if (Session::all()['posters'] != []) {
                $ids = Session::all()['posters'];
                $key = array_key_first($ids);
                $firstPoster = Poster::where('id', $ids[$key])
                    ->with([
                        'form' => function ($query) {
                            $query->select('id', 'name');
                        },
                        'form.field' => function ($query) {
                            $query->select('id', 'name', 'form_id');
                        },
                    ])
                    ->first();
                $posters = Poster::whereIn('id', $ids)
                    ->where('form_id', $firstPoster->form_id)
                    ->whereNOtin('id', [$firstPoster->id])
                    ->with('detail')
                    ->get();
            }
        }
        return view('home.compare', ['firstPoster' => $firstPoster, 'posters' => $posters]);
    }

    public function addDataSession(Request $request, $id)
    {
        if (Session::has('posters')) {
            if (Session::all()['posters'] != '[]') {
                $ids = Session::all()['posters'];
                $key = array_key_first($ids);
                $firstPoster = Poster::where('id', $ids[$key])
                    ->pluck('form_id')
                    ->first();
                $thisPoster = Poster::where('id', $id)
                    ->pluck('form_id')
                    ->first();
                if ($thisPoster == $firstPoster) {
                    $request->session()->push('posters', $id);
                } else {
                    return Response::json('error', '500');
                }
            }
        } else {
            $request->session()->push('posters', $id);
        }

    }

    public function destroyDataSession($id)
    {
        $posters = session()->pull('posters', []);
        $idToDelete = $id;
        if (($key = array_search($idToDelete, $posters)) !== false) {
            unset($posters[$key]);
        }
        session()->put('posters', $posters);

    }
}
