<div class="modal-header bg-info white">
    <h5 class="modal-title" id="myModalLabel17">
        ویراستار:
        {{$row->user->first_name}}&nbsp;{{$row->user->last_name}}
    </h5>
    <button type="button" class="close"
            data-dismiss="modal"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form method="post" action="/panel/editions/update/commentEditor">
        <input hidden value="{{$row->id}}" name="editor">
        @csrf

        <h5>کامنت ویراستار</h5>

        <div class="row">
            <div class="col-md-12"><label>درس نامه</label><input type="text" class="form-control" name="text_book_comment"
                                                                 value="{{$row->text_book_comment}}"></div>
            <div class="col-md-12"><label>پوشش مطالب</label><input type="text" class="form-control" name="quality_comment"
                                                                   value="{{$row->quality_comment}}"></div>
            <div class="col-md-12"><label>پاسخ تشریحی</label><input type="text" class="form-control" name="answer_comment"
                                                                    value="{{$row->answer_comment}}"></div>
            <div class="col-md-12"><label>معرفی کتاب</label><input type="text" class="form-control" name="introduction_comment"
                                                                   value="{{$row->introduction_comment}}"></div>
        </div>
        <div class="col-md-12">
            <br>
            <button class="btn btn-block btn-success">ثبت</button>
        </div>

</form>
</div>

