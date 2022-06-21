<link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/pickers/pickadate/pickadate.css">
<link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/pickers/daterange/daterangepicker.css">
<link rel="stylesheet" type="text/css"
      href="/../../assets/vendors/css/pickers/datepicker-jalali/bootstrap-datepicker.min.css">
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
    <form method="post" action="/panel/editions/leaderTiming/{{$leader->id}}/update">
        @csrf
        <div class="row">
            <div class="col-md-4"><label>تاریخ ورود</label>
                <fieldset class="form-group position-relative has-icon-left">
                    <input autocomplete="off" type="text" name="entry_date" class="form-control shamsi-datepicker-list"
                           value="{{$leader->entry_date}}"
                           placeholder="انتخاب تاریخ">
                    <div class="form-control-position">
                        <i class="bx bx-calendar"></i>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-4"><label>تاریخ تحویل</label>
                <fieldset class="form-group position-relative has-icon-left">
                    <input autocomplete="off" type="text" name="delivery_date" class="form-control shamsi-datepicker-list"
                           value="{{$leader->delivery_date}}"
                           placeholder="انتخاب تاریخ">
                    <div class="form-control-position">
                        <i class="bx bx-calendar"></i>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-4"><label>رنگ دهی</label>
                <select class="form-control" name="color">
                    <option value="1">آبی</option>
                    <option value="2">سبز</option>
                    <option value="3">زرد</option>
                    <option value="4">قرمز</option>
                </select>
            </div>

            <div class="col-md-12">
                <br>
                <button class="btn btn-block btn-success">ثبت</button>
            </div>
        </div>
    </form>
</div>
<script src="/../../assets/vendors/js/pickers/pickadate/picker.js"></script>
<script src="/../../assets/vendors/js/pickers/pickadate/picker.date.js"></script>
<script src="/../../assets/vendors/js/pickers/pickadate/picker.time.js"></script>
<script src="/../../assets/vendors/js/pickers/pickadate/legacy.js"></script>
<script src="/../../assets/vendors/js/pickers/daterange/moment.min.js"></script>
<script src="/../../assets/vendors/js/pickers/daterange/daterangepicker.js"></script>
<script src="/../../assets/vendors/js/pickers/datepicker-jalali/bootstrap-datepicker.min.js"></script>
<script
    src="/../../assets/vendors/js/pickers/datepicker-jalali/bootstrap-datepicker.fa.min.js"></script>
<!-- END: Theme JS-->
<script src="/../../assets/js/scripts/pickers/dateTime/pick-a-datetime.js"></script>
<!-- END: Page Vendor JS-->
