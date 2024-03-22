{{--<x-guest-layout>--}}
{{--    <!-- Session Status -->--}}
{{--    <x-auth-session-status class="mb-4" :status="session('status')" />--}}

{{--    <form method="POST" action="{{ route('login') }}">--}}
{{--        @csrf--}}

{{--        <!-- Email Address -->--}}
{{--        <div>--}}
{{--            <x-input-label for="email" :value="__('Email')" />--}}
{{--            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />--}}
{{--            <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Password -->--}}
{{--        <div class="mt-4">--}}
{{--            <x-input-label for="password" :value="__('Password')" />--}}

{{--            <x-text-input id="password" class="block mt-1 w-full"--}}
{{--                            type="password"--}}
{{--                            name="password"--}}
{{--                            required autocomplete="current-password" />--}}

{{--            <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <!-- Remember Me -->--}}
{{--        <div class="block mt-4">--}}
{{--            <label for="remember_me" class="inline-flex items-center">--}}
{{--                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">--}}
{{--                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
{{--            </label>--}}
{{--        </div>--}}

{{--        <div class="flex items-center justify-end mt-4">--}}
{{--            @if (Route::has('password.request'))--}}
{{--                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">--}}
{{--                    {{ __('Forgot your password?') }}--}}
{{--                </a>--}}
{{--            @endif--}}

{{--            <x-primary-button class="ml-3">--}}
{{--                {{ __('Log in') }}--}}
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
                                        <h5 class="text-primary">Selamat datang !</h5>
                                        <p>Login terlebih dahulu jika ingin menggunakan {{config('app.name')}}.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{asset('images/profile-img.png')}}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="{{route('dashboard')}}" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{asset('images/logo-light.png')}}" alt="" class="rounded-circle" height="34">
                                            </span>
                                    </div>
                                </a>
                                <a href="{{route('dashboard')}}" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{asset('images/logo.svg')}}" alt="" class="rounded-circle" height="34">
                                            </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" action="{{route('login')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email')}}" id="email" placeholder="email@mail.com">
                                        @error('email') <div class="text-danger mt-1">{{$message}}</div> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                                            <button class="btn btn-light " type="button" id="password-addon">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </button>
                                        </div>
                                        @error('password') <div class="text-danger mt-1">{{$message}}</div> @enderror
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-0">
                                        <div class="form-check">
                                            <input class="form-check-input" id="checkRememberPassword" type="checkbox"
                                                   value="" name="remember" />
                                            <label class="form-check-label" for="checkRememberPassword">Remember
                                                password</label>
                                        </div>
                                    </div>
                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                    </div>
                                    <div>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <a href="{{route('password.request')}}" class="text-muted"><i class="mdi mdi-lock me-1"></i> Lupa password?</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <div>
                            <p>Belum meimiliki akun ? <a href="{{route('register')}}" class="fw-medium text-primary"> Daftar </a> </p>
                            <p>© <script>document.write(new Date().getFullYear())</script> {{config('app.name')}}. Crafted with <i class="bx bxs-heart text-pink"></i> by MikrotikBot</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @pushonce('styles')
        <link href="{{asset('libs/notify/simple-notify.min.css')}}" rel="stylesheet" type="text/css"/>
    @endpushonce
    @pushonce('scripts')
        <script src="{{asset('libs/notify/simple-notify.min.js')}}"></script>
{{--        <script>--}}
{{--            function showToastMessage(status, message, title) {--}}
{{--                new Notify ({--}}
{{--                    status: status,--}}
{{--                    title: title,--}}
{{--                    text: message,--}}
{{--                    effect: 'slide',--}}
{{--                    speed: 600,--}}
{{--                    customClass: '',--}}
{{--                    customIcon: '',--}}
{{--                    showIcon: true,--}}
{{--                    showCloseButton: true,--}}
{{--                    autoclose: true,--}}
{{--                    autotimeout: 5000,--}}
{{--                    gap: 10,--}}
{{--                    distance: 10,--}}
{{--                    type: 1,--}}
{{--                    position: 'right top',--}}
{{--                    customWrapper: '',--}}
{{--                });--}}
{{--            }--}}
{{--            let time = 500;--}}
{{--            setTimeout(function() {--}}
{{--                showToastMessage('error','Ada kesalahan pada data anda.','Error');--}}
{{--            }, time);--}}
{{--            time += 1000;--}}
{{--        </script>--}}
    @endpushonce
</x-guest-layout>
