<div class="modal-header bg-info white">
    <h5 class="modal-title" id="myModalLabel17">

        مسئول درس:
        {{$member->user->first_name}}&nbsp;{{$member->user->last_name}}
    </h5>
    <button type="button" class="close"
            data-dismiss="modal"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form method="post" action="/panel/editions/leaderComment/update/{{$member->leaderRow->id}}">
        @csrf
        <h5>کامنت مسئول درس</h5>

        <div class="row">
            <div class="col-md-12 mb-2"><label>درس نامه</label>
                <textarea name="text_book_comment"
                          class="form-control">{!! $member->leaderRow->text_book_comment ?? '' !!}</textarea>
            </div>

            <div class="col-md-12 mb-2"><label>پوشش مطالب</label>
                <textarea name="quality_comment"
                          class="form-control">{!! $member->leaderRow->quality_comment ?? '' !!}</textarea>
            </div>
            <div class="col-md-12 mb-2"><label>پاسخ تشریحی</label>
                <textarea name="answer_comment"
                          class="form-control">{!! $member->leaderRow->answer_comment ?? '' !!}</textarea>
            </div>
            <div class="col-md-12 mb-2"><label>معرفی کتاب</label>
                <textarea name="introduction_comment"
                          class="form-control">{!! $member->leaderRow->introduction_comment ?? '' !!}</textarea>
            </div>

            <div class="col-md-12">
                <br>
                <button class="btn btn-block btn-success">ثبت</button>
            </div>
        </div>
    </form>
</div>

