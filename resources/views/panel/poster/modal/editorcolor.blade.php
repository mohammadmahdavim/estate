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
    <form method="post" action="/panel/editions/update/colorEditor">
        <input hidden value="{{$row->id}}" name="editor">
        @csrf

        <h5>رنگ دهی</h5>

        <div class="row">
            <div class="col-md-4"><label>کیفیت کار ویراستار</label>
                <select class="form-control" name="color_quality">
                    <option value="1" @if($row->color_quality==1) selected @endif >آبی</option>
                    <option value="2" @if($row->color_quality==2) selected @endif >سبز</option>
                    <option value="3" @if($row->color_quality==3) selected @endif >زرد</option>
                    <option value="4" @if($row->color_quality==4) selected @endif >قرمز</option>
                </select>
            </div>
            <div class="col-md-4"><label>ارسال به موقغ</label>
                <select class="form-control" name="color_timing">
                    <option value="1" @if($row->color_timing==1) selected @endif >آبی</option>
                    <option value="2" @if($row->color_timing==2) selected @endif >سبز</option>
                    <option value="3" @if($row->color_timing==3) selected @endif >زرد</option>
                    <option value="4" @if($row->color_timing==4) selected @endif >قرمز</option>
                </select>
            </div>
            <div class="col-md-4"><label>نوشتن ارزیابی</label>
                <select class="form-control" name="color_write_evaluation">
                    <option value="1" @if($row->color_write_evaluation==1) selected @endif >آبی</option>
                    <option value="2" @if($row->color_write_evaluation==2) selected @endif >سبز</option>
                    <option value="3" @if($row->color_write_evaluation==3) selected @endif >زرد</option>
                    <option value="4" @if($row->color_write_evaluation==4) selected @endif >قرمز</option>
                </select>
            </div>


        </div>
        <div class="col-md-12">
            <br>
            <button class="btn btn-block btn-success">ثبت</button>
        </div>

</form>
</div>

