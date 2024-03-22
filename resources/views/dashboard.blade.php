<x-app-layout>
    <x-slot:title>
       {{__('Dasbor')}}
    </x-slot:title>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{__('Dasbor')}}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{__('Dasbor')}}</a></li>
                        <li class="breadcrumb-item active">{{auth()->user()->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="login-msg" value="{{$message ?? ''}}">

{{--    <div class="card">--}}
{{--        <div class="card-body">--}}
{{--            <div class="d-sm-flex flex-wrap">--}}
{{--                <span>--}}
{{--                    <h4 class="card-title">Seuaikan data pendapatan</h4>--}}
{{--                    <span>Tampilkan data sesuai minggu, bulan dan tahun !</span>--}}
{{--                </span>--}}
{{--                <div class="ms-auto">--}}
{{--                    <ul class="nav nav-pills">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="#">{{__('Pekan')}} <i class="mdi mdi-view-week"></i></a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link active" href="#">{{__('Bulan')}} <i class="mdi mdi-calendar-month"></i> </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="#">{{__('Tahun')}} <i class="mdi mdi-calendar-clock"></i></a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Penghasilan</p>
                                    <h4 class="mb-0">{{formatIDR(1790000)}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                             <i class="mdi mdi-cash-multiple font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Saldo Aktif</p>
                                    <h4 class="mb-0">{{formatIDR(700000)}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                       <span class="avatar-title">
                                              <i class="mdi mdi-wallet font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Pengeluaran</p>
                                    <h4 class="mb-0">{{formatIDR(1070000)}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="mdi mdi-account-cash-outline font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Pendaftaran Pelanggan</p>
                                    <h4 class="mb-0">{{formatIDR(600000)}}</h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                       <span class="avatar-title rounded-circle bg-primary">
                                           <i class="mdi mdi-wallet-plus font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Pendapatan Bulanan</h4>

            <div id="spline_area" class="apex-charts" dir="ltr"></div>
        </div>
    </div>

    <div class="row mb-6">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Daftar Pelanggan</h4>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="align-middle">#</th>
                                <th class="align-middle">{{__('Nomor Layanan')}}</th>
                                <th class="align-middle">{{__('Customer')}}</th>
                                <th class="align-middle">{{__('Periode')}}</th>
                                <th class="align-middle">{{__('Tagihan')}}</th>
                                <th class="align-middle">{{__('Paket')}}</th>
                                <th class="align-middle">{{__('Status')}}</th>
                                <th class="align-middle">{{__('Alamat')}}</th>
                                <th class="text-end">{{__('Tindakan')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    1
                                </td>
                                <td><a href="javascript: void(0);" class="text-body fw-bold"><span class="badge badge-soft-info rounded-pill font-size-14">220099448</span></a> </td>
                                <td>Neal Matthews</td>
                                <td>
                                    07 Oct, 2019
                                </td>
                                <td>
                                    <span class="badge badge-soft-warning font-size-14">Rp. 150.000</span>
                                </td>
                                <td>
                                    <span class="badge badge-soft-secondary font-size-14">Paket 5Mbps</span>
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-soft-success font-size-14">Paid</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
                                        View Details
                                    </button>
                                </td>
                                <td class="text-end">
                                        <button class="btn border-0 content-end p-0 btn-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            aksi <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Kirim Faktur</a>
                                            <a class="dropdown-item" href="#">Matikan Internet</a>
                                            <a class="dropdown-item" href="#">Lihat Faktur</a>
                                        </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Modal -->
    <div class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transaction-detailModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Product id: <span class="text-primary">#SK2540</span></p>
                    <p class="mb-4">Billing Name: <span class="text-primary">Neal Matthews</span></p>

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap">
                            <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">
                                    <div>
                                        <img src="{{asset('images/product/img-7.png')}}" alt="" class="avatar-sm">
                                    </div>
                                </th>
                                <td>
                                    <div>
                                        <h5 class="text-truncate font-size-14">Wireless Headphone (Black)</h5>
                                        <p class="text-muted mb-0">$ 225 x 1</p>
                                    </div>
                                </td>
                                <td>$ 255</td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <div>
                                        <img src="{{asset('images/product/img-4.png')}}" alt="" class="avatar-sm">
                                    </div>
                                </th>
                                <td>
                                    <div>
                                        <h5 class="text-truncate font-size-14">Phone patterned cases</h5>
                                        <p class="text-muted mb-0">$ 145 x 1</p>
                                    </div>
                                </td>
                                <td>$ 145</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h6 class="m-0 text-right">Sub Total:</h6>
                                </td>
                                <td>
                                    $ 400
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h6 class="m-0 text-right">Shipping:</h6>
                                </td>
                                <td>
                                    Free
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h6 class="m-0 text-right">Total:</h6>
                                </td>
                                <td>
                                    $ 400
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @php
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $revenueData = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $revenueData[] = [
                'tanggal' => $day,
                'pendapatan' => rand(50000, 1000000)
            ];
        }

        $revenueJson = json_encode($revenueData);
    @endphp
    @pushonce('scripts')
        <script src="{{asset('libs/apexcharts/dist/apexcharts.min.js')}}"></script>
        <script>
            revenueData = <?php echo $revenueJson; ?>;

            function formatRupiah(number) {
                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });

                return formatter.format(number);
            }

            const seriesData = revenueData.map(data => ({
                x: new Date(new Date().getFullYear(), new Date().getMonth(), data.tanggal),
                y: data.pendapatan
            }));

            const options = {
                series: [{
                    name: 'Pendapatan Bulan Ini',
                    data: seriesData
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    type: 'datetime',
                    labels: {
                        format: 'dd MMM'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Revenue (IDR)'
                    },
                    labels: {
                        formatter: function (value) {
                            return formatRupiah(value);
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: 'dd MMM yyyy'
                    },
                    y: {
                        formatter: function (value) {
                            return formatRupiah(value);
                        }
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#spline_area"), options);
            chart.render();
        </script>
    @endpushonce
</x-app-layout>
