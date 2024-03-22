<div id="editMikrotikServerModal" class="modal fade" tabindex="-1" aria-labelledby="editMikrotikServerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editMikrotikServerForm" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMikrotikServerModalLabel">{{__('Edit Mikrotik Server')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editServerName">{{ __('Nama Mikrotik Server') }}</label>
                        <input
                            class="form-control"
                            id="editServerName" name="name" type="text"
                            placeholder="{{ __('Nama Mikrotik Server') }}" value="{{ old('name') }}"
                        >
                        <div id="error_editServerName"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editDomainServer">{{ __('DNS Server Mikrotik') }}</label>
                        <input
                            class="form-control"
                            id="editDomainServer" name="domain" type="text"
                            placeholder="{{ __('id1.mikrotikbot.com') }}" value="{{ old('domain') }}"
                        >
                        <div id="error_editDomainServer"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editHostServer">{{ __('Host Ip Server Mikrotik') }}</label>
                        <input
                            class="form-control"
                            id="editHostServer" name="host" type="text"
                            placeholder="{{ __('192.168.88.1') }}" value="{{ old('host') }}"
                        >
                        <div id="error_editHostServer"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editUsernameServer">{{ __('Username') }}</label>
                        <input
                            class="form-control"
                            id="editUsernameServer" name="username" type="text" placeholder="{{ __('admin') }}"
                            value="{{ old('username') }}"
                        >
                        <div id="error_editUsernameServer"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editPasswordServer">{{ __('Password') }}</label>
                        <div class="input-group">
                            <input
                                class="form-control"
                                id="editPasswordServer"
                                name="password"
                                type="password"
                                placeholder="{{ __('********') }}"
                                value="{{ old('password') }}"
                            >
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="editTogglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="error_editPasswordServer"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editPortServer">{{ __('Port') }}</label>
                        <input
                            class="form-control"
                            id="editPortServer" name="port" type="number" placeholder="{{ __('8728') }}"
                            value="{{ old('port') }}"
                        >
                        <div id="error_editPortServer"></div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="editTestConnection">
                                <label class="form-check-label" for="editTestConnection">
                                    <i class="mdi mdi-connection"></i> {{ __('Tes Koneksi') }}
                                </label>
                            </div>
                            <div id="badge-connected" class="d-none"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{__('Batal')}}</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light simpan-edit-server">{{__('Simpan')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@pushonce('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editTogglePassword = document.querySelector('#editTogglePassword');
            const editPasswordInput = document.querySelector('#editPasswordServer');

            editTogglePassword.addEventListener('click', function () {
                const type = editPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                editPasswordInput.setAttribute('type', type);
            });
        });

        $('#editTestConnection').on('click', function(e) {
            if (e.currentTarget.checked) {
                const host = $('#editHostServer').val();
                const username = $('#editUsernameServer').val();
                const password = $('#editPasswordServer').val();
                const port = $('#editPortServer').val();
                $.ajax({
                    url: "{{ route('test-con') }}",
                    method: "POST",
                    cache: false,
                    data: {
                        'host': host,
                        'password': password,
                        'username': username,
                        'port': port
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#badge-connected').removeClass('d-none');
                            $('#badge-connected').html('<span class="badge bg-success font-size-12 align-middle">Connected</span>');

                        } else {
                            $('#badge-connected').removeClass('d-none');
                            $('#badge-connected').html('<span class="badge bg-red font-size-12 align-middle">Disconnected</span>');

                        }
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
                        if (data.responseJSON && data.responseJSON.errors) {
                            if (data.responseJSON.errors.host) {
                                $('#hostServer').addClass('is-invalid');
                                $('#error_hostServer').addClass('invalid-feedback').text(data.responseJSON.errors.host[0]);
                            }
                            if (data.responseJSON.errors.username) {
                                $('#usernameServer').addClass('is-invalid');
                                $('#error_usernameServer').addClass('invalid-feedback').text(data.responseJSON.errors.username[0]);
                            }
                            if (data.responseJSON.errors.password) {
                                $('#passwordServer').addClass('is-invalid');
                                $('#error_passwordServer').addClass('invalid-feedback').text(data.responseJSON.errors.password[0]);
                            }
                            if (data.responseJSON.errors.port) {
                                $('#portServer').addClass('is-invalid');
                                $('#error_portServer').addClass('invalid-feedback').text(data.responseJSON.errors.port[0]);
                            }
                        }
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
            } else {
                $('#badge-connected').addClass('d-none');
                $('#is_connected').val('0');
                $('#badge-connected').removeClass('d-none');
                $('#badge-connected').html('<span class="badge bg-red font-size-12 align-middle">Disconnected</span>');
            }
        });


        let selectedRouterId;
        $(document).on('click', '.update-server', function(e) {
            e.preventDefault();
            selectedRouterId = $(this).data('id');
            const url = "{{ route('server.edit', ':id') }}".replace(':id', selectedRouterId);
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const data = response.data;
                    $('#editServerName').val(data.name);
                    $('#editHostServer').val(data.host);
                    $('#editDomainServer').val(data.domain);
                    $('#editUsernameServer').val(data.username);
                    $('#editPasswordServer').val(data.password);
                    $('#editPortServer').val(data.port);
                    $('#editTestConnection').prop('checked', false);
                }
            });
        });

        $(document).on('click', '.simpan-edit-server', function(e) {
            e.preventDefault();
            const nameRouter = $('#editServerName').val();
            const domain = $('#editDomainServer').val();
            const host = $('#editHostServer').val();
            const username = $('#editUsernameServer').val();
            const password = $('#editPasswordServer').val();
            const port = $('#editPortServer').val();
            const url = "{{ route('server.update', ':id') }}".replace(':id', selectedRouterId);
            const method = "PUT";
            const form = $(this).closest('form');

            $.ajax({
                url: url,
                type: method,
                data: {
                    domain: domain,
                    name: nameRouter,
                    username: username,
                    password:password,
                    port:port,
                    host:host
                },
                success: function(response) {
                    if (response.status === 'success') {
                        new Notify({
                            title: 'Success',
                            text: 'Server berhasil diupdate',
                            status: 'success',
                            effect: 'slide',
                            speed: 500,
                            showCloseButton: true,
                            autotimeout: 3000,
                            autoclose: true
                        });

                        $('#editMikrotikServerModal').modal('hide');
                        $('#serversTable').DataTable().ajax.reload();
                    } else {
                        new Notify({
                            title: 'Error',
                            text: 'Gagal',
                            status: 'error',
                            effect: 'slide',
                            speed: 500,
                            showCloseButton: true,
                            autotimeout: 3000,
                            autoclose: true
                        });
                        $.each(response.errors, function(key, value) {
                            form.find('input[name="' + key + '"]').addClass('is-invalid');
                            form.find('input[name="' + key + '"]').siblings('.invalid-feedback').text(value[0]);
                        });
                    }
                }
            });
        });
    </script>
@endpushonce
