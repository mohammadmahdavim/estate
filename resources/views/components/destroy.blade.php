
<!-- END: Page CSS-->
<span onclick="deleteData({{$url}},{{$id}})">
<a  title="حذف">
      <i class="livicon-evo" data-options="name: trash.svg; size:30px; style: original;"></i>
</a>
</span>

<script>
    function deleteData(url, id) {

        swal.fire({
            title: "آیا از حذف مطمئن هستید؟",
            text: "اگر حذف شود تمام دیتای مرتبط با آن حذف می گردد!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: "حذف شود!",
            cancelButtonText: "لغو",
        })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url + '/' + id,
                        type: "GET",

                        success: function () {
                            swal.fire({
                                title: "عملیات موفق",
                                text: "عملیات حذف با موفقیت انجام گردید",
                                icon: "success",
                                timer: '3500'

                            });
                            window.location.reload(true);
                        },
                        error: function () {
                            swal.fire({
                                title: "خطا...",
                                // text: data.message,
                                type: 'error',
                                timer: '3500'
                            })

                        }
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swal.fire(
                        'لغو',
                        'عملیات لغو گردید:)',
                        'error'
                    )
                }
            });

    }

</script>

