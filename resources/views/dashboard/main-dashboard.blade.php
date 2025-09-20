@extends('template')
@section('dashboard-content')
    <div class="dashboard">
        <!-- Main Content -->
        <div class="main-content">

            <!-- Dashboard Content -->
            <div class="content" id="dashboard-content">
                <div class="page-title">
                    <h1>Dashboard Overview</h1>
                </div>

                <!-- Stats Cards -->
                <div class="stats-cards">
                    <div class="card">
                        <div class="stat-card">
                            <div class="stat-icon bookings">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="stat-info">
                                <h3>142</h3>
                                <p>Total Bookings</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="stat-card">
                            <div class="stat-icon revenue">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="stat-info">
                                <h3>$5,240</h3>
                                <p>Total Revenue</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="stat-card">
                            <div class="stat-icon users">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-info">
                                <h3>86</h3>
                                <p>Total Customers</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="stat-card">
                            <div class="stat-icon services">
                                <i class="fas fa-concierge-bell"></i>
                            </div>
                            <div class="stat-info">
                                <h3>12</h3>
                                <p>Services Offered</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Statistics -->
                <div class="chart-container">
                    <div class="chart-title">
                        <h3>Booking Statistics</h3>
                        <div class="chart-filter">
                            <button class="filter-btn active" data-period="weekly">Weekly</button>
                            <button class="filter-btn" data-period="monthly">Monthly</button>
                            <button class="filter-btn" data-period="yearly">Yearly</button>
                        </div>
                    </div>
                    <canvas id="bookingChart"></canvas>
                </div>

                <!-- Recent Data -->
                <div class="recent-data">
                    <div class="data-table">
                        <div class="table-header">
                            <h3>Recent Bookings</h3>
                            <a href="{{ route('allbookings') }}" class="see-all">View All <i
                                    class="fas fa-arrow-right"></i></a>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Date & Time</th>
                                    <th>Status</th>
                                    {{-- <th>Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Smith</td>
                                    <td>Deep Cleaning</td>
                                    <td>12 Oct 2023, 10:00 AM</td>
                                    <td><span class="status completed">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>Emma Johnson</td>
                                    <td>Regular Cleaning</td>
                                    <td>13 Oct 2023, 2:30 PM</td>
                                    <td><span class="status pending">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>Robert Brown</td>
                                    <td>Office Cleaning</td>
                                    <td>13 Oct 2023, 9:00 AM</td>
                                    <td><span class="status in-progress">In Progress</span></td>
                                </tr>
                                <tr>
                                    <td>Sarah Davis</td>
                                    <td>Carpet Cleaning</td>
                                    <td>14 Oct 2023, 11:00 AM</td>
                                    <td><span class="status completed">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>Michael Wilson</td>
                                    <td>Move-in Cleaning</td>
                                    <td>15 Oct 2023, 4:00 PM</td>
                                    <td><span class="status cancelled">Cancelled</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="data-table">
                        <div class="table-header">
                            <h3>Top Services</h3>
                            <a href="#" class="see-all">View All <i class="fas fa-arrow-right"></i></a>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Bookings</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Regular Cleaning</td>
                                    <td>56</td>
                                    <td>$1,820</td>
                                </tr>
                                <tr>
                                    <td>Deep Cleaning</td>
                                    <td>42</td>
                                    <td>$2,100</td>
                                </tr>
                                <tr>
                                    <td>Office Cleaning</td>
                                    <td>28</td>
                                    <td>$980</td>
                                </tr>
                                <tr>
                                    <td>Carpet Cleaning</td>
                                    <td>12</td>
                                    <td>$720</td>
                                </tr>
                                <tr>
                                    <td>Move-in Cleaning</td>
                                    <td>4</td>
                                    <td>$420</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Data for different time periods
        const chartData = {
            weekly: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                data: [12, 19, 15, 17, 14, 21, 25]
            },
            monthly: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                data: [45, 52, 60, 48]
            },
            yearly: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                data: [120, 145, 136, 152, 148, 160, 155, 168, 162, 142, 130, 158]
            }
        };

        // Chart initialization
        let bookingChart;

        function initChart(period) {
            const ctx = document.getElementById('bookingChart').getContext('2d');

            if (bookingChart) {
                bookingChart.destroy();
            }

            bookingChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData[period].labels,
                    datasets: [{
                        label: 'Bookings',
                        data: chartData[period].data,
                        backgroundColor: 'rgba(76, 175, 80, 0.2)',
                        borderColor: '#4CAF50',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#4CAF50',
                        pointRadius: 4,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: `Bookings (${period.charAt(0).toUpperCase() + period.slice(1)})`,
                            font: {
                                size: 16
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            title: {
                                display: true,
                                text: 'Number of Bookings'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // Initialize with weekly data
        initChart('weekly');

        // Add event listeners to filter buttons
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });

                // Add active class to clicked button
                this.classList.add('active');

                // Get the period from data attribute
                const period = this.getAttribute('data-period');

                // Update the chart
                initChart(period);
            });
        });
    </script>
@endsection
