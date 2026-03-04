@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-12 col-xxl-4 mb-6">
                <div class="card h-100">
                    <div class="d-flex align-items-end row">
                        <div class="col-7">
                            <div class="card-body">
                                <h5 class="card-title mb-1 text-nowrap">
                                    Congratulations {{ $bestAgent['name'] }}! 🎉
                                </h5>
                                <p class="card-subtitle text-nowrap mb-3">Best agent of the month</p>

                                <h5 class="card-title text-primary mb-0">
                                    {{ number_format($bestAgent['messages_count']) }} msgs
                                </h5>
                                <p class="mb-3">{{ $bestAgent['target_percent'] }}% of target 🚀</p>

                                <a href="#" class="btn btn-sm btn-primary mb-1">
                                    View Agents
                                </a>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="card-body pb-0 text-end">
                                <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/img/illustrations/prize-light.png"
                                    width="91" height="144" class="rounded-start" alt="Best Agent">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-8 mb-6">
                <div class="card h-100">
                    <div class="card-body row g-4 p-0">
                        <div class="col-md-6 card-separator">
                            <div class="p-6">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <h5 class="mb-0">New Visitors</h5>
                                    <small>Last Week</small>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div class="mt-auto">
                                        <h3 class="mb-1">{{ $visitorPercent }}%</h3>
                                        <small
                                            class="{{ $percentChange >= 0 ? 'text-success' : 'text-danger' }} text-nowrap fw-medium">
                                            <i
                                                class="icon-base bx {{ $percentChange >= 0 ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt' }}"></i>
                                            {{ $percentChange > 0 ? '+' : '' }}{{ $percentChange }}%
                                        </small>
                                    </div>
                                    <div id="visitorsChart" style="min-height: 120px;" class="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-6">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <h5 class="mb-0">Activity</h5>
                                    <small>Last Week</small>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="mt-auto">
                                        <h3 class="mb-1">{{ $activityPercent }}%</h3>
                                        <small
                                            class="{{ $activityChange >= 0 ? 'text-success' : 'text-danger' }} text-nowrap fw-medium">
                                            <i
                                                class="icon-base bx {{ $activityChange >= 0 ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt' }}"></i>
                                            {{ $activityChange > 0 ? '+' : '' }}{{ $activityChange }}%
                                        </small>
                                    </div>
                                    <div id="activityChart" style="min-height: 110px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-6">

            {{-- Visitors Today --}}
            <div class="col-sm-6 col-xxl mb-6 mb-xxl-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="card-title mb-0">Visitors Today</h5>
                            <span class="badge bg-label-primary rounded-pill">Today</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="icon-base bx bx-user icon-md"></i>
                                </span>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ number_format($quickStats['visitors_today']) }}</h4>
                                <small class="text-muted">Total traffic today</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Active Visitors --}}
            <div class="col-sm-6 col-xxl mb-6 mb-xxl-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="card-title mb-0">Active Visitors</h5>
                            <span class="badge bg-label-success rounded-pill">Live</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="icon-base bx bx-wifi icon-md"></i>
                                </span>
                            </div>
                            <div>
                                <h4 class="mb-0" id="active-visitors">{{ number_format($quickStats['active_visitors']) }}</h4>
                                <small class="text-muted">Last 5 minutes</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chats Today --}}
            <div class="col-sm-6 col-xxl mb-6 mb-xxl-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="card-title mb-0">Chats Today</h5>
                            <span class="badge bg-label-info rounded-pill">Today</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="icon-base bx bx-chat icon-md"></i>
                                </span>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ number_format($quickStats['chats_today']) }}</h4>
                                <small class="text-muted">Support demand</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Open Chats --}}
            <div class="col-sm-6 col-xxl mb-6 mb-xxl-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="card-title mb-0">Open Chats</h5>
                            <span class="badge bg-label-warning rounded-pill">Pending</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="icon-base bx bx-comment-dots icon-md"></i>
                                </span>
                            </div>
                            <div>
                                <h4 class="mb-0" id="open-chats">{{ number_format($quickStats['open_chats']) }}</h4>
                                <small class="text-muted">Pending workload</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Avg Response Time --}}
            <div class="col-sm-6 col-xxl mb-6 mb-xxl-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="card-title mb-0">Avg Response Time</h5>
                            <span class="badge bg-label-info rounded-pill">Today</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="icon-base bx bx-time icon-md"></i>
                                </span>
                            </div>
                            <div>
                                <h4 class="mb-0">{{ $responseTime['avg_formatted'] }}</h4>
                                <small class="text-muted">
                                    {{ $responseTime['total_responded'] }} chats responded
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===== VISITOR ANALYTICS SECTION ===== --}}
        <div class="row mb-6">

            {{-- Total / Unique / Returning --}}
            <div class="col-xxl-4 mb-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Visitor Overview</h5>
                        <small class="text-muted">All time</small>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4 p-3 rounded bg-label-primary">
                            <div class="d-flex align-items-center">
                                <span class="avatar-initial rounded bg-primary me-3 avatar">
                                    <i class="icon-base bx bx-globe icon-md"></i>
                                </span>
                                <div>
                                    <h6 class="mb-0">Total Visitors</h6>
                                    <small class="text-muted">All sessions</small>
                                </div>
                            </div>
                            <h4 class="mb-0" id="totalVisitors">—</h4>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-4 p-3 rounded bg-label-success">
                            <div class="d-flex align-items-center">
                                <span class="avatar-initial rounded bg-success me-3 avatar">
                                    <i class="icon-base bx bx-user-check icon-md"></i>
                                </span>
                                <div>
                                    <h6 class="mb-0">Unique Visitors</h6>
                                    <small class="text-muted">Distinct sessions</small>
                                </div>
                            </div>
                            <h4 class="mb-0" id="uniqueVisitors">—</h4>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-3 rounded bg-label-warning">
                            <div class="d-flex align-items-center">
                                <span class="avatar-initial rounded bg-warning me-3 avatar">
                                    <i class="icon-base bx bx-revision icon-md"></i>
                                </span>
                                <div>
                                    <h6 class="mb-0">Returning Visitors</h6>
                                    <small class="text-muted">Visited more than once</small>
                                </div>
                            </div>
                            <h4 class="mb-0" id="returningVisitors">—</h4>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Device Breakdown --}}
            <div class="col-sm-6 col-xxl-4 mb-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Device Breakdown</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <canvas id="deviceChart" style="max-height: 220px;"></canvas>
                    </div>
                </div>
            </div>

            {{-- Top Countries --}}
            <div class="col-sm-6 col-xxl-4 mb-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Top Countries</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0" id="countryList">
                            <li class="text-muted">Loading...</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        {{-- Top Pages --}}
        <div class="row mb-6">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Top Pages Visited</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Page URL</th>
                                        <th>Visits</th>
                                        <th>Share</th>
                                    </tr>
                                </thead>
                                <tbody id="topPagesTable">
                                    <tr><td colspan="4" class="text-muted">Loading...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var visitorsData = @json($visitorsData); // [2, 5, 3, 8, 12, 4, 1] - PHP se ata hai

            // Friday (max value) ko highlight karo
            var maxVal = Math.max(...visitorsData);
            var maxIndex = visitorsData.indexOf(maxVal);

            var colors = visitorsData.map((_, i) => i === maxIndex ? '#696cff' : '#3d3f6e');

            var options = {
                series: [{
                    data: visitorsData
                }],
                chart: {
                    type: 'bar',
                    height: 120,
                    width: 180,
                    toolbar: {
                        show: false
                    },
                    background: 'transparent'
                },
                plotOptions: {
                    bar: {
                        columnWidth: '55%',
                        borderRadius: 4,
                        distributed: true
                    }
                },
                colors: colors,
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                xaxis: {
                    categories: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
                    labels: {
                        style: {
                            colors: '#8c8fa3',
                            fontSize: '11px'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    show: false
                },
                grid: {
                    show: false
                },
                tooltip: {
                    enabled: true,
                    y: {
                        formatter: (val) => val + ' visitors'
                    }
                }
            };

            new ApexCharts(document.querySelector("#visitorsChart"), options).render();
        </script>
        <script>
            var activityData = @json($activityData);

            var maxVal = Math.max(...activityData);

            var activityOptions = {
                series: [{
                    name: 'New Users',
                    data: activityData
                }],
                chart: {
                    type: 'area',
                    height: 110,
                    width: 200,
                    toolbar: {
                        show: false
                    },
                    background: 'transparent'
                },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                    colors: ['#71dd37']
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        colorStops: [{
                                offset: 0,
                                color: '#71dd37',
                                opacity: 0.4
                            },
                            {
                                offset: 100,
                                color: '#71dd37',
                                opacity: 0.05
                            }
                        ]
                    }
                },
                colors: ['#71dd37'],
                dataLabels: {
                    enabled: false
                },
                markers: {
                    size: 0
                },
                xaxis: {
                    categories: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    labels: {
                        style: {
                            colors: '#8c8fa3',
                            fontSize: '11px'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    show: false
                },
                grid: {
                    show: false
                },
                tooltip: {
                    enabled: true,
                    y: {
                        formatter: (val) => val + ' new users'
                    }
                }
            };

            new ApexCharts(document.querySelector("#activityChart"), activityOptions).render();
        </script>

        <script>
            const BRAND_ID = {{ $brandId }};

            fetch("{{ route('admin.visitor-analytics') }}")
                .then(res => res.json())
                .then(data => {
                    // Numbers
                    document.getElementById('totalVisitors').innerText     = data.totalVisitors.toLocaleString();
                    document.getElementById('uniqueVisitors').innerText    = data.uniqueVisitors.toLocaleString();
                    document.getElementById('returningVisitors').innerText = data.returningVisitors.toLocaleString();

                    renderDevices(data.devices);
                    renderCountries(data.topCountries);
                    renderTopPages(data.topPages);
                });

            // Device Doughnut Chart
            function renderDevices(devices) {
                const labels = devices.map(d => d.device || 'Unknown');
                const counts = devices.map(d => d.total);
                const colors = ['#696cff', '#71dd37', '#ffab00', '#03c3ec', '#ff3e1d'];

                new Chart(document.getElementById('deviceChart'), {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: counts,
                            backgroundColor: colors,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        plugins: {
                            legend: { position: 'bottom' }
                        },
                        cutout: '70%'
                    }
                });
            }

            // Countries List
            function renderCountries(countries) {
                const total = countries.reduce((sum, c) => sum + c.total, 0);
                const html = countries.map((c, i) => `
                    <li class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-label-primary me-2">${i + 1}</span>
                            <span>${c.country || 'Unknown'}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress" style="width:80px; height:6px;">
                                <div class="progress-bar bg-primary" style="width:${Math.round((c.total/total)*100)}%"></div>
                            </div>
                            <small class="text-muted">${c.total}</small>
                        </div>
                    </li>
                `).join('');

                document.getElementById('countryList').innerHTML = html;
            }

            // Top Pages Table
            function renderTopPages(pages) {
                const total = pages.reduce((sum, p) => sum + p.total, 0);
                const html = pages.map((p, i) => `
                    <tr>
                        <td>${i + 1}</td>
                        <td>
                            <span class="text-truncate d-inline-block" style="max-width:400px;" title="${p.url}">
                                ${p.url}
                            </span>
                        </td>
                        <td><strong>${p.total.toLocaleString()}</strong></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:6px;">
                                    <div class="progress-bar bg-primary" style="width:${Math.round((p.total/total)*100)}%"></div>
                                </div>
                                <small>${Math.round((p.total/total)*100)}%</small>
                            </div>
                        </td>
                    </tr>
                `).join('');

                document.getElementById('topPagesTable').innerHTML = html;
            }
        </script>
    @endsection
