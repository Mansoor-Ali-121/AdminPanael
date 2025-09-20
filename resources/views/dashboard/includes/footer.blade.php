<footer class="footer">
    <div class="container text-center">
        <h2 class="footer-text">
            Blog Powered By
            <a href="https://appcoding.tech/" id="last" target="_blank">App Coding Tech</a>
        </h2>
    </div>
</footer>

{{-- Bootstrap & DataTables --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>

{{-- TinyMCE --}}
<script src="{{ asset('tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

{{-- Blogs Slug Generator --}}
<script>
    function generateBlogSlug() {
        const input = document.getElementById('actual_slug')?.value || '';
        const slug = input
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-'); // Collapse multiple hyphens

        const slugField = document.getElementById('blog_slug');
        if (slugField) {
            slugField.value = slug;
        }
    }
</script>

{{-- Categories Slug Generator --}}
<script>
    function generateCatSlug() {
        const input = document.getElementById('actual_slug')?.value || '';
        const slug = input
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '-') // Replace special characters with hyphens
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-'); // Collapse multiple hyphens

        const categoryField = document.getElementById('category_slug');
        if (categoryField) {
            categoryField.value = slug;
        }
    }
</script>

{{-- Booking Chart on dashboard --}}
<script>
    const bookingCtx = document.getElementById('bookingChart').getContext('2d');
    const bookingChart = new Chart(bookingCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            datasets: [{
                label: 'Monthly Bookings',
                data: [30, 45, 36, 52, 48, 60, 55, 68, 62, 42],
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
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
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

    // Service Chart
    const serviceCtx = document.getElementById('serviceChart').getContext('2d');
    const serviceChart = new Chart(serviceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Regular', 'Deep', 'Office', 'Carpet', 'Move-in'],
            datasets: [{
                data: [56, 42, 28, 12, 4],
                backgroundColor: [
                    '#4CAF50',
                    '#2196F3',
                    '#FF9800',
                    '#9C27B0',
                    '#F44336'
                ],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });
    
    // Add interactivity to filter buttons
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons in the same container
            this.parentElement.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            this.classList.add('active');
        });
    });
</script>
 <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
{{-- 🔽 Inject Page-Specific Scripts Here --}}
@yield('local-scripts')

</body>

</html>
