
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
    <form method="post" action="/panel/editions/update/incorrectEditor">
        <input hidden value="{{$row->id}}" name="leader">
        @csrf
        <h5>اشکالات گرفته شده</h5>
        <div class="row">
            <div class="col-md-3"><label>اشکال نوع۱</label><input type="number" class="form-control" name="taken_incorrect1_count"
                                                                  value="{{$row->taken_incorrect1_count}}"></div>
            <div class="col-md-3"><label>اشکال نوع۲</label><input type="number" class="form-control" name="taken_incorrect2_count"
                                                                  value="{{$row->taken_incorrect2_count}}"></div>
            <div class="col-md-3"><label>اشکال نوع۳</label><input type="number" class="form-control" name="taken_incorrect3_count"
                                                                  value="{{$row->taken_incorrect3_count}}"></div>
            <div class="col-md-3"><label>اشکال ساختاری</label><input type="number" class="form-control"
                                                                     name="taken_incorrect_Structure_count"
                                                                     value="{{$row->taken_incorrect_Structure_count}}"></div>

        </div>
        <br>
        <h5>اشکالات گرفته نشده</h5>

        <div class="row">
            <div class="col-md-3"><label>اشکال نوع۱</label><input type="number" class="form-control" name="not_taken_incorrect1_count"
                                                                  value="{{$row->not_taken_incorrect1_count}}"></div>
            <div class="col-md-3"><label>اشکال نوع۲</label><input type="number" class="form-control" name="not_taken_incorrect2_count"
                                                                  value="{{$row->not_taken_incorrect2_count}}"></div>
            <div class="col-md-3"><label>اشکال نوع۳</label><input type="number" class="form-control" name="not_taken_incorrect3_count"
                                                                  value="{{$row->not_taken_incorrect3_count}}"></div>
            <div class="col-md-3"><label>اشکال ساختاری</label><input type="number" class="form-control"
                                                                     name="not_taken_incorrect_Structure_count"
                                                                     value="{{$row->not_taken_incorrect_Structure_count}}"></div>

        </div>
            <div class="col-md-12">
                <br>
                <button class="btn btn-block btn-success">ثبت</button>
            </div>
        </div>
    </form>
</div>

