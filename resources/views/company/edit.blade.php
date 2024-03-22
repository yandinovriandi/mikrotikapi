<x-app-layout>
    <x-slot name="title">
        {{ __('Update data perusahaan') }}
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('Update data perusahaan') }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Perusahaan') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Perusahaan') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">{{ __('Hi, ') }} {{ auth()->user()->name }}</h5>
                                <p>{{ __('Update data perusahaan anda.') }} </p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{asset('images/profile-img.png')}}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img src="/{{$company->logo }}" alt="" class="img-thumbnail rounded-circle">
                            </div>
                            <h5 class="font-size-15 badge badge-soft-primary">{{$company->name}}</h5>
                            <p class="text-muted mb-0 text-truncate">{{ $company->motto }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('company.update',$company)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name">{{ __('Nama Perusahaan') }}</label>
                            <input id="name" name="name" type="text" class="form-control" value="{{old('name',$company->name)}}" placeholder="{{ __('Internet Provider Corporation') }}">
                        </div>

                        <div class="mb-3">
                            <label for="phone">{{ __('Telepon') }}</label>
                            <input id="phone" name="phone" type="number" class="form-control" value="{{old('name',$company->phone)}}" placeholder="{{ __('6285 111 222 333') }}">
                        </div>

                        <div class="mb-3">
                            <label for="url">{{ __('Website') }}</label>
                            <input id="url" name="url" type="text" class="form-control" value="{{old('name',$company->url)}}" placeholder="{{ __('https://internet.com') }}">
                        </div>

                        <h4 class="card-title">{{ __('Logo Perusahaan') }}</h4>

                        <div class="mb-3">
                            <div class="custom-file">
                                <input id="logo-upload" type="file" class="custom-file-input" name="logo">
                                <label class="custom-file-label" for="logo-upload">Pilih Logo</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div id="logo-preview-container">
                                @if ($company && $company->logo)
                                    <img src="/{{$company->logo }}" alt="Logo Preview" class="img-thumbnail">
                                @else
                                    <p>No logo available.</p>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address">{{ __('Alamat') }}</label>
                            <textarea id="address" name="address" type="text" class="form-control" >{{old('address',$company->address)  }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="motto">{{ __('Motto') }}</label>
                            <textarea id="motto" name="motto" type="text" class="form-control" >{{old('address',$company->motto)  }}</textarea>
                        </div>

                        <button class="btn btn-sm btn-primary" type="submit">{{__('Update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @pushonce('styles')
        <style>
            /* Style the custom file input */
            .custom-file {
                position: relative;
                display: inline-block;
            }

            .custom-file-input {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
                cursor: pointer;
            }

            .custom-file-label {
                position: relative;
                display: block;
                padding: 8px 12px;
                border: 1px solid #ced4da;
                border-radius: 4px;
                background-color: #f8f9fa;
                cursor: pointer;
            }

            /* Style the logo preview container */
            #logo-preview-container {
                width: 200px;
                height: 200px;
                border: 1px solid #ced4da;
                border-radius: 4px;
                overflow: hidden;
            }

            #logo-preview-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        </style>
    @endpushonce
    @pushonce('scripts')
        <script>
            document.getElementById('logo-upload').addEventListener('change', function() {
                const fileInput = this;
                const file = fileInput.files[0];
                const reader = new FileReader();

                reader.onload = function(event) {
                    const logoPreviewContainer = document.getElementById('logo-preview-container');
                    logoPreviewContainer.innerHTML = `
                <img src="${event.target.result}" alt="Logo Preview" class="img-thumbnail">
            `;
                };

                if (file) {
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpushonce
</x-app-layout>
