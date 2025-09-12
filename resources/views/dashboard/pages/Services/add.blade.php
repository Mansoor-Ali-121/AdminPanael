<h2>Add Service</h2>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="serviceName">Service Name:</label>
        <input type="text" id="serviceName" name="service_name" class="form-control" required>
        <small></small>
    </div>
    <div class="form-group">
        <label for="serviceSlug">Service Slug which only add after https://servicefinders.ch/cleaning-services/<span
                style="color:red;">here</span>:</label>
        <input type="text" id="service_slug" name="service_slug" class="form-control" onkeyup="generateSlug()"
            required>
        <small></small>
    </div>
    <div class="form-group">
        <input class="form-control" type="text" name="actual_slug" id="actual_slug"
            placeholder="This will be your actual Slug" readonly>
    </div>
    <div class="form-group">
        <label for="bookingLink">Booking slug which only add after https://servicefinders.ch/booking/<span
                style="color:red;">here</span>:</label>
        <input type="text" id="bookingLink" name="booking_link" placeholder="only after /booking/"
            class="form-control" required>
        <small></small>
    </div>

    <div class="form-group">
        <label for="bookingpage">Select Booking Page:</label>
        <select id="bookingpage" name="booking_page" class="form-control" required>
            <option value="">-- Select Booking Page --</option>
            <option value="carpet-cleaning">Carpet Cleaning</option>
            <option value="moveout-cleaning">Moveout Cleaning</option>
            <option value="window-cleaning">Window Cleaning</option>
            <option value="deep-cleaning">Deep Cleaning</option>
            <option value="general-cleaning">General Cleaning</option>
        </select>
        <small></small>
    </div>

    <div class="form-group">
        <label for="description">Description:</label>
        <textarea name="description" class="form-control" cols="30" rows="10" required></textarea>
        <small></small>
    </div>
    <div class="form-group">
        <label for="serviceImage">Add Image:</label>
        <input type="file" id="serviceImage" name="service_image" class="form-control" required>
        <small class="error"></small>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    function generateSlug() {
        var packageName = document.getElementById('service_slug').value;
        var packageSlug = packageName.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        document.getElementById('actual_slug').value = packageSlug;
    }
</script>
