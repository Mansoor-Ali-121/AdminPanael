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
            .replace(/[^a-z0-9\s-]/g, '')  // Remove special characters
            .replace(/\s+/g, '-')          // Replace spaces with hyphens
            .replace(/-+/g, '-');          // Collapse multiple hyphens

        const slugField = document.getElementById('blog_slug');
        if (slugField) {
            slugField.value = slug;
        }
    }
</script>

{{-- Categories Slug Generator --}}
<script>
    function generateSlug() {
        const input = document.getElementById('actual_slug')?.value || '';
        const slug = input
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '-') // Replace special characters with hyphens
            .replace(/\s+/g, '-')         // Replace spaces with hyphens
            .replace(/-+/g, '-');         // Collapse multiple hyphens

        const categoryField = document.getElementById('category_slug');
        if (categoryField) {
            categoryField.value = slug;
        }
    }
</script>

{{-- 🔽 Inject Page-Specific Scripts Here --}}
@yield('local-scripts')

</body>
</html>
