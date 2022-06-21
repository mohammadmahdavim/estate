<div class="modal-header bg-info white">
    <h5 class="modal-title" id="myModalLabel17">
        مسول درس:
        {{$leader->user->first_name}}&nbsp;{{$leader->user->last_name}}
    </h5>
    <button type="button" class="close"
            data-dismiss="modal"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form method="post" action="/panel/editions/leaderIncorrect/{{$leader->id}}/update">
        @csrf
        <div class="row">
            <div class="col-md-4"><label>اشکال نوع ۱</label><input type="number" class="form-control"
                                                                   name="incorrect1_count"
                                                                   value="{{$leader->incorrect1_count}}"></div>
            <div class="col-md-4"><label>اشکال نوع ۲</label><input type="number" class="form-control"
                                                                   name="incorrect2_count"
                                                                   value="{{$leader->incorrect2_count}}"></div>
            <div class="col-md-4"><label>اشکال نوع ۳</label><input type="number" class="form-control"
                                                                   name="incorrect3_count"
                                                                   value="{{$leader->incorrect3_count}}"></div>
            <div class="col-md-4"><label>اشکال ساختاری</label><input type="number" class="form-control"
                                                                     name="incorrect_structure_count"
                                                                     value="{{$leader->incorrect_structure_count}}">
            </div>


            <div class="col-md-12">
                <br>
                <button class="btn btn-block btn-success">ثبت</button>
            </div>
        </div>
    </form>
</div>

