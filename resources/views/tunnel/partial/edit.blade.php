<div id="editTunnelModal" class="modal fade" tabindex="-1" aria-labelledby="editTunnelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editTunnelForm" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTunnelModalLabel">{{__('Update Tunnel')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editSelectServer">Server</label>
                        <select required readonly=""
                                class="form-control select2"
                                name="server_id" id="editSelectServer">
                            <option disabled selected>Pilih Server Tunnel Anda</option>
                            @foreach($servers as $server)
                                <option disabled value="{{ $server->id }}">{{ $server->name }}</option>
                            @endforeach
                        </select>
                        <div id="error_editSelectServer"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editUserNameTunnel">{{ __('Username') }}</label>
                        <input
                            class="form-control"
                            id="editUserNameTunnel" name="username" type="text" readonly
                            placeholder="{{ __('Username Tunnel') }}" value="{{ old('username') }}"
                        >
                        <div id="error_editUserNameTunnel"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editPasswordTunnel">{{ __('Password') }}</label>
                        <div class="input-group">
                            <input
                                class="form-control"
                                id="editPasswordTunnel"
                                name="password"
                                type="password"
                                placeholder="{{ __('********') }}"
                                value="{{ old('password') }}"
                            >
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="editToggleTunnelPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="error_editPasswordTunnel"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editToPortApi">{{ __('Port Api') }}</label>
                        <input
                            class="form-control"
                            id="editToPortApi" name="to_ports_api" type="number" placeholder="{{ __('kosongkan jika default') }}"
                            value="8728">
                    </div>
                    <div class="mb-3">
                        <label for="editToPortWinBox">{{ __('Port WinBox') }}</label>
                        <input
                            class="form-control"
                            id="editToPortWinBox" name="to_ports_winbox" type="number" placeholder="{{ __('kosongkan jika default') }}"
                            value="8291">
                    </div>
                    <div class="mb-3">
                        <label for="editToPortWeb">{{ __('Port Web') }}</label>
                        <input
                            class="form-control"
                            id="editToPortWeb" name="to_ports_web" type="number" placeholder="{{ __('kosongkan jika default') }}"
                            value="80">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{__('Batal')}}</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light update-edit-tunnel">{{__('Update')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@pushonce('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editTogglePasswordTunnel = document.querySelector('#editToggleTunnelPassword');
            const editPasswordInputTunnel = document.querySelector('#editPasswordTunnel');

            editTogglePasswordTunnel.addEventListener('click', function () {
                const type = editPasswordInputTunnel.getAttribute('type') === 'password' ? 'text' : 'password';
                editPasswordInputTunnel.setAttribute('type', type);
            });
        });

        $('#editTestTunnelOnline').on('click', function(e) {
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


        let selectedTunnelId;
        $(document).on('click', '.update-tunnel', function(e) {
            e.preventDefault();
            selectedTunnelId = $(this).data('id');
            const url = "{{ route('tunnel.edit', ':id') }}".replace(':id', selectedTunnelId);
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const data = response.data;
                    $('#editSelectServer').val(data.server_id);
                    $('#editUserNameTunnel').val(data.username);
                    $('#editPasswordTunnel').val(data.password);
                    $('#editToPortApi').val(data.to_ports_api);
                    $('#editToPortWeb').val(data.to_ports_web);
                    $('#editToPortWinBox').val(data.to_ports_winbox);
                }
            });
        });

        $(document).on('click', '.update-edit-tunnel', function(e) {
            e.preventDefault();
            const serverTunnel = $('#editSelectServer').val();
            const usernameTunnel = $('#editUserNameTunnel').val();
            const passwordTunnel = $('#editPasswordTunnel').val();
            const toPortsApi = $('#editToPortApi').val();
            const toPortsWeb = $('#editToPortWeb').val();
            const toPortsWinBox = $('#editToPortWinBox').val();
            const url = "{{ route('tunnel.update', ':id') }}".replace(':id', selectedTunnelId);
            const method = "PUT";
            const form = $(this).closest('form');

            $.ajax({
                url: url,
                type: method,
                data: {
                  server_id: serverTunnel,
                    username: usernameTunnel,
                    password: passwordTunnel,
                    to_ports_api: toPortsApi,
                    to_ports_web: toPortsWeb,
                    to_ports_winbox: toPortsWinBox
                },
                success: function(response) {
                    if (response.status === 'success') {
                        new Notify({
                            title: 'Success',
                            text: 'Tunnel berhasil di update',
                            status: 'success',
                            effect: 'slide',
                            speed: 500,
                            showCloseButton: true,
                            autotimeout: 3000,
                            autoclose: true
                        });

                        $('#editTunnelModal').modal('hide');
                        $('#tunnelsTable').DataTable().ajax.reload();
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
