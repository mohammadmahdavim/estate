<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\EditionStoreRequest;
use App\Http\Requests\LeaderStoreRequest;
use App\Http\Requests\TeammateStoreRequest;
use App\Models\Book;
use App\Models\BookRole;
use App\Models\Edition;
use App\Models\Editor;
use App\Models\Leader;
use App\Models\Member;
use App\Models\Models\Lesson;
use App\Models\Teammate;
use App\Models\User;
use App\Models\Version;
use App\Services\dateService;
use App\Services\editionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class EditionController extends Controller
{

    public $dateService;
    public $editionService;

    public function __construct(dateService $dateService, editionService $editionService)
    {
        $this->dateService = $dateService;
        $this->editionService = $editionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $productionManager = BookRole::where('value', 'production_manager')->first()->id;

//        $rows = Edition::with(['members' => function ($q) use ($productionManager) {
//            return $q->where('role', $productionManager);
//        }
//        ])->get();

        $rows = Edition::with('productionManager.user', 'book')->get();

        return view('panel.edition.index', compact('rows'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $books = Book::all();
        return view('panel.edition.create', compact('books'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditionStoreRequest $request)
    {
//        $forecast = $this->dateService->slashToTimeStamps($request->forecast);

//        Edition::create([
//            'book_id' => $request->book_id,
//            'type' => $request->type,
//            'pages_count' => $request->pages_count,
//            'questions_count' => $request->questions_count,
//            'forecast' => $request->forecast,
//            'start' => Jalalian::now()->format('Y/m/d'),
//        ]);

        $edition = Edition::create($request->all() + ['start' => Jalalian::now()->format('Y/m/d')]);
        $role = BookRole::where('value', 'production_manager')->first()->id;
        $edition->members()->create([
            'role' => $role,
            'user_id' => auth()->id(),
        ]);

        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return redirect('/panel/editions');
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
    public function edit(Edition $edition)
    {
        $books = Book::all();
        return view('panel.edition.edit', compact('edition', 'books'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditionStoreRequest $request, $id)
    {
        $row = Edition::find($id);
        $row->update($request->all());
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return redirect('/panel/editions'); //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $row = Edition::find($id);
        $row->delete();
    }

    public function detail(Request $request, $id)
    {
        $edition = Edition::find($id);
        $edition->load('productionManager.user', 'book');
        return view('panel.edition.modal.detail', compact('edition'))->render();
    }

    public function comment(Request $request, Edition $edition)
    {
        $edition->load('book');
        return view('panel.edition.modal.comment', compact('edition'))->render();
    }

    public function commentUpdate(CommentRequest $request, Edition $edition)
    {
        $edition->update($request->all());
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return redirect('/panel/editions');
    }

    public function team(Edition $edition)
    {
        $users = User::all();
        $edition->load('teammates.user', 'teammates.bookRole', 'teammates.teammate');
        $roles = BookRole::where('group', 2)->whereNotIn('value', ['production_manager'])->get();
        return view('panel.edition.team', compact('users', 'edition', 'roles'));
    }

    public function teamUpdate(Request $request, Edition $edition)
    {

        $teams = $this->editionService->prepareTeam($request->data);

        foreach ($teams as $team) {
            $member = $edition->members()->create([
                'user_id' => $team['user_id'],
                'role' => $team['role'],
            ]);
            $member->teammate()->create([
                'questions_count' => $team['questions_count'],
                'pages_count' => $team['pages_count'],
                'member_id' => $member->id,
            ]);
        }
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return redirect('/panel/team/' . $edition->id); //
    }

    public function deleteTeam(Request $request, Member $member)
    {
        $member->delete();
    }

    public function leader(Edition $edition)
    {
        $users = User::all();
        $edition->load('leaders.user.university', 'leaders.user.field', 'leaders.leaderRow');
        $lessons = Lesson::all();
        return view('panel.edition.leader', compact('users', 'edition', 'lessons'));
    }

    public function leaderUpdate(Request $request, Edition $edition)
    {
        $role = BookRole::where('value', 'leader')->first();
        $leaders = $this->editionService->prepareTeam($request->data);
        foreach ($leaders as $leader) {
            $member = $edition->members()->create([
                'user_id' => $leader['user_id'],
                'role' => $role->id,
            ]);
            $member->leaderRow()->create([
                'member_id' => $member->id,
                'lesson' => $leader['lesson'],
                'questions_count' => $leader['questions_count'],
                'pages_count' => $leader['pages_count'],
            ]);
        }
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return back(); //
    }

    public function deleteLeader(Request $request, Member $member)
    {
        $member->delete();
    }

    public function leaderTiming(Request $request, Leader $leader)
    {
        return view('panel.edition.modal.leaderTiming', compact('leader'))->render();
    }

    public function leaderTimingUpdate(Request $request, Leader $leader)
    {

        $leader->update([
            'color' => $request->color,
            'entry_date' => $request->entry_date,
            'delivery_date' => $request->delivery_date,
        ]);
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return back(); //
    }

    public function leaderIncorrect(Request $request, Leader $leader)
    {
        return view('panel.edition.modal.leaderIncorrect', compact('leader'))->render();
    }

    public function leaderIncorrectUpdate(Request $request, Leader $leader)
    {
        $leader->update($request->all());
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return back(); //
    }

    public function leaderComment(Request $request, Member $member)
    {
        $member->load('leaderRow');

        return view('panel.edition.modal.leaderComment', compact('member'))->render();
    }

    public function leaderCommentUpdate(Request $request, Leader $leader)
    {
        $leader->update([
            'text_book_comment' => $request->text_book_comment,
            'quality_comment' => $request->quality_comment,
            'answer_comment' => $request->answer_comment,
            'introduction_comment' => $request->introduction_comment,
        ]);
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return back();
    }

    public function editor($id)
    {
        $users = User::all();
        $editors = Editor::where('leader_id', $id)->with('user')->with('user.university')->with('user.field')->get();
        $edition = Leader::where('id', $id)->pluck('edition_id')->first();
        $lessons = Lesson::all();

        return view('panel.edition.editor', ['users' => $users, 'id' => $id, 'editors' => $editors, 'edition' => $edition, 'lessons' => $lessons]);
    }

    public function editorUpdate(Request $request)
    {

        $editors = $this->editionService->prepareTeam($request->data);
        foreach ($editors as $editor) {
            Editor::create([
                'editor' => $editor['user_id'],
                'lesson' => $editor['lesson'],
                'section' => $editor['section'],
                'questions_count' => $editor['questions_count'],
                'pages_count' => $editor['pages_count'],
                'leader_id' => $request->leader_id,
            ]);
        }
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return back(); //
    }

    public function deleteEditor(Request $request, $id)
    {
        $row = Editor::find($id);
        $row->delete();
    }


    public function version($id)
    {

        $versions = Version::where('leader_id', $id)->orderby('version', 'asc')->get();
        $edition = Leader::where('id', $id)->pluck('edition_id')->first();
        return view('panel.edition.version', ['id' => $id, 'versions' => $versions, 'edition' => $edition]);
    }

    public function versionUpdate(Request $request)
    {

        $versions = $this->editionService->prepareTeam($request->data);
        foreach ($versions as $version) {
            $entry = $this->dateService->slashToTimeStamps($version['entry_date']);
            $delivery = $this->dateService->slashToTimeStamps($version['delivery_date']);
            $versionCounter = Version::where('leader_id', $request->leader_id)->count();
            Version::create([
                'version' => $versionCounter + 1,
                'entry_date' => $entry,
                'delivery_date' => $delivery,
                'leader_id' => $request->leader_id,
            ]);
        }
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return back(); //
    }

    public function deleteVersion(Request $request, $id)
    {
        $row = Version::find($id);
        $row->delete();
    }

    public function incorrectEditor(Request $request, $id)
    {

        $row = Editor::where('id', $id)->with('user')->with('user.university')->with('user.field')->first();

        return view('panel.edition.modal.editorIncorrect', ['row' => $row])->render();
    }

    public function incorrectEditorUpdate(Request $request)
    {
        $row = Editor::find($request->leader);
        $row->update([
            'taken_incorrect1_count' => $request->taken_incorrect1_count,
            'taken_incorrect2_count' => $request->taken_incorrect2_count,
            'taken_incorrect3_count' => $request->taken_incorrect3_count,
            'taken_incorrect_Structure_count' => $request->taken_incorrect_Structure_count,
            'not_taken_incorrect1_count' => $request->not_taken_incorrect1_count,
            'not_taken_incorrect2_count' => $request->not_taken_incorrect2_count,
            'not_taken_incorrect3_count' => $request->not_taken_incorrect3_count,
            'not_taken_incorrect_Structure_count' => $request->not_taken_incorrect_Structure_count,
        ]);
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return back(); //
    }

    public function colorEditor(Request $request, $id)
    {

        $row = Editor::where('id', $id)->with('user')->with('user.university')->with('user.field')->first();

        return view('panel.edition.modal.editorcolor', ['row' => $row])->render();
    }

    public function colorEditorUpdate(Request $request)
    {

        $row = Editor::find($request->editor);

        $row->update([
            'color_quality' => $request->color_quality,
            'color_timing' => $request->color_timing,
            'color_write_evaluation' => $request->color_write_evaluation,
        ]);
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return back(); //
    }

    public function commentEditor(Request $request, $id)
    {

        $row = Editor::where('id', $id)->with('user')->with('user.university')->with('user.field')->first();

        return view('panel.edition.modal.editorcomment', ['row' => $row])->render();
    }

    public function commentEditorUpdate(Request $request)
    {

        $row = Editor::find($request->editor);

        $row->update([
            'text_book_comment' => $request->text_book_comment,
            'quality_comment' => $request->quality_comment,
            'answer_comment' => $request->answer_comment,
            'introduction_comment' => $request->introduction_comment,
        ]);
        alert()->success('عملیات با موفقیت انجام شد.', 'عملیات موفق');
        return back(); //
    }

}
