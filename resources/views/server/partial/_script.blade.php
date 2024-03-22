<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        $('#serversTable').DataTable({
            responsive:true,
            processing:true,
            serverSide: true,
            searchDelay:500,
            ajax: {
                url: "{{route('server.index')}}"
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'domain', name: 'domain' },
                { data: 'host', name: 'host' },
                { data: 'port', name: 'port' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
    $(document).on('click', '#check-online', function(e) {
        e.preventDefault();
        const selectedRouterId = $(this).data('id');
        const url = "{{ route('check-online', ':id') }}".replace(':id', selectedRouterId);
        $.ajax({
            url: url,
            method: "POST",
            cache: false,
            data: {
                'id':selectedRouterId,
            },
            success: function(response) {
                new Notify({
                    status: response.status,
                    title: response.title,
                    text: response.message,
                    effect: 'slide',
                    speed: 500,
                    showCloseButton: true,
                    autotimeout: 5000,
                    autoclose: true
                });
            },
            error: function(data) {
                new Notify({
                    status: 'error',
                    title: 'Gagal terkoneksi!',
                    text: data.responseJSON && data.responseJSON.message ? data.responseJSON.message : 'Terjadi kesalahan',
                    effect: 'slide',
                    speed: 500,
                    showCloseButton: true,
                    autotimeout: 5000,
                    autoclose: true
                });
            }
        });
    });
    function notifikasi(status, title, text) {
        new Notify({
            status: status,
            title: title,
            text: text,
            effect: 'slide',
            speed: 500,
            showCloseButton: true,
            autotimeout: 5000,
            autoclose: true,
        });
    }
    $('body').on('click', '#btn-hapus-server', async function () {
        const id = $(this).data('id');
        const url = "{{ route('server.destroy', ':slug') }}".replace(':slug', id);
        const result = await Swal.fire({
            title: "Apa kamu yakin?",
            text: "Server akan di hapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#485ec4',
            cancelButtonColor: '#d33',
            confirmButtonText: "Ya hapus"
        });
        function routerCount(count) {
            $('#routerCount').text(count);
        }
        if (result.isConfirmed) {
            const success = await hapusRouter( url);
            if (success) {
                notifikasi('success', 'Berhasil', 'router server berhasil di hapus');
                $('#serversTable').DataTable().ajax.reload();
                const rCount = parseInt($('#routerCount').text());
                const newCount = rCount - 1;
                routerCount(newCount);
            } else {
                notifikasi('error', 'Error', 'Router server gagal di hapus');
            }
        }
    });
    async function hapusRouter( url) {
        try {
            await $.ajax({
                type: "DELETE",
                url: url
            });
            return true;
        } catch (error) {
            return false;
        }
    }
</script>
