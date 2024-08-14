@extends('layouts.admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Welcome {{ Auth::user()->name }}</h5>
                                <p class="mb-4">
                                    Sekarang sudah ada <span class="fw-bold">{{ $orderThisWeek }}</span> Order baru minggu
                                    ini silahkan
                                    masuk ke halaman order untuk melihat atau menambah order
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                            class="rounded" />
                                    </div>

                                </div>
                                <span class="fw-semibold d-block mb-1">Orders</span>
                                <h3 class="card-title mb-2">{{ $ordersCount }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="../assets/img/icons/unicons/wallet-info.png" alt="Credit Card"
                                            class="rounded" />
                                    </div>

                                </div>
                                <span>Sales</span>
                                <h3 class="card-title text-nowrap mb-1">{{ $stockCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Kolom untuk Total Revenue -->
            <div class="col-12 col-lg-8 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-12">
                            <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
                            <div id="stockChart" class="px-2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom untuk Growth -->
            <div class="col-12 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h5>Growth</h5>
                        </div>
                        <div id="orderGrowthChart" class="py-3"></div>
                        <div class="text-center fw-semibold pt-3 mb-2">{{$thisMonthOrders}} Order Baru bulan ini</div>
                    </div>
                </div>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>


        (function() {
            // Definisikan warna jika config tidak ada
            const cardColor = '#FFFFFF'; // Warna latar belakang kartu
            const headingColor = '#000000'; // Warna judul
            const axisColor = '#9E9E9E'; // Warna sumbu
            const borderColor = '#E0E0E0'; // Warna border

            const ordersData = @json($orders);
            const stockInData = @json($stockIn);

            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            //Chart perbandingan order dan stock
            const totalRevenueChartEl = document.querySelector('#stockChart');
            const totalRevenueChartOptions = {
                series: [{
                        name: 'Stock In',
                        data: months.map((month, index) => stockInData[index + 1] ||
                            0) // Ambil data sesuai bulan
                    },
                    {
                        name: 'Orders',
                        data: months.map((month, index) => ordersData[index + 1] ||
                            0) // Ambil data sesuai bulan
                    }
                ],
                chart: {
                    height: 300,
                    stacked: true,
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '70%',
                        borderRadius: 12,
                        startingShape: 'rounded',
                        endingShape: 'rounded'
                    }
                },
                colors: ['#008FFB', '#FEB019'], // Ganti dengan warna dari config jika ada
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 6,
                    lineCap: 'round',
                    colors: [cardColor]
                },
                legend: {
                    show: true,
                    horizontalAlign: 'left',
                    position: 'top',
                    markers: {
                        height: 8,
                        width: 8,
                        radius: 12,
                        offsetX: -3
                    },
                    labels: {
                        colors: axisColor
                    },
                    itemMargin: {
                        horizontal: 10
                    }
                },
                grid: {
                    borderColor: borderColor,
                    padding: {
                        top: 0,
                        bottom: -8,
                        left: 20,
                        right: 20
                    }
                },
                xaxis: {
                    categories: months,
                    labels: {
                        style: {
                            fontSize: '13px',
                            colors: axisColor
                        }
                    },
                    axisTicks: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '13px',
                            colors: axisColor
                        }
                    }
                },
                states: {
                    hover: {
                        filter: {
                            type: 'none'
                        }
                    },
                    active: {
                        filter: {
                            type: 'none'
                        }
                    }
                }
            };

            if (totalRevenueChartEl !== null) {
                const totalRevenueChart = new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions);
                totalRevenueChart.render();
            }

            const growthChartEl = document.querySelector('#orderGrowthChart');

        // Data dari controller
        const ordersDataGrowth = @json($orders);

        // Ambil order bulan lalu dan bulan ini
        const lastMonthOrders = @json($lastMonthOrders);
        const thisMonthOrders = @json($thisMonthOrders);

        // Hitung growth
        let growthPercentage;
        if (lastMonthOrders === 0 && thisMonthOrders > 0) {
            growthPercentage = 100; // Pertumbuhan maksimum jika dari 0 ke angka positif
        } else if (lastMonthOrders === 0 && thisMonthOrders === 0) {
            growthPercentage = 0; // Tidak ada pertumbuhan jika keduanya 0
        } else {
            growthPercentage = ((thisMonthOrders - lastMonthOrders) / lastMonthOrders) * 100;
        }

        // Menyiapkan data chart
        const growthChartOptions = {
            series: [growthPercentage],
            labels: ['Growth'],
            chart: {
                height: 240,
                type: 'radialBar'
            },
            plotOptions: {
                radialBar: {
                    size: 150,
                    offsetY: 10,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '55%'
                    },
                    track: {
                        background: '#f2f2f2', // Warna track jika perlu
                        strokeWidth: '100%'
                    },
                    dataLabels: {
                        name: {
                            offsetY: 15,
                            color: '#333', // Warna nama
                            fontSize: '15px',
                            fontWeight: '600'
                        },
                        value: {
                            offsetY: -25,
                            color: '#333', // Warna nilai
                            fontSize: '22px',
                            fontWeight: '500'
                        }
                    }
                }
            },
            colors: ['#00E396'], // Warna chart
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#00E396'],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 0.6,
                    stops: [30, 70, 100]
                }
            },
            stroke: {
                dashArray: 5
            },
            grid: {
                padding: {
                    top: -35,
                    bottom: -10
                }
            },
            states: {
                hover: {
                    filter: {
                        type: 'none'
                    }
                },
                active: {
                    filter: {
                        type: 'none'
                    }
                }
            }
        };

        if (growthChartEl !== undefined && growthChartEl !== null) {
            const growthChart = new ApexCharts(growthChartEl, growthChartOptions);
            growthChart.render();
        }
        })();
    </script>
@endsection
