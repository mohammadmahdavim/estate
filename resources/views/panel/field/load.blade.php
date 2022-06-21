@foreach($options as $key=>$option)
    <tr class="row1" data-id="{{ $option->id }}" id="tr_{{$option->id}}">


        <td>
            <span>
              {{$option->value}}
            </span>
        </td>
        <td>
            <span>
              {{$option->code}}
            </span>
        </td>

        <td>

            <div class="parent-switcher">
                <label class="ui-statusswitcher">
                    <input type="checkbox" id="switcher-{{$option->id}}"
                           onclick="statusswitcher('{{$option->id}}');"
                           @if($option->active == 1) checked @endif>
                    <span class="ui-statusswitcher-slider">
                                                <span class="ui-statusswitcher-slider-toggle"></span>
                                            </span>
                </label>
            </div>

        </td>


        <td>
            <x-destroy :id="$option->id" url="'/panel/options/optionsDestroy'"/>
        </td>
    </tr>
@endforeach


