<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Imports\SectorImporter;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Field;
use App\Models\Form;
use App\Models\Poster;
use App\Models\Sector;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Fluent\Concerns\Has;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;

class HomeController extends Controller
{
    public function index()
    {



        $now = Jalalian::now()->format('Y/m/d');
        $posters = Poster::where('active', 1)
            ->where('date_from', '<=', $now)
            ->where('date_to', '>=', $now)
            ->with('form')
            ->with('type')
            ->take(6)
            ->get();
        $sectors = Sector::all();
        $types = Type::all();
        $forms = Form::all();
        $items = [];
        $groupForm = Poster::with([
            'form' => function ($query) {
                $query->select('id', 'name');
            },
        ])
            ->select('id', 'form_id')
            ->get()
            ->groupBy('form_id');


        return view('home.index', [
            'posters' => $posters,
            'items' => $items,
            'types' => $types,
            'forms' => $forms,
            'groupForm' => $groupForm,
            'sectors' => $sectors]);
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function contactStore(Request $request)
    {
        Contact::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'title' => $request->title,
            'body' => $request->body,
            'active' => 1,
        ]);
        alert()->success('درخواست شما با موفقیت ثبت گردید.', 'عملیات موفق');
        return back();
    }

    public function search_box($id)
    {
        $items = Field::where('form_id', $id)->where('filter', 1)->get();
        $sectors = Sector::all();
        $types = Type::all();
        $forms = Form::all();
        return view('include.home.search', [
            'items' => $items,
            'types' => $types,
            'sectors' => $sectors,
            'forms' => $forms]);
    }

    public function search_box2($id)
    {
        $items = Field::where('form_id', $id)->where('filter', 1)->get();
        $sectors = Sector::all();
        $types = Type::all();
        $forms = Form::all();
        return view('include.home.search2', [
            'items' => $items,
            'types' => $types,
            'sectors' => $sectors,
            'forms' => $forms]);
    }

    public function search(Request $request)
    {
        $now = Jalalian::now()->format('Y/m/d');
        $fields = [];
        if ($request->field != null) {
            foreach ($request->field as $key => $field) {
                if ($field != null) {
                    $fields[] = ['key' => $key, 'value' => $field];
                }
            }
        }

        $posters = Poster::where('active', 1)
            ->where('date_from', '<=', $now)
            ->where('date_to', '>=', $now)
            ->when($request->get('form_id'), function ($query) use ($request) {
                $query->where('form_id', $request->form_id);
            })
            ->when($request->get('sector_id'), function ($query) use ($request) {
                $query->wherein('sector_id', $request->sector_id);
            })
            ->when($request->get('type_id'), function ($query) use ($request) {
                $query->wherein('type_id', $request->type_id);

            })
            ->when($request->get('field'), function ($query) use ($request) {

            })
//            ->whereHas('detail', function ($query) use ($fields) {
//                if ($fields != '[]') {
//                    foreach ($fields as $field) {
//
////                        dd(json_encode($field['value']),$field['value']);
////                        $query->where('field_id', 10)
////                            ->where('value',"\"20\"")
////                        ;
//                    }
//                }
//            })
            ->with('form')
            ->with('type')
            ->with('sector')
            ->with('images')
            ->with([
                'detail' => function ($query) {
                    $query->select('id', 'value', 'field_id', 'poster_id');
                },
                'detail.field' => function ($query) {
                    $query->select('id', 'name');

                },
            ])
            ->latest()
            ->paginate(2);

        $sectors = Sector::all();
        $types = Type::all();
        $forms = Form::all();
        $items = [];
        $login = auth()->user();

        return view('home.search', [
            'posters' => $posters,
            'login' => $login,
            'items' => $items,
            'types' => $types,
            'forms' => $forms,
            'sectors' => $sectors]);
    }

    public function single($id)
    {
        $poster = Poster::where('active', 1)
            ->where('id', $id)
            ->with('form')
            ->with('type')
            ->with('images')
            ->withCount([
                'comments' => function ($query) {
                    $query->where('verify', 1);
                },
            ])
            ->with([
                'comments' => function ($query) {
                    $query->where('verify', 1);
                },
            ])
            ->first();
//        return $poster;
        return view('home.single', [
            'poster' => $poster,
        ]);
    }

    public function like($id)
    {
        $row = Poster::where('id', $id)->first();
        $row->like()->attach(auth()->user()->id);
        return back();
    }

    public function comment(Request $request, $id)
    {

        Comment::create([
            'user_id' => auth()->user()->id,
            'poster_id' => $id,
            'verify' => 1,
            'body' => $request['body']
        ]);
        return back();
    }

}
