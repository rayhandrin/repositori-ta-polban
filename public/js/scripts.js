$(document).ready(function() {
    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Anda yakin menghapus?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#3085d6',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).parent().submit();
            }
        })
    });
});