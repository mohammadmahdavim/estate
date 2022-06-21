<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\AdminDocument;
use App\Models\Poster;
use App\Models\TypeDocument;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($id)
    {
        $row = Poster::where('id', $id)
            ->with('AdminDocument')
            ->first();
        $types = TypeDocument::all();
        return view('panel.poster.modal.comment', ['row' => $row, 'types' => $types])->render();

    }

    public function store(Request $request)
    {
        AdminDocument::create([
            'author' => auth()->user()->id,
            'poster_id' => $request->poster_id,
            'type_id' => $request->type_id,
            'title' => $request->title,
            'body' => $request->body,
        ]);
        alert('عملیات موفق', 'عملیات با موفقیت انجام شد');
        return back();
    }

    public function destroy($id)
    {
        $row = AdminDocument::find($id);
        $row->delete();
    }
}
