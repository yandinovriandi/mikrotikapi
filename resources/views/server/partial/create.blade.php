<div id="addMikrotikServerModal" class="modal fade" tabindex="-1" aria-labelledby="addMikrotikServerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addMikrotikServerForm" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="addMikrotikServerModalLabel">{{__('Tambah Mikrotik Server')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="serverName">{{ __('Nama Mikrotik Server') }}</label>
                    <input
                        class="form-control"
                        id="serverName" name="name" type="text"
                        placeholder="{{ __('Nama Mikrotik Server') }}" value="{{ old('name') }}"
                    >
                    <div id="error_serverName"></div>
                </div>
                <div class="mb-3">
                    <label for="domainServer">{{ __('DNS Server Mikrotik') }}</label>
                    <input
                        class="form-control"
                        id="domainServer" name="domain" type="text"
                        placeholder="{{ __('id1.mikrotikbot.com') }}" value="{{ old('domain') }}"
                    >
                    <div id="error_domainServer"></div>
                </div>
                <div class="mb-3">
                    <label for="remoteAddress">{{ __('Remote address for tunnel') }}</label>
                    <input
                        class="form-control"
                        id="remoteAddress" name="remote_address" type="text"
                        placeholder="{{ __('10.10.11.1') }}" value="{{ old('remote_address') }}"
                    >
                    <div id="error_remoteAddress"></div>
                </div>
                <div class="mb-3">
                    <label for="hostServer">{{ __('Host Ip Server Mikrotik') }}</label>
                    <input
                        class="form-control"
                        id="hostServer" name="host" type="text"
                        placeholder="{{ __('192.168.88.1') }}" value="{{ old('host') }}"
                    >
                    <div id="error_hostServer"></div>
                </div>
                <div class="mb-3">
                    <label for="usernameServer">{{ __('Username') }}</label>
                    <input
                        class="form-control"
                        id="usernameServer" name="username" type="text" placeholder="{{ __('admin') }}"
                        value="{{ old('usernameServer') }}"
                    >
                    <div id="error_usernameServer"></div>
                </div>
                <div class="mb-3">
                    <label for="passwordServer">{{ __('Password') }}</label>
                    <div class="input-group">
                        <input
                            class="form-control"
                            id="passwordServer"
                            name="password"
                            type="password"
                            placeholder="{{ __('********') }}"
                            value="{{ old('password') }}"
                        >
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="error_passwordServer"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="portServer">{{ __('Port') }}</label>
                    <input
                        class="form-control"
                        id="portServer" name="port" type="number" placeholder="{{ __('8728') }}"
                        value="{{ old('port') }}"
                    >
                    <div id="error_portServer"></div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="testConnection">
                            <label class="form-check-label" for="testConnection">
                                <i class="mdi mdi-connection"></i> {{ __('Tes Koneksi') }}
                            </label>
                        </div>
                        <div id="badge-connected" class="d-none"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{__('Batal')}}</button>
                <button type="button" class="btn btn-primary waves-effect waves-light simpan-server">{{__('Simpan')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>

@pushonce('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#togglePassword');
            const passwordInput = document.querySelector('#password');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
            });
        });

        $('#testConnection').on('click', function(e) {
            if (e.currentTarget.checked) {
                const host = $('#hostServer').val();
                const username = $('#usernameServer').val();
                const password = $('#passwordServer').val();
                const port = $('#portServer').val();
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

        $(document).ready(function() {
            $('#addMikrotikServer').click(function() {
                $('#serverName').val('');
                $('#hostServer').val('');
                $('#usernameServer').val('');
                $('#remoteAddress').val('');
                $('#domainServer').val('');
                $('#passwordServer').val('');
                $('#portServer').val('');
                $('#testConnection').prop('checked', false);
                $('#badge-connected').addClass('d-none');
                clearValidationErrors();
            });
            function clearValidationErrors() {
                $('#serverName, #hostServer, #usernameServer, #domainServer, #remoteAddress,#passwordServer, #portServer').removeClass('is-invalid');
                $('#serverName + .invalid-feedback, #hostServer + .invalid-feedback, #usernameServer + .invalid-feedback, #domainServer + .invalid-feedback, #passwordServer + .invalid-feedback, #portServer + .invalid-feedback').text('');
            }
        });
        $('#serverName, #hostServer, #usernameServer, #domainServer, #remoteAddress,#passwordServer, #portServer').on('input', function() {
            $(this).removeClass('is-invalid');
            $('#' + $(this).attr('id') + ' + .invalid-feedback').text('');
        });
        $(document).ready(function() {
            function routerCount(count) {
                $('#routerCount').text(count);
            }
            $('.simpan-server').click(function(e) {
                e.preventDefault();
                const url = "{{ route('server.store') }}";
                const nameServer = $('#serverName').val();
                const remoteAddress = $('#remoteAddress').val();
                const hostServer = $('#hostServer').val();
                const domainServer = $('#domainServer').val();
                const usernameServer = $('#usernameServer').val();
                const passwordServer = $('#passwordServer').val();
                const portServer = $('#portServer').val();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        name: nameServer,
                        domain: domainServer,
                        remote_address: remoteAddress,
                        host: hostServer,
                        username: usernameServer,
                        password: passwordServer,
                        port: portServer,
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            new Notify({
                                title: response.title,
                                text: response.text,
                                status: response.status,
                                effect: 'slide',
                                speed: 500,
                                showCloseButton: true,
                                autotimeout: 3000,
                                autoclose: true
                            });
                            const rCount = parseInt($('#routerCount').text());
                            const newCount = rCount + 1;
                            routerCount(newCount);
                            $('#addMikrotikServerModal').modal('hide');
                            $('#serversTable').DataTable().ajax.reload();
                        } else {
                            if (response.errors.name) {
                                $('#serverName').addClass('is-invalid');
                                $('#error_serverName').addClass('invalid-feedback').text(response.errors.name[0]);
                            }
                            if (response.errors.remote_address) {
                                $('#remoteAddress').addClass('is-invalid');
                                $('#error_remoteAddress').addClass('invalid-feedback').text(response.errors.remote_address[0]);
                            }
                            if (response.errors.domain) {
                                $('#domainServer').addClass('is-invalid');
                                $('#error_domainServer').addClass('invalid-feedback').text(response.errors.domain[0]);
                            }
                            if (response.errors.host) {
                                $('#hostServer').addClass('is-invalid');
                                $('#error_hostServer').addClass('invalid-feedback').text(response.errors.host[0]);
                            }
                            if (response.errors.username) {
                                $('#usernameServer').addClass('is-invalid');
                                $('#error_usernameServer').addClass('invalid-feedback').text(response.errors.username[0]);
                            }
                            if (response.errors.password) {
                                $('#passwordServer').addClass('is-invalid');
                                $('#error_passwordServer').addClass('invalid-feedback').text(response.errors.password[0]);
                            }
                            if (response.errors.port) {
                                $('#portServer').addClass('is-invalid');
                                $('#error_portServer').addClass('invalid-feedback').text(response.errors.port[0]);
                            }
                            new Notify({
                                title: response.title,
                                text: response.text,
                                status: response.status,
                                effect: 'slide',
                                speed: 500,
                                showCloseButton: true,
                                autotimeout: 3000,
                                autoclose: true
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        new Notify({
                            title: 'Oops Error',
                            text: 'Gagal menambah router.',
                            status: 'error',
                            effect: 'slide',
                            speed: 500,
                            showCloseButton: true,
                            autotimeout: 3000,
                            autoclose: true
                        });
                    }
                });
            });
        });
    </script>
@endpushonce
