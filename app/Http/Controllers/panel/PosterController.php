<?php

namespace App\Http\Controllers\panel;

use App\Helpers\Reply;
use App\Http\Controllers\Controller;
use App\Http\Requests\PosterCreateRequest;
use App\Http\Requests\PosterUpdateRequest;
use App\Models\Field;
use App\Models\Form;
use App\Models\Poster;
use App\Models\PosterDetail;
use App\Models\PosterDocument;
use App\Models\PosterImage;
use App\Models\Sector;
use App\Models\Type;
use App\Models\User;
use App\Services\CvService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class PosterController extends Controller
{

    public $CvService;

    public function __construct(CvService $cvService)
    {
        $this->CvService = $cvService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posters = Poster::with(['authorPost' => function ($query) {
            $query->select('id', 'name');
        }, 'form' => function ($query) {
            $query->select('id', 'name');

        }, 'type' => function ($query) {
            $query->select('id', 'name');
        }
            , 'sector' => function ($query) {
                $query->select('id', 'name');
            }
        ])
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->title . '%');
            })
            ->when($request->get('mobile'), function ($query) use ($request) {
                $query->where('mobile', 'like', '%' . $request->mobile . '%');
            })
            ->when($request->get('author'), function ($query) use ($request) {
                $query->whereIn('author', $request->author);
            })
            ->when($request->get('form_id'), function ($query) use ($request) {
                $query->whereIn('form_id', $request->form_id);
            })
            ->when($request->get('type_id'), function ($query) use ($request) {
                $query->whereIn('type_id', $request->type_id);
            })
            ->when($request->get('date_from'), function ($query) use ($request) {
                $query->where('date_from', '>=', $request->date_from);
            })
            ->when($request->get('date_to'), function ($query) use ($request) {
                $query->where('date_to', '<=', $request->date_to);
            })
            ->when($request->get('status'), function ($query) use ($request) {
                if ($request->status == 'salled') {
                    $query->where('salled', 1);

                } elseif ($request->status == 'verify') {
                    $query->where('verify', 1);
                } elseif ($request->status == 'noverify') {
                    $query->where('verify', 0);

                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(30);
        $users = User::select('id', 'name')->get();
        $forms = Form::select('id', 'name')->get();
        $types = Type::select('id', 'name')->get();
        $user = User::where('id', auth()->user()->id)->with('favorite')->first();
        return view('panel.poster.index', ['rows' => $posters, 'user' => $user, 'forms' => $forms, 'types' => $types, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $forms = Form::all();
        $fields = Field::where('form_id', $request->form_id)->with('option')->get();
        $types = Type::all();
        $sectors = Sector::all();
        return view('panel.poster.create', ['sectors' => $sectors, 'forms' => $forms, 'types' => $types, 'fields' => $fields, 'request' => $request]);
    }

    public function load(Request $request)
    {
        $forms = Form::all();
        $fields = Field::where('form_id', $request->form)->with('option')->get();
        return view('panel.poster.create', ['fields' => $fields, 'forms' => $forms, 'request' => $request]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PosterCreateRequest $request)
    {

        $validator = $this->validateTestGroup($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('/files');
        $image->move($path, $filename);
        $mime = $image->getClientMimeType();
        $original_filename = $image->getClientOriginalName();
        $poster = Poster::create([
            'author' => auth()->user()->id,
            'verifier' => auth()->user()->id,
            'type_id' => $request->type_id,
            'title' => $request->title,
            'form_id' => $request->form_id,
            'mobile' => $request->mobile,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'show_mobile' => $request->show_mobile ? '1' :'0',
            'sector_id' => $request->sector_id,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'price' => $request->price,
            'price_month' => $request->price_month,
            'description' => $request->description,
            'mime' => $mime,
            'original_filename' => $original_filename,
            'filename' => $filename,
            'resize_image' => $filename,
        ])->id;

        foreach ($request->field as $key => $value) {
            PosterDetail::create([
                'poster_id' => $poster,
                'form_id' => $request->form_id,
                'field_id' => $key,
                'value' => json_encode($value)
            ]);
        }
        alert()->success('موفق', 'آگهی با موفقیت قرار گرفت');
        return redirect('/panel/poster');
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
        $poster = Poster::where('id', $id)->with('detail.field')->first();
        $types = Type::all();
        $sectors = Sector::all();

        return view('panel.poster.edit', ['poster' => $poster, 'types' => $types, 'sectors' => $sectors]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PosterUpdateRequest $request, $id)
    {

        $validator = $this->validateTestGroup($request);
        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();
        }
        $poster = Poster::where('id', $id)->first();
        $poster->update([
            'type_id' => $request->type_id,
            'title' => $request->title,
            'mobile' => $request->mobile,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'show_mobile' => $request->show_mobile ? '1' :'0',
            'sector_id' => $request->sector_id,
            'price' => $request->price,
            'price_month' => $request->price_month,
            'description' => $request->description,
        ]);

        $image = $request->file('image');
        if ($image) {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('/files');
            $image->move($path, $filename);
            $mime = $image->getClientMimeType();
            $original_filename = $image->getClientOriginalName();
            $poster->update([
                'original_filename' => $original_filename,
                'filename' => $filename,
                'resize_image' => $filename,
            ]);
        }
        $poster = $poster->id;

        foreach ($request->field as $key => $value) {
            $row = PosterDetail::where('poster_id', $poster)
                ->where('field_id', $key)->first();
            $row->update([
                'value' => json_encode($value)
            ]);
        }
        alert()->success('موفق', 'آگهی با موفقیت ویرایش شد');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $row = Poster::find($id);
        $row->delete();
    }

    public function detail($id)
    {
        $poster = Poster::where('id', $id)->with('detail.field')->first();
        return view('panel.poster.modal.detail', ['poster' => $poster])->render();
    }

    public function comment($id)
    {
        $poster = Poster::where('id', $id)->first();
        return view('panel.poster.modal.comment', ['poster' => $poster])->render();
    }

    public function commentUpdate(Request $request)
    {
        $poster = Poster::where('id', $request->id)->first();
        $poster->update(['comment' => $request->comment]);
        alert()->success('d', 'd');
        return back();
    }


    public function map(Request $request)
    {
        $response = Http::withHeaders([
            'Api-Key' => 'service.pYhLm5JfM9Dnv65snZLA4H2CfmRM2Llh2e7I6xH5',
        ])->get('https://api.neshan.org/v1/search?term=' . $request->address . '&lat=' . $request->latitude . '&lng=' . $request->longitude);

        return Reply::successJson('panel.created', $response->json(), '200');

    }

    public function images($id)
    {
        $images = PosterImage::where('poster_id', $id)->get();
        $poster = Poster::find($id);
        return view('panel.poster.images', ['id' => $id, 'images' => $images, 'poster' => $poster]);
    }

    public function image_upload(Request $request)
    {

        $patchfile = $request->file('file');
        $cover = $patchfile;
        $filename = time() . '.' . '.png';
        $path = public_path('/

        /' . $filename);
        Image::make($cover->getRealPath())->resize(800, 550)->save($path);
        $extension = $cover->getClientOriginalExtension();
        $mime = $cover->getClientMimeType();
        $original_filename = $cover->getClientOriginalName();


//  ایجاد یک ردیف برای ذخیره عکس در جدول
        $imag = PosterImage::create([
            'poster_id' => $request->id,
            'mime' => $mime,
            'original_filename' => $original_filename,
            'filename' => $filename,
            'resize_image' => $filename,
        ]);


        return response()->json([
            'id' => $imag->id
        ]);
    }

    public function posterImageDestroy($id)
    {
        $row = PosterImage::find($id);
        $row->delete();
    }

    public function files($id)
    {
        $files = PosterDocument::where('poster_id', $id)->get();
        $poster = Poster::find($id);

        return view('panel.poster.files', ['id' => $id, 'files' => $files, 'poster' => $poster]);
    }


    public function file_upload(Request $request)
    {

        $rows = $this->CvService->file($request->file);

        foreach ($rows as $key => $row) {
            $filename = time() . $key . '.' . $row['file']->getClientOriginalExtension();
            $path = public_path('/files');
            $row['file']->move($path, $filename);
            $mime = $row['file']->getClientMimeType();
            $original_filename = $row['file']->getClientOriginalName();
            PosterDocument::create([
                'poster_id' => $request->poster_id,
                'name' => $row['note'],
                'original_filename' => $original_filename,
                'mime' => $mime,
                'filename' => $filename,
            ]);
        }
        alert()->success('عملیات موفق', 'فایل ها با موفقیت آپلود گردید.');
        return back();
    }

    public function downloadfile($id)
    {
        $book_cover = PosterDocument::where('id', $id)->firstOrFail();
        $path = public_path() . '/files/' . $book_cover->filename;
        return response()->download($path, $book_cover
            ->original_filename, ['Content-Type' => $book_cover->mime]);
    }

    public function posterFileDestroy($id)
    {
        $row = PosterDocument::find($id);
        $row->delete();
    }

    public function favorite($id)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $user->favorite()->attach($id);
        alert()->success('موفق', 'آگهی به لیست علاقمندی های شما افزوده شد.');
        return back();
    }

    public function verify($id)
    {
        $poster = Poster::where('id', $id)->first();
        if ($poster->verify == 1) {
            $verify = 0;
            Alert::info('عملیات موفق', 'پوستر غیر فعال شد.');

        } else {
            $verify = 1;
            Alert::info('عملیات موفق', 'پوستر  فعال شد.');

        }
        $poster->update(['active' => $verify, 'verify' => $verify, 'verifier' => auth()->user()->id]);

        return back();
    }
    public function sold($id)
    {
        $poster = Poster::where('id', $id)->first();
        if ($poster->salled == 1) {
            $salled = 0;
            Alert::info('عملیات موفق', 'آگهی  از حالت فروخته خارج شد.');

        } else {
            $salled = 1;
            Alert::info('عملیات موفق', 'آگهی فروخته  شد.');
        }
        $poster->update([ 'salled' => $salled]);

        return back();
    }

    public
    function validateTestGroup($request)
    {

        $messages = [];
        $rules = [];
        $keys = [];
        foreach ($request->field as $key => $field) {
            $keys[] = $key;
        }
        $fields = Field::whereIn('id', $keys)->where('required', 1)->get();

        foreach ($fields as $key => $field) {

            if (empty($request->all()['field'][$field->id])) {
                $rules[$field->name] = 'required';
                $messages[] = $field->name . ' الزامی است';
            }
        }

        return Validator::make($request->all(), $rules, $messages);
    }
}
