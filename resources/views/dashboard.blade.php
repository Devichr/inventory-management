@extends('layouts.admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-6 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Welcome {{ Auth::user()->name }}</h5>
                                <p class="mb-4">
                                    Silahkan gunakan menu di sebelah kiri untuk navigasi dan kamu bisa melihat data terkini
                                    di dashboard ini
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
            <div class="col-lg-6 col-md-12 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2>Predictions</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fabric</th>
                                    <th>Predicted Demand</th>
                                    <th>Prediction Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($predictions as $prediction)
                                    <tr>
                                        <td>{{ $prediction->fabric->name }}</td>
                                        <td>{{ $prediction->predicted_demand }}</td>
                                        <td>{{ $prediction->prediction_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Kolom untuk Total Revenue -->
            <div class="col-8 col-lg-8 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-8">
                            <h5 class="card-header m-0 me-2 pb-3">EOQ vs Order</h5>
                            <div id="eoqOrderChart" class="px-2"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <div class="text-center">
                                    Pertumbuhan Order
                                </div>
                            </div>
                            <!-- Kolom untuk Growth -->
                            <div id="stockGrowthChart" class="py-3"></div>
                            <div class="text-center fw-semibold pt-3 mb-2">{{ $thisMonthOrders }} Order Baru bulan ini</div>
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
                                <span class="fw-semibold d-block mb-1">Fabric</span>
                                <h3 class="card-title mb-2">{{ $fabricCount }}</h3>
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
                                <span>Usage</span>
                                <h3 class="card-title text-nowrap mb-1">{{ $usageSum }}</h3>
                            </div>
                        </div>
                    </div>
                    {{-- Simpen notif disini --}}
                    <div class="col-lg-12 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Notifications</h5>
                                @if ($notifications->isEmpty())
                                    <p>No new notifications.</p>
                                @else
                                    <ul class="list-group">
                                        @foreach ($notifications as $notification)
                                            <li class="list-group-item">
                                                <div class="notification {{ $notification->is_read ? 'read' : 'unread' }}">
                                                    <p>{{ $notification->message }}</p>
                                                    @if (!$notification->is_read)
                                                        <form action="{{ route('notifications.read', $notification->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-primary">Mark as
                                                                Read</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        (function() {
            const cardColor = '#FFFFFF';
            const headingColor = '#000000';
            const axisColor = '#9E9E9E';
            const borderColor = '#E0E0E0';

            const eoqData = @json($usageData);
            const orderData = @json($orderData);

            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            const eoqOrderChartEl = document.querySelector('#eoqOrderChart');
            const eoqOrderChartOptions = {
                series: [{
                        name: 'Usage',
                        data: months.map((month, index) => eoqData[index + 1] || 0)
                    },
                    {
                        name: 'Orders',
                        data: months.map((month, index) => orderData[index + 1] || 0)
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
                colors: ['#008FFB', '#FEB019'],
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

            if (eoqOrderChartEl !== null) {
                const eoqOrderChart = new ApexCharts(eoqOrderChartEl, eoqOrderChartOptions);
                eoqOrderChart.render();
            }

            const stockGrowthChartEl = document.querySelector('#stockGrowthChart');

            const lastMonthStock = @json($lastMonthStock);
            const thisMonthStock = @json($thisMonthStock);

            let stockGrowthPercentage;
            if (lastMonthStock === 0 && thisMonthStock > 0) {
                stockGrowthPercentage = 100;
            } else if (lastMonthStock === 0 && thisMonthStock === 0) {
                stockGrowthPercentage = 0;
            } else {
                stockGrowthPercentage = ((thisMonthStock - lastMonthStock) / lastMonthStock) * 100;
            }

            const stockGrowthChartOptions = {
                series: [stockGrowthPercentage],
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
                            background: '#f2f2f2',
                            strokeWidth: '100%'
                        },
                        dataLabels: {
                            name: {
                                offsetY: 15,
                                color: '#333',
                                fontSize: '15px',
                                fontWeight: '600'
                            },
                            value: {
                                offsetY: -25,
                                color: '#333',
                                fontSize: '22px',
                                fontWeight: '500'
                            }
                        }
                    }
                },
                colors: ['#00E396'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        shadeIntensity: 0.5,
                        gradientToColors: ['#00E396'],
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 0.6,
                        stops: [0, 100]
                    }
                },
                stroke: {
                    lineCap: 'round'
                }
            };

            if (stockGrowthChartEl !== null) {
                const stockGrowthChart = new ApexCharts(stockGrowthChartEl, stockGrowthChartOptions);
                stockGrowthChart.render();
            }

        })();
    </script>
@endsection
