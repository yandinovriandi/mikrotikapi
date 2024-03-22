<div id="addTunnelModal" class="modal fade" tabindex="-1" aria-labelledby="addTunnelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addTunnelForm" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="addTunnelModalLabel">{{__('Buat Tunnel')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="selectServer">Server</label>
                    <select required
                            class="form-control select2"
                            name="server_id" id="selectServer">
                        <option disabled selected>Pilih Server Tunnel Anda</option>
                        @foreach($servers as $server)
                            <option value="{{ $server->id }}">{{ $server->name }}</option>
                        @endforeach
                    </select>
                    <div id="error_selectServer"></div>
                </div>
                <div class="mb-3">
                    <label for="userNameTunnel">{{ __('Username') }}</label>
                    <input
                        class="form-control"
                        id="userNameTunnel" name="username" type="text"
                        placeholder="{{ __('Username Tunnel') }}" value="{{ old('username') }}"
                    >
                    <div id="error_userNameTunnel"></div>
                </div>
                <div class="mb-3">
                    <label for="passwordTunnel">{{ __('Password') }}</label>
                    <div class="input-group">
                        <input
                            class="form-control"
                            id="passwordTunnel"
                            name="password"
                            type="password"
                            placeholder="{{ __('********') }}"
                            value="{{ old('password') }}"
                        >
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="addTogglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="error_passwordTunnel"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="toPortApi">{{ __('Port Api') }}</label>
                    <input
                        class="form-control"
                        id="toPortApi" name="to_ports_api" type="number" placeholder="{{ __('kosongkan jika default') }}"
                        value="8728">
                </div>
                <div class="mb-3">
                    <label for="toPortWinBox">{{ __('Port WinBox') }}</label>
                    <input
                        class="form-control"
                        id="toPortWinBox" name="to_ports_winbox" type="number" placeholder="{{ __('kosongkan jika default') }}"
                        value="8291">
                </div>
                <div class="mb-3">
                    <label for="toPortWeb">{{ __('Port Web') }}</label>
                    <input
                        class="form-control"
                        id="toPortWeb" name="to_ports_web" type="number" placeholder="{{ __('kosongkan jika default') }}"
                        value="80">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{__('Batal')}}</button>
                <button type="button" class="btn btn-primary waves-effect waves-light simpan-tunnel">{{__('Simpan')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>

@pushonce('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePasswordTunnel = document.querySelector('#addTogglePassword');
            const passwordInputTunnel = document.querySelector('#passwordTunnel');

            togglePasswordTunnel.addEventListener('click', function () {
                const type = passwordInputTunnel.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInputTunnel.setAttribute('type', type);
            });
        });

        $(document).ready(function() {
            $('#addTunnel').click(function() {
                $('#userNameTunnel').val('');
                $('#passwordTunnel').val('');
                // $('#toPortApi').val('');
                // $('#toPortWeb').val('');
                // $('#toPortWinBox').val('');
                clearValidationErrors();
            });
            function clearValidationErrors() {
                $('#selectServer, #userNameTunnel,#passwordTunnel, #toPortWinBox, #toPortWeb, #toPortApi').removeClass('is-invalid');
                $('#selectServer + .invalid-feedback, #userNameTunnel + .invalid-feedback, #toPortWinBox + .invalid-feedback, #toPortWeb + .invalid-feedback, #toPortApi + .invalid-feedback').text('');
            }
        });
        $('#selectServer, #userNameTunnel, #passwordTunnel, #toPortWinBox, #toPortWeb, #toPortApi').on('input', function() {
            $(this).removeClass('is-invalid');
            $('#' + $(this).attr('id') + ' + .invalid-feedback').text('');
        });
        $(document).ready(function() {
            function tunnelCount(count) {
                $('#tunnelCount').text(count);
            }
            $('.simpan-tunnel').click(function(e) {
                e.preventDefault();
                const url = "{{ route('tunnel.store') }}";
                const serverId = $('#selectServer').val();
                const tunnelUserName = $('#userNameTunnel').val();
                const passwordTunnel = $('#passwordTunnel').val();
                const toPortApi = $('#toPortApi').val();
                const toPortWeb = $('#toPortWeb').val();
                const toPortWinBox = $('#toPortWinBox').val();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        server_id: serverId,
                        username: tunnelUserName,
                        password: passwordTunnel,
                        to_ports_api: toPortApi,
                        to_ports_web: toPortWeb,
                        to_ports_winbox: toPortWinBox,
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
                            const tCount = parseInt($('#tunnelCount').text());
                            const newCount = tCount + 1;
                            tunnelCount(newCount);
                            $('#addTunnelModal').modal('hide');
                            $('#tunnelsTable').DataTable().ajax.reload();
                        } else {
                            if (response.errors.server_id) {
                                $('#selectServer').addClass('is-invalid');
                                $('#error_selectServer').addClass('invalid-feedback').text(response.errors.server_id[0]);
                            }
                            if (response.errors.username) {
                                $('#userNameTunnel').addClass('is-invalid');
                                $('#error_userNameTunnel').addClass('invalid-feedback').text(response.errors.username[0]);
                            }
                            if (response.errors.password) {
                                $('#passwordTunnel').addClass('is-invalid');
                                $('#error_passwordTunnel').addClass('invalid-feedback').text(response.errors.password[0]);
                            }
                            if (response.errors.password) {
                                $('#passwordServer').addClass('is-invalid');
                                $('#error_passwordServer').addClass('invalid-feedback').text(response.errors.password[0]);
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
                            text: 'Gagal membuat tunnel.',
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
