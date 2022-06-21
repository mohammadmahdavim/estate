@foreach($fields as $key=>$field)
    <tr class="row1" data-id="{{ $field->id }}" id="tr_{{$field->id}}">

        <td>
            <span>
                <a href="" class="update_name" data-name="fieldname" data-pk="{{$field->id}}"
                   data-type="text"
                   data-title="نام فارسی کلید را وارد نمایید."> {{$field->name}}</a>
            </span>
        </td>
        <td>{{$field->description}}</td>

        <td>

            <div class="parent-switcher">
                <label class="ui-statusswitcher">
                    <input type="checkbox" id="switcher-required-{{$field->id}}"
                           onclick="requiredswitcher('{{$field->id}}');"
                           @if($field->required == 1) checked @endif>
                    <span class="ui-statusswitcher-slider">
                                                <span class="ui-statusswitcher-slider-toggle"></span>
                                            </span>
                </label>
            </div>

        </td>

        <td>

            <div class="parent-switcher">
                <label class="ui-statusswitcher">
                    <input type="checkbox" id="switcher-{{$field->id}}"
                           onclick="statusswitcher('{{$field->id}}');"
                           @if($field->active == 1) checked @endif>
                    <span class="ui-statusswitcher-slider">
                                                <span class="ui-statusswitcher-slider-toggle"></span>
                                            </span>
                </label>
            </div>

        </td>
        <td>
            <select class="form-control" name="type" id="type-field-{{$field->id}}"
                    onchange="typeFieldChange('{{$field->id}}')">
                @foreach($options as $key => $option )
                    <option @if($key == $field->type) selected @endif value="{{$key}}">{{$option}}</option>
                @endforeach
            </select>
        </td>


        <td>
            <a href="{{url('/panel/fields_id/'.$field->id.'')}}" class="" title="ویرایش"> <i class="livicon-evo"
                                                                                             data-options="name: pen.svg; size:30px; style: original: 0.05em;"></i></a>
            <a href="{{url('/panel/fields_options/'.$field->id)}}" class="" title="گزینه ها"> <i class="livicon-evo"
                                                                                                 data-options="name: thumbnails-big.svg; size:30px; style: original: 0.05em;"></i></a>
            <x-destroy :id="$field->id" url="'/panel/fields/fieldsDestroy'"/>

        </td>
    </tr>
@endforeach
