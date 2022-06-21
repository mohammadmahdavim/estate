
<div id="fields">
    <form id="contact-data" class="form-horizonal" onsubmit="return false;">
        <p class="text-center">اطلاعات تماس</p>
        <div class="row">

            @php($i = 0)
            @foreach($fields as $key => $field )

                <div class="col-md-1">
                    <br>
                    <br>
                    <span>
                        {{$field->name}} @if($field->required) <span
                            style="color: red">*</span> @endif
                    </span>
                </div>
                <div class="col-md-11">
                    <br>
                    <br>
                    @switch($field->type)

                        @case('text')
                        <input type="text" name="field_{{$key}}" class="form-control"
                               value="{{(isset($details[$key]) ? $details[$key]->field_value : '')}}">
                        @break

                        @case('date')
                        <fieldset class="form-group position-relative has-icon-left">
                            <input autocomplete="off" required type="text" name="forecast"
                                   class="form-control shamsi-datepicker-list"
                                   placeholder="انتخاب تاریخ" readonly
                                   value="{{old('forecast')}}">
                            <div class="form-control-position">
                                <i class="bx bx-calendar"></i>
                            </div>
                        </fieldset>
                        <input class="shamsi-datepicker-list" type="text" name="field_{{$key}}"
                               data-mddatetimepicker="true"
                               data-placement="right">
                        @break

                        @case('number')
                        <input type="text" name="field_{{$key}}"
                               value="{{(isset($details[$key]) ? $details[$key]->field_value : '')}}"
                               class="touchspin-empty">
                        @break

                        @case('textarea')
                        <textarea class="form-control" name="field_{{$key}}"
                                  rows="3">{{(isset($details[$key]) ? $details[$key]->field_value : '')}}</textarea>
                        @break

                        @case('select')
                        <select class="select" name="field_{{$key}}">
                            <option value="">انتخاب کنید</option>
                            @foreach($options = $field->option()->active()->get() as $option)
                                <option value="{{$option->value}}"
                                        @if(isset($details[$key]) && $option->value == $details[$key]->field_value) selected @endif>{{$option->value}}</option>
                            @endforeach
                        </select>
                        @break

                        @case('multi-select')
                        <select class="select-multiple-tags" name="field_{{$key}}[]"
                                multiple>
                            @foreach($options = $field->option()->active()->get() as $option)
                                <option value="{{$option->value}}"
                                        @if(isset($details[$key]) && in_array($option->value,explode(',',$details[$key]->field_value))) selected @endif>{{$option->value}}</option>
                            @endforeach
                        </select>
                        @break

                    @endswitch
                </div>


            @endforeach

        </div>
    </form>
</div>


