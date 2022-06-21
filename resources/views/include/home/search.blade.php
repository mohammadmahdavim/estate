<link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/pickers/pickadate/pickadate.css">
<link rel="stylesheet" type="text/css" href="/../../assets/vendors/css/pickers/daterange/daterangepicker.css">
<script src="/../../assets/vendors/js/pickers/datepicker-jalali/bootstrap-datepicker.min.js"></script>
<script
    src="/../../assets/vendors/js/pickers/datepicker-jalali/bootstrap-datepicker.fa.min.js"></script>
<link rel="stylesheet" type="text/css"
      href="/../../assets/vendors/css/pickers/datepicker-jalali/bootstrap-datepicker.min.css">


<div id="search_box" class="row">
    @foreach($items as $key=>$field)

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="form-group none">
                <label>

                    {{$field->name}}
                    @if($field->required)
                        <span
                            style="color: red">*</span>
                    @endif
                </label>
                @switch($field->type)

                    @case('text')
                    <input type="text" name="field[{{$field->id}}]"
                           class="form-control"

                           value="{{(isset($details[$key]) ? $details[$key]->field_value : old('field'.$field->id))}}">

                    @break
                    @case('time')
                    <input type="text" name="field[{{$field->id}}]"
                           class="form-control pickatime "

                           value="{{(isset($details[$key]) ? $details[$key]->field_value : old('field'.$field->id))}}">


                    @break
                    @case('date')
                    <fieldset
                        class="form-group position-relative has-icon-left">
                        <input autocomplete="off" required type="text"
                               @if($field->required)
                               required
                               @endif
                               name="field[{{$field->id}}]"
                               class="form-control shamsi-datepicker-list"
                               placeholder="انتخاب تاریخ" readonly
                               value="{{old('forecast')}}">


                        <div class="form-control-position">
                            <i class="bx bx-calendar"></i>
                        </div>
                    </fieldset>

                    @break

                    @case('number')
                    <input type="number" name="field[{{$field->id}}]"

                           value="{{(isset($details[$key]) ? $details[$key]->field_value : old('field'.$field->id))}}"
                           class="form-control">


                    @break

                    @case('textarea')
                    <textarea class="ckeditor form-control"
                              name="field[{{$field->id}}]"
                              rows="3">{{(isset($details[$key]) ? $details[$key]->field_value : old('field'.$field->id))}}</textarea>


                    @break

                    @case('select')
                    <select class="select" name="field[{{$field->id}}]">
                        <option value="">انتخاب کنید</option>
                        @foreach($options = $field->option()->active()->get() as $option)
                            <option value="{{$option->value}}"
                                    @if(isset($details[$key]) && $option->value == $details[$key]->field_value) selected @endif>{{$option->value}}</option>
                        @endforeach


                    </select>
                    @break

                    @case('multi-select')
                    <select id="location" name="sector_id[]" multiple class="">
                        @foreach($options = $field->option()->active()->get() as $option)
                            <option value="{{$option->value}}">
                                {{$option->value}}
                            </option>
                        @endforeach

                    </select>


                    @break

                @endswitch
            </div>
        </div>

    @endforeach
</div>

<!-- /row -->
