<footer class="footer">
    <div class="container text-center">
        <h2 class="footer-text">Blog Powered By <a href="https://appcoding.tech/" id="last" target="_blank">App Coding
                Tech</a></h2>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>


{{-- <script src="https://cdn.jsdelivr.net/npm/tinymce@8.0.2/tinymce.min.js"></script> --}}
<script src="{{ asset('tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
{{-- Editor --}}

<script>
    // Initialize TinyMCE for all textareas
    tinymce.init({
        selector: 'textarea:not(#news_description)',
        advcode_inline: true,
        plugins: 'searchreplace autolink directionality visualblocks visualchars image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap emoticons autosave fullscreen code',
        toolbar: "undo redo print spellcheckdialog formatpainter | blocks fontfamily fontsize | bold italic underline forecolor backcolor | link image | alignleft aligncenter alignright alignjustify | code | checklist numlist bullist indent outdent | table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
        file_picker_types: 'image',
        file_picker_callback: function(callback, value, meta) {
            if (meta.filetype === 'image') {
                // Open a file picker dialog
                openFilePicker(callback);
            }
        },
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [{
                value: 'First.Name',
                title: 'First Name'
            },
            {
                value: 'Email',
                title: 'Email'
            },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
            "See docs to implement AI Assistant")),
        content_css: [
            'data:text/css;charset=utf-8,' +
            encodeURIComponent('img { width: 100% !important; height: auto !important; }')
        ],
    });




    // Function to open file picker dialog
    function openFilePicker(callback) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function() {
            var file = this.files[0];

            if (window.FileReader) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Resize and compress image before passing it to TinyMCE
                    resizeImage(e.target.result, function(resizedImage) {
                        callback(resizedImage, {
                            alt: file.name
                        });
                    });
                };

                reader.readAsDataURL(file);
            } else {
                alert('FileReader is not supported in this browser.');
            }
        };

        input.click();
    }


    function resizeImage(base64Image, callback) {
        const img = new Image();
        img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            // Determine new dimensions
            let width = img.width;
            let height = img.height;
            const maxWidth = 1920;
            const maxHeight = 1080;

            if (width > maxWidth || height > maxHeight) {
                if (width / height > maxWidth / maxHeight) {
                    height = Math.round(maxWidth * (height / width));
                    width = maxWidth;
                } else {
                    width = Math.round(maxHeight * (width / height));
                    height = maxHeight;
                }
            }

            canvas.width = width;
            canvas.height = height;
            ctx.drawImage(img, 0, 0, width, height);

            // Convert canvas to base64 with compression
            const compressedImage = canvas.toDataURL('image/jpeg', 0.7); // Adjust quality here
            callback(compressedImage);
        };
        img.src = base64Image;
    }
</script>

{{-- Slug --}}
<script>
    function generateSlug() {
        const input = document.getElementById('blog_slug').value;

        // Slug generate karna
        let slug = input
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '') // Special characters hatao
            .replace(/\s+/g, '-') // Spaces ko hyphens mein convert karo
            .replace(/-+/g, '-'); // Multiple hyphens ko single hyphen karo

        // Slug ko preview field mein show karo
        document.getElementById('actual_slug').value = slug;
    }
</script>


</body>

</html>
