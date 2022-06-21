<div class="modal fade text-left" id="modal-show"
     tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content" id="modal-show-content">


        </div>

    </div>
</div>

<script>

    modal_show = function (id, url) {
        $('#loading').show();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: url + '/' + id ,
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function (response) {
                $('#modal-show-content').empty().html(response);
                $('#modal-show').modal('show');
                $('#loading').hide();


            },
            error: function (xhr) {
                $('#loading').hide();
            }
        });
    }

</script>
