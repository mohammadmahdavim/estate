<div class="modal-header bg-primary white">
    <h5 class="modal-title" id="myModalLabel17">
        اطلاعات آکهی
    </h5>
    <button type="button" class="close"
            data-dismiss="modal"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table>
        <tr>
            @foreach($poster->detail as $detail)
                <td style="color: black"> {{$detail->field->name}}:</td>
                <td>
                    &nbsp;
                    &nbsp;
                    @if($detail->field->type=='multi-select')

                        @foreach(json_decode($detail->value) as $value)
                            {{$value}}
                            ,
                        @endforeach
                    @elseif($detail->field->type=='textarea')
                        {!! json_decode($detail->value) !!}
                    @else
                        {{json_decode($detail->value)}}
                    @endif
                </td>
        </tr>
        @endforeach
    </table>
</div>
