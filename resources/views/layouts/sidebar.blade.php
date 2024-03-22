<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">{{__('Menu')}}</li>
                <li>
                    <a href="/dashboard" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">{{__('Dasbor')}}</span>
                    </a>
                </li>
                <li class="menu-title" key="t-apps">{{__('Aplikasi')}}</li>
{{--                <li>--}}
{{--                    <a href="{{route('locations.index')}}" class="waves-effect {{ Request::is('locations*') ? 'mm-active' : '' }}">--}}
{{--                        <i class="mdi mdi-map-marker-distance"></i>--}}
{{--                        <span id="locationCount" class="badge rounded-pill bg-success float-end">{{$countLocation}}</span>--}}
{{--                        <span key="t-locations">{{__('Lokasi')}}</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li>
                    <a href="{{route('server.index')}}" class="waves-effect {{ Request::is('server*') ? 'mm-active' : '' }}">
                        <i class="mdi mdi-router-network"></i>
                        <span id="routerCount" class="badge rounded-pill bg-danger float-end">{{$countServer}}</span>
                        <span key="t-routers">{{__('Server')}}</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('tunnel.index')}}" class="waves-effect {{ Request::is('tunnel*') ? 'mm-active' : '' }}">
                        <i class="mdi mdi-lan-connect"></i>
                        <span id="tunnelCount" class="badge rounded-pill bg-success float-end">{{$tunnelCount}}</span>
                        <span key="t-tunnel">{{__('Tunnel')}}</span>
                    </a>
                </li>
{{--                <li>--}}
{{--                    <a href="{{route('customers.table')}}" class="waves-effect {{ Request::is('customers*') ? 'mm-active' : '' }}">--}}
{{--                        <i class="mdi mdi-account-group"></i>--}}
{{--                        <span class="badge rounded-pill bg-primary float-end">40</span>--}}
{{--                        <span key="t-clients">{{__('Pelanggan')}}</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href="#" class="waves-effect {{ Request::is('client*') ? 'mm-active' : '' }}">--}}
{{--                        <i class="mdi mdi-receipt"></i>--}}
{{--                        <span class="badge rounded-pill bg-warning float-end">40</span>--}}
{{--                        <span key="t-clients">{{__('Paket Internet')}}</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href="#" class="waves-effect {{ Request::is('client*') ? 'mm-active' : '' }}">--}}
{{--                        <i class="mdi mdi-cash"></i>--}}
{{--                        <span class="badge rounded-pill bg-light float-end">10</span>--}}
{{--                        <span key="t-bill">{{__('Tagihan')}}</span>--}}
{{--                    </a>--}}
{{--                </li>--}}

{{--                <li>--}}
{{--                    <a href="javascript: void(0);" class="waves-effect">--}}
{{--                        <i class="mdi mdi-cog-clockwise"></i>--}}
{{--                        <span class="badge rounded-pill bg-success float-end">#</span>--}}
{{--                        <span key="t-configurations">{{__('Pengaturan')}}</span>--}}
{{--                    </a>--}}
{{--                    <ul class="sub-menu" aria-expanded="false">--}}
{{--                        <li>--}}
{{--                            @if ($company)--}}
{{--                                <a href="{{ route('company.edit', ['company' => $company->slug]) }}" key="t-company">{{ __('Edit Perusahaan') }}</a>--}}
{{--                            @else--}}
{{--                                <a href="{{ route('company.create') }}" key="t-company">{{ __('Buat Perusahaan') }}</a>--}}
{{--                            @endif--}}
{{--                        </li>--}}
{{--                        <li><a href="#" key="t-payment-gateway">{{__('Metode Pembayaran')}}</a></li>--}}
{{--                        <li>--}}
{{--                            <a href="#" key="t-whatsapp-gateway">--}}
{{--                                {{__('Whatsapp')}}--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
                <li class="menu-title" key="t-mymenu">My Menu</li>
                <li>
                    <a href="{{ route('profile.edit') }}" class="waves-effect">
                        <i class="mdi mdi-account-cog"></i>
                        <span key="t-profile">{{__('Profil')}}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
