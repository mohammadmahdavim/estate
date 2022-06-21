<div class="modal-header bg-primary white">
    <h5 class="modal-title" id="myModalLabel17">
        کامنت برای {{$row->name}}
        {{$row->family}}

    </h5>
    <button type="button" class="close"
            data-dismiss="modal"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div
                class="headings d-flex justify-content-between align-items-center mb-3">
            </div>
            @foreach($row->AdminDocument as $key=>$comment)
                <div class="card p-3 mt-2">
                    <div
                        class="d-flex justify-content-between align-items-center">
                        <div
                            class="user d-flex flex-row align-items-center">
                                                                                <span>
                                                                                    <span width="30"
                                                                                          class="user-img rounded-circle mr-2">{{$key+1}}

                                                                                        .</span>
                                                                                    <small
                                                                                        class="font-weight-bold text-primary">{{$comment->authorComment->name}}&nbsp;{{$comment->authorComment->family}}</small> <small
                                                                                        class="font-weight-bold">{{$comment->title}}</small></span>
                        </div>
                        <small>{{ \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime(\Carbon\Carbon::parse($comment['created_at'])->toDateString()))}}</small>
                    </div>
                    <div
                        class="action d-flex justify-content-between mt-2 align-items-center">
                        <div class="reply px-4">
                            {!! $comment->body !!}

                        </div>
                        <div class="icons align-items-center">
                            <i class="icon-download"></i>
                            <i class="livicon-evo"
                               data-options="name: {{$comment->type->icon}}.svg; size:30px; style: original;"></i>
                            <x-destroy :id="$comment->id" url="'/panel/comment/destroy'"/>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="/panel/comment/store" method="post">
                @csrf
                <input type="hidden" name="poster_id"
                       value="{{$row->id}}">
                <h4 style="text-align: center">کامنت جدید</h4>
                <div class="row">
                    <div class="col-md-6">
                        <label>دسته بندی</label>
                        <select class="form-control" name="type_id">
                            @foreach($types as $type)
                                <option value="{{$type->id}}">
                                    {{$type->title}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>عنوان</label>
                        <input class="form-control" name="title"
                               required>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <label style="text-align: right">توضیحات</label>
                        <textarea rows="4" cols="90"
                                  name="body"></textarea>

                    </div>
                    <button class="btn btn-block btn-info">ثبت</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/../../assets/vendors/js/vendors.min.js"></script>
<script src="/../../assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js"></script>
<script src="/../../assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
<script src="/../../assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>


