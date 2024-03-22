{{--<x-guest-layout>--}}
{{--    <form method="POST" action="{{ route('register') }}">--}}
{{--        @csrf--}}

{{--        <!-- Name -->--}}
{{--        <div>--}}
{{--            <x-input-label for="name" :value="__('Name')" />--}}
{{--            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />--}}
{{--            <x-input-error :messages="$errors->get('name')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Email Address -->--}}
{{--        <div class="mt-3">--}}
{{--            <x-input-label for="email" :value="__('Email')" />--}}
{{--            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />--}}
{{--            <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Password -->--}}
{{--        <div class="mt-3">--}}
{{--            <x-input-label for="password" :value="__('Password')" />--}}

{{--            <x-text-input id="password" class="block mt-1 w-full"--}}
{{--                            type="password"--}}
{{--                            name="password"--}}
{{--                            required autocomplete="new-password" />--}}

{{--            <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Confirm Password -->--}}
{{--        <div class="mt-3">--}}
{{--            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />--}}

{{--            <x-text-input id="password_confirmation" class="block mt-1 w-full"--}}
{{--                            type="password"--}}
{{--                            name="password_confirmation" required autocomplete="new-password" />--}}

{{--            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <div class="flex items-center justify-end mt-3">--}}
{{--            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">--}}
{{--                {{ __('Already registered?') }}--}}
{{--            </a>--}}

{{--            <x-primary-button class="ml-4">--}}
{{--                {{ __('Register') }}--}}
{{--            </x-primary-button>--}}
{{--        </div>--}}
{{--    </form>--}}
{{--</x-guest-layout>--}}
<x-guest-layout>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Daftar sekarang <span class="fw-2 badge badge-soft-success">Gratis!</span></h5>
                                        <p>Anda harus memiliki akun dahulu untuk menggunakan <span class="badge badge-soft-info">layanan.</span>.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{asset('images/profile-img.png')}}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="{{route('dashboard')}}">
                                    <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{asset('images/logo.svg')}}" alt="" class="rounded-circle" height="34">
                                            </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="needs-validation" novalidate method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div>
                                        <label for="name" class="form-label">Nama lengkap</label>
                                        <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" autofocus autocomplete="off" placeholder="Masukan nama lengkap anda">
                                        @error('name')
                                        <div class="mt-2 text-danger text-sm">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" autocomplete="off" placeholder="Pastikan email anda aktif">
                                        @error('email')
                                        <div class="mt-2 text-danger text-sm font-semibold">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                            @error('password') <div class="text-danger text-sm mt-1">{{$message}}</div> @enderror
                                      </div>
                                    <div class="mt-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Password Confirmation" aria-label="Password" aria-describedby="password-addon">
                                            <button class="btn btn-light" type="button" id="toggle-password-confirmation"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                        @error('password_confirmation')
                                        <div class="mt-2 text-danger text-sm font-semibold">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <p class="mb-0">Dengan mendaftar anda memahami <a href="#" class="text-primary">syarat penggunaan</a> {{config('app.name')}}</p>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <div>
                            <p>Sudah memiliki akun ? <a href="{{route('login')}}" class="fw-medium text-primary"> Login</a> </p>
                            <p>© <script>document.write(new Date().getFullYear())</script> {{config('app.name')}}. Crafted with <i class="mdi mdi-heart text-danger"></i> by {{config('app.name')}}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
