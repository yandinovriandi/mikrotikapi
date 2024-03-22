<x-app-layout>
    <x-slot name="title">
        {{__('Daftar Tunnel Remote')}}
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{__('Daftar Tunnel Remote')}}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{__('Tunnels')}}</a></li>
                        <li class="breadcrumb-item active">{{ auth()->user()->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="search-box me-2 mb-2 d-inline-block">
                                <div class="position-relative">
{{--                                                                        <label>--}}
{{--                                                                            <input type="text" class="form-control" placeholder="Search...">--}}
{{--                                                                        </label>--}}
{{--                                                                        <i class="bx bx-search-alt search-icon"></i>--}}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <button type="button" id="addTunnel" class="btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2" data-bs-toggle="modal" data-bs-target="#addTunnelModal">
                                     <i class="mdi mdi-router-wireless me-1"></i>
                                    {{__('Buat Tunnel')}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <table id="tunnelsTable" class="table align-middle table-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Nama Server')}}</th>
                            <th>{{__('Username')}}</th>
                            <th>{{__('DNS Server')}}</th>
                            <th>{{__('Port Api')}}</th>
                            <th>{{__('Status')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('tunnel.partial.create')
    @include('tunnel.partial.edit')
    @pushonce('scripts')
        @include('tunnel.partial._script')
{{--        <script>--}}
{{--            $('#btn-hapus-tunnel').on('click', function(e) {--}}
{{--                e.preventDefault();--}}
{{--                const form = $(this).closest('form');--}}
{{--                const url = form.attr('action');--}}

{{--                $.ajax({--}}
{{--                    url: url,--}}
{{--                    type: 'DELETE',--}}
{{--                    data: form.serialize(),--}}
{{--                    success: function(response) {--}}
{{--                        if (response.status === 'success') {--}}
{{--                            new Notify({--}}
{{--                                title: 'Berhasil',--}}
{{--                                text: 'Lokasi server berhasil di hapus.',--}}
{{--                                status:"success",--}}
{{--                                effect: 'slide',--}}
{{--                                speed: 500,--}}
{{--                                showCloseButton: true,--}}
{{--                                autotimeout: 3000,--}}
{{--                                autoclose: true--}}
{{--                            });--}}
{{--                            $('#tunnelsTable').DataTable().ajax.reload();--}}
{{--                            const currentCount = parseInt($('#tunnelCount').text());--}}
{{--                            const newCount = currentCount - 1;--}}
{{--                            // updateTunnelsCount(newCount);--}}
{{--                        } else {--}}
{{--                            new Notify({--}}
{{--                                title: response.title,--}}
{{--                                text: response.text,--}}
{{--                                status:response.status,--}}
{{--                                effect: 'slide',--}}
{{--                                speed: 500,--}}
{{--                                showCloseButton: true,--}}
{{--                                autotimeout: 3000,--}}
{{--                                autoclose: true--}}
{{--                            });--}}
{{--                            $.each(response.errors, function(key, value) {--}}
{{--                                form.find('input[name="' + key + '"]').addClass('is-invalid');--}}
{{--                                form.find('input[name="' + key + '"]').siblings('.invalid-feedback').text(value[0]);--}}
{{--                            });--}}
{{--                        }--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        </script>--}}
    @endpushonce
</x-app-layout>
