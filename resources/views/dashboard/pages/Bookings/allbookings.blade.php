          @extends('template')
          @section('dashboard-content')
          
          <!-- Bookings Page (Hidden by default) -->
            <div class="bookings-page" id="bookings-page">
                <div class="bookings-header">
                    <button class="back-btn">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </button>
                    <h1>All Bookings</h1>
                </div>

                <div class="data-table">
                    <div class="table-header">
                        <h3>All Bookings</h3>
                        <div class="chart-filter">
                            <button class="filter-btn active">All</button>
                            <button class="filter-btn">Completed</button>
                            <button class="filter-btn">Pending</button>
                            <button class="filter-btn">Cancelled</button>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Date & Time</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#CM001</td>
                                <td>John Smith</td>
                                <td>Deep Cleaning</td>
                                <td>12 Oct 2023, 10:00 AM</td>
                                <td>$120</td>
                                <td><span class="status completed">Completed</span></td>
                                <td>
                                    <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#CM002</td>
                                <td>Emma Johnson</td>
                                <td>Regular Cleaning</td>
                                <td>13 Oct 2023, 2:30 PM</td>
                                <td>$80</td>
                                <td><span class="status pending">Pending</span></td>
                                <td>
                                    <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#CM003</td>
                                <td>Robert Brown</td>
                                <td>Office Cleaning</td>
                                <td>13 Oct 2023, 9:00 AM</td>
                                <td>$200</td>
                                <td><span class="status in-progress">In Progress</span></td>
                                <td>
                                    <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#CM004</td>
                                <td>Sarah Davis</td>
                                <td>Carpet Cleaning</td>
                                <td>14 Oct 2023, 11:00 AM</td>
                                <td>$150</td>
                                <td><span class="status completed">Completed</span></td>
                                <td>
                                    <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#CM005</td>
                                <td>Michael Wilson</td>
                                <td>Move-in Cleaning</td>
                                <td>15 Oct 2023, 4:00 PM</td>
                                <td>$250</td>
                                <td><span class="status cancelled">Cancelled</span></td>
                                <td>
                                    <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#CM006</td>
                                <td>Jennifer Lee</td>
                                <td>Regular Cleaning</td>
                                <td>16 Oct 2023, 1:00 PM</td>
                                <td>$80</td>
                                <td><span class="status pending">Pending</span></td>
                                <td>
                                    <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#CM007</td>
                                <td>David Miller</td>
                                <td>Deep Cleaning</td>
                                <td>17 Oct 2023, 10:30 AM</td>
                                <td>$120</td>
                                <td><span class="status completed">Completed</span></td>
                                <td>
                                    <button class="action-btn view-btn"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            @endsection