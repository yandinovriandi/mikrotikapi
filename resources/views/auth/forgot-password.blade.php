<x-guest-layout>
{{--    <div class="mb-4 text-sm text-gray-600">--}}
{{--        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}--}}
{{--    </div>--}}

{{--    <!-- Session Status -->--}}
{{--    <x-auth-session-status class="mb-4" :status="session('status')" />--}}

{{--    <form method="POST" action="{{ route('password.email') }}">--}}
{{--        @csrf--}}

{{--        <!-- Email Address -->--}}
{{--        <div>--}}
{{--            <x-input-label for="email" :value="__('Email')" />--}}
{{--            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />--}}
{{--            <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}
{{--        </div>--}}

{{--        <div class="flex items-center justify-end mt-4">--}}
{{--            <x-primary-button>--}}
{{--                {{ __('Email Password Reset Link') }}--}}
{{--            </x-primary-button>--}}
{{--        </div>--}}
{{--    </form>--}}
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary"> Reset Password</h5>
                                        <p>{{config('app.name')}}</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{asset('images/profile-img.png')}}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="{{route('home')}}">
                                    <div class="avatar-md profile-user-wid mb-2">
                                    <span class="avatar-title rounded-circle bg-light">
                                    <img src="{{asset('images/logo.svg')}}" alt="" class="rounded-circle" height="34">
                                    </span>
                                    </div>
                                </a>
                                <x-auth-session-status class="alert-success mb-0" :status="session('status')" />
                                <x-auth-session-statuserror class="alert-success mb-0" :email="session('email')" />

                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" method="POST" action="{{route('password.request')}}">
                                   @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter email" value="">
                                        @error('email') <div class="text-danger text-sm mt-1">{{$message}}</div> @enderror
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <div>
                            <p>Belum meimiliki akun ? <a href="{{route('register')}}" class="fw-medium text-primary"> Daftar </a> </p>
                            <p>© <script>document.write(new Date().getFullYear())</script> {{config('app.name')}}. Crafted with <i class="bx bxs-heart text-pink"></i> by {{config('app.name')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
