<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        $('#tunnelsTable').DataTable({
            responsive:true,
            processing:true,
            serverSide: true,
            searchDelay:500,
            ajax: {
                url: "{{route('tunnel.index')}}"
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'server', name: 'server.name' },
                { data: 'username', name: 'username' },
                { data: 'domain', name: 'domain' },
                { data: 'api', name: 'api' },
                { data: 'status', name: 'status' },
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
    $('body').on('click', '#btn-hapus-tunnel', async function () {
        const id = $(this).data('id');
        const url = "{{ route('tunnel.destroy', ':slug') }}".replace(':slug', id);
        const result = await Swal.fire({
            title: "Apa kamu yakin?",
            text: "Tunnel remot akan di hapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#485ec4',
            cancelButtonColor: '#d33',
            confirmButtonText: "Ya hapus"
        });
        function tunnelCount(count) {
            $('#tunnelCount').text(count);
        }
        if (result.isConfirmed) {
            const success = await hapusTunnel( url);
            if (success) {
                notifikasi('success', 'Berhasil', 'tunnel remote berhasil di hapus');
                $('#tunnelsTable').DataTable().ajax.reload();
                const tnCount = parseInt($('#tunnelCount').text());
                const newCount = tnCount - 1;
                tunnelCount(newCount);
            } else {
                notifikasi('error', 'Error', 'Tunnel remote gagal di hapus');
            }
        }
    });
    async function hapusTunnel( url) {
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

    $('body').on('click', '.disable-tunnel-status', async function () {
        const id = $(this).data('id');
        const url = "{{ route('tunnel-action.disable-tunnel-remote', ':slug') }}".replace(':slug', id);
        const result = await Swal.fire({
            title: "Apa kamu yakin?",
            text: "Tunnel remot akan di nonaktifkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#485ec4',
            cancelButtonColor: '#d33',
            confirmButtonText: "Ya !!!"
        });

        if (result.isConfirmed) {
            const success = await disableTunnel( url);
            if (success) {
                notifikasi('success', 'Berhasil', 'tunnel remote berhasil di nonaktifkan');
                $('#tunnelsTable').DataTable().ajax.reload();
            } else {
                notifikasi('error', 'Error', 'Tunnel remote gagal di nonaktifkan');
            }
        }
    });
    async function disableTunnel( url) {
        try {
            await $.ajax({
                type: "POST",
                url: url
            });
            return true;
        } catch (error) {
            return false;
        }
    }

    $('body').on('click', '.enable-tunnel-status', async function () {
        const id = $(this).data('id');
        const url = "{{ route('tunnel-action.enable-tunnel-remote', ':slug') }}".replace(':slug', id);
        const result = await Swal.fire({
            title: "Apa kamu yakin?",
            text: "Tunnel remot akan di aktifkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#485ec4',
            cancelButtonColor: '#d33',
            confirmButtonText: "Ya !!!"
        });

        if (result.isConfirmed) {
            const success = await enableTunnel( url);
            if (success) {
                notifikasi('success', 'Berhasil', 'tunnel remote berhasil di aktifkan');
                $('#tunnelsTable').DataTable().ajax.reload();
            } else {
                notifikasi('error', 'Error', 'Tunnel remote gagal di aktifkan');
            }
        }
    });
    async function enableTunnel( url) {
        try {
            await $.ajax({
                type: "POST",
                url: url
            });
            return true;
        } catch (error) {
            return false;
        }
    }
</script>
