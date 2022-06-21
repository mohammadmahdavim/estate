<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Contact;
use App\Models\Question;
use Illuminate\Http\Request;
use function Symfony\Component\String\b;

class SiteController extends Controller
{
    public function about()
    {
        $row = About::where('id', 1)->first();
        return view('panel.home.about', ['row' => $row]);
    }

    public function storeAbout(Request $request)
    {
        $row = About::where('id', 1)->first();
        $row->update([
            'title' => $request->title,
            'body' => $request->body,
            'privacy' => $request->privacy,
        ]);
        alert()->success('عملیات شما با موفقیت انجام شد.', 'عملیات موفق');

        return back();
    }

    public function questions()
    {
        $rows = Question::all();
        return view('panel.home.questions', ['rows' => $rows]);
    }


    public function storeQuestions(Request $request)
    {
        Question::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        alert()->success('عملیات شما با موفقیت انجام شد.', 'عملیات موفق');

        return back();
    }

    public function deleteQuestions($id)
    {
        $row = Question::where('id', $id)->first();
        $row->delete();
        return back();
    }


    public function contacts()
    {
        $rows = Contact::all();
        return view('panel.home.contacts', ['rows' => $rows]);
    }

    public function activeContacts($id)
    {
        $row = Question::where('id', $id)->first();
        $row->delete();
        return back();
    }
}
